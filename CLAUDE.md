# Nexus Assert

Chainable type-safety assertion library with first-class PHPStan support. Each runtime assertion is paired with a PHPStan extension that narrows `$v` to the asserted type in the surrounding scope.

## Layout

- `src/` — runtime library code.
  - `Assert.php`, `Expectation.php` — entry points. `Assert::that()` returns an `Expectation<T>`.
  - `Expectable.php` — interface defining every assertion method (`isInt`, `isString`, `hasOffset`, etc.). The canonical surface; adding an assertion starts here.
  - `MutatingExpectable.php` — interface for state-changing chain methods (`not`, `nullOr`, `keys`, `values`). Implemented only by the base `Expectation`.
  - `Expectation.php` — hand-written base; everything else is generated from it.
  - `NegatedExpectation.php`, `NullableExpectation.php`, `KeysIteratingExpectation.php`, `ValuesIteratingExpectation.php` — **all auto-generated**, marked `@auto-generated`. Do not edit by hand.
  - `Exporter.php` / `ExporterInterface.php` — value/type formatting for failure messages.
  - `src/Type/` — PHPStan extension code (see below).
  - `src/Type/Resolver/` — one `ResolverInterface` implementation per `Expectable` method (`IsIntResolver`, `HasOffsetResolver`, etc.). Each builds the synthetic predicate AST for its method. Composite resolvers receive their dependencies via constructor injection (e.g. `IsArrayKeyResolver(IsIntResolver, IsStringResolver)`). `StringDispatchingResolver` is shared by `contains`/`startsWith`/`endsWith`.
- `tools/` — code-gen & devtools, not shipped at runtime.
  - `tools/src/ExpectationVariantsGenerator.php` — generates the four variant classes.
  - `tools/src/ReadmeGenerator.php` — generates `README.md` from `tools/resources/README.md.tpl`.
- `bin/generate`, `bin/generate-readme` — entry scripts for the generators.
- `tests/` — PHPUnit + PHPStan fixtures (see "Tests" below).
- `extension.neon` — PHPStan extension registration. New `Type/` services go here.

## Adding or modifying an assertion

The canonical order is **interface → base → regenerate → tests → resolver → fixtures**. The resolver work belongs at the end, not before generation; it surfaces requirements (e.g. multi-arg predicates) naturally only once the runtime behaviour is in place and exercised.

1. **Interface.** Add the method to `src/Expectable.php` with full PHPDoc (`@param`, `@return self<TValue>`, `@throws`).
2. **Base implementation.** Add the method and its `MESSAGE_<CONSTANT>` to `src/Expectation.php`. The constant message should use the default `{value}`/`{type}` placeholders unless a more specific shape is needed.
3. **Regenerate variants.** Run `composer generate:docs`. This rewrites `NegatedExpectation`, `NullableExpectation`, `KeysIteratingExpectation`, `ValuesIteratingExpectation`, and `README.md`. **Never** edit those files by hand. There is a known catch-22: the generator loads `Expectation`, which triggers PHP's interface-conformance check on the four variants, which still lack the new method. Bridge it by adding one-line stubs to each variant first, e.g. `public function isFoo(...): self { return $this; }`. The generator overwrites them.
4. **Unit tests.** Add a `test_<methodName>` to all five test files (`ExpectationTest`, `NegatedExpectationTest`, `NullableExpectationTest`, `KeysIteratingExpectationTest`, `ValuesIteratingExpectationTest`). Method order in each file is enforced by `ExpectableAutoReviewTest`.
5. **PHPStan resolver.** If the assertion needs type narrowing, add a `FooResolver` class in `src/Type/Resolver/` implementing `ResolverInterface::resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr`. Wire it into `ExpectationMethodResolver::__construct()`'s `$this->resolvers` map under the method name. Conventions:
   - If the new resolver depends on others (e.g. `isList` needs `isArray`, `isBetween` needs `isInt`+`isFloat`), accept them as readonly constructor parameters and reuse the shared instances created at the top of `__construct`.
   - If the assertion is a simple alias whose narrowing is identical to another (e.g. `matchesRegularExpression` reuses `IsStringResolver`), point the map entry at the existing instance instead of creating a new class.
   - If the method needs a `FAUX_FUNCTION_*` faux-call to disambiguate it in chained predicates (e.g. `contains`, `startsWith` both narrow to `string`), add its name to `ExpectationMethodResolver::METHODS_NEEDING_FAUX_WRAP`.
   - If the message uses non-default placeholders, register them in `ExpectationVariantsGenerator::NON_DEFAULT_CONTEXT` (`'value+'` = type-exported, `'name='` = integrated as-is, plain name = value-exported) and **re-run `composer generate:docs`** so the variants pick up the new context. Note: integrated-as-is (`'name='`) markers must correspond to actual method parameter names. A context key derived from the asserted value (e.g. `{actual}`) goes in `ExpectationVariantsGenerator::COMPUTED_CONTEXT` as an sprintf template over the value expression.
6. **Type-inference fixtures.** Add a `test_<method>` to each of the five fixture files under `tests/data/type-inference/` with `assertType(...)` calls on both the assertion result and the narrowed value. `ExpectableAutoReviewTest::testTypeInferenceFixturesCoverEveryMethod` enforces coverage.

Finally run `composer test:all` and fix any drift (CS, PHPStan, unit, auto-review, type-inference).

The set of methods that are *unreachable on PHP arrays when iterating keys* (because array keys are constrained to `int|string`) lives in `ExpectationVariantsGenerator::KEYS_UNREACHABLE_FOR_ARRAYS`. Those methods throw `\LogicException` at runtime on arrays; they remain valid on non-array iterables.

## PHPStan extension architecture

Three extensions in `src/Type/`, registered in `extension.neon`:

- `AssertDynamicStaticMethodReturnTypeExtension` — types the return of `Assert::that($x)` as `ExpectationObjectType` carrying the AST of `$x`.
- `ExpectationDynamicMethodReturnTypeExtension` — types the return of every chainable method on an `Expectable`. Mutating methods (`not`, `nullOr`, `keys`, `values`) wrap the existing `ExpectationObjectType`; assertion methods narrow the wrapped type.
- `ExpectationMethodTypeSpecifyingExtension` — narrows the wrapped *value's* scope-type (the variable passed to `Assert::that()`), so callers see the narrowing on subsequent statements.

Both `*MethodReturn*` and `*TypeSpecifying*` extensions delegate to `ExpectationMethodResolver`. The resolver is an orchestrator that:
- holds a `method-name => ResolverInterface` map built in its constructor (`src/Type/Resolver/*` are the implementations; see Layout above),
- dispatches to the right resolver in `resolveExpr`, which builds the per-method predicate AST,
- handles negation / null-or wrapping around the predicate,
- accumulates predicates across the chain via `reduceExprWithStoredExpr` and the `storedExpr` carried on `ExpectationObjectType`,
- wraps the predicate with a `FAUX_FUNCTION_<method>` call for methods listed in `METHODS_NEEDING_FAUX_WRAP` so they remain distinguishable in chained narrowings,
- for iterating variants (`keys`/`values`), runs `narrowIterating` to compute the rebuilt iterable type using a **faux variable** trick (see comment at `narrowIterating`): the predicate is specified against a synthetic `Variable` so PHPStan's OR-handling cannot prune disjuncts as impossible against the iterable's outer type. Use `ExpectationMethodResolver::isIteratingVariant()` for class-membership tests; don't inline the class list.

`ExpectationObjectType` is a custom `GenericObjectType` that carries `(className, types, valueExpr, storedExpr)`. `valueExpr` is the AST of the original `Assert::that($x)` argument; `storedExpr` is the cumulative `BooleanAnd` of all predicates in the chain. These let mid-chain methods see and extend prior narrowings.

When a method's narrowing collapses to `NeverType`, both extensions return `new NeverType(true)` directly (not `ExpectationObjectType<NeverType>`), so PHPStan reports the call as unreachable.

## Tests

Run with `composer test:all` (cs → phpstan → unit → auto-review → type-inference). Individual targets: `composer test:unit`, `composer test:auto-review`, `composer test:stan`.

**Layout & conventions:**

- One `test_<methodName>` per public `Expectable` method per file.
- Unit tests for each `Expectable` implementer extend `AbstractExpectationTestCase`, which provides:
  - `assertNoErrorsThrown(\Closure $cb)` — happy-path helper.
  - `assertExpectationFails(\Closure $cb, string $message)` — failure-path helper with full-message match.
- Test files: one per implementer (`ExpectationTest`, `NegatedExpectationTest`, `NullableExpectationTest`, `KeysIteratingExpectationTest`, `ValuesIteratingExpectationTest`). Method order follows the auto-review test (constructor → mutating methods in declared order → alphabetical).
- For tests with multiple cases per method, use parameter naming `mixed $value1, mixed $value2, …` and local names `$assert1, $assert2, …` (not `$a, $b`).

**Type-inference fixtures** live at `tests/data/type-inference/`:

- `expectation.php`, `negated-expectation.php`, `nullable-expectation.php`, `keys-iterating-expectation.php`, `values-iterating-expectation.php` — one `test_<method>(mixed $value): void` per Expectable method, with `assertType(...)` calls on both the assertion result and the narrowed argument.
- `chained-expectation.php` — multi-step chain effects that aren't tied to a single method (e.g. `isInt()->not()->isPositiveInt()`).
- `is-identical-expectation.php`, `is-instance-of-expectation.php` — focused fixtures for non-typical methods.
- Fixtures use bare functions in a per-file namespace `Nexus\Assert\Tests\TypeInference\<PascalCase>` — not classes.

**Auto-review tests** (`tests/ExpectableAutoReviewTest.php`) act as drift detectors:

- `testExpectationMethodsAreArrangedInOrder` — enforces method ordering on each variant class.
- `testExpectationTestMethodsAreArrangedInOrder` — same for the corresponding test class.
- `testTypeInferenceFixturesCoverEveryMethod` — every `Expectable` method must have a fixture in each variant's fixture file. Detection uses a `Assert::that(\(…\))->method(` regex (recursive-paren) for the bare `Expectation` case and a `->variant()->method(` substring for the others.

`tests/ReadmeAutoReviewTest.php` validates that the generated `README.md` is in sync with the template.

## CS, PHPStan, and writing rules

- Coding style: `composer cs:check` / `composer cs:fix`. Config: `.php-cs-fixer.dist.php` (Nexus PHP 8.2 ruleset). Always passes before merge.
- PHPStan: `composer phpstan:check`. Level 10. Baseline at `phpstan-baseline.php`; regenerate with `composer phpstan:baseline` only when an unavoidable false-positive accumulates — never to silence a real error.
- The custom-error ignores section in `phpstan.dist.neon` is reserved for test files that intentionally call already-narrowed types (`method.alreadyNarrowedType`, `method.impossibleType`). Don't add suppressions for `src/`.
- Comments: explain *why* the code is non-obvious, never *what* it does. PHPDocs should not contain design rationale (move that to commit messages or PR descriptions); keep them to `@param`/`@return`/`@throws`/`@template` and one-line summaries.
- Test coverage: 100% on `src/`. Pipeline failures from missing coverage (e.g. uncovered foreach bodies on non-array iterables) should be fixed by adding tests, not by lowering the threshold.

## Debug / scratch files

Use `tmp/` at the repo root for one-off PHPStan reproduction scripts or coverage inspection helpers. Don't drop them into `tests/data/`.

## Composer scripts (canonical entry points)

| Script                         | Purpose                                                                                   |
| ------------------------------ | ----------------------------------------------------------------------------------------- |
| `composer test:all`            | Full pipeline: cs, phpstan, unit, auto-review, type-inference.                            |
| `composer test:unit`           | PHPUnit `@unit` group with coverage.                                                      |
| `composer test:auto-review`    | Drift-detection tests.                                                                    |
| `composer test:stan`           | PHPStan type-inference assertions.                                                        |
| `composer cs:check` / `cs:fix` | php-cs-fixer in check / fix mode.                                                         |
| `composer phpstan:check`       | PHPStan analysis.                                                                         |
| `composer phpstan:baseline`    | Regenerate `phpstan-baseline.php`.                                                        |
| `composer generate:docs`       | Regenerate all variant classes (`bin/generate --all`) and README (`bin/generate-readme`). |

Prefer these over invoking `vendor/bin/phpunit` or `vendor/bin/phpstan` directly so config is consistent.
