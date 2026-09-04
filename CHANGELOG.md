# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v1.5.0](https://github.com/NexusPHP/assert/compare/v1.4.0...v1.5.0) - 2026-09-04

### Added
- `isNumericString()` expectation, narrowing to `numeric-string`. The runtime check is `is_string` + `is_numeric`, so it accepts exactly the values PHPStan counts as `numeric-string`, and unknown string literals prune to `never`
- `hasLength(int<1, max> $length)` expectation for exact byte lengths, narrowing to `non-falsy-string` (`non-empty-string` for a length of 1). The failure context carries `{length}` and `{actual}` (the measured length), so a custom message can report a mismatch without exporting a secret-bearing value
- `isNonEmptyMap()` expectation, narrowing to `non-empty-array<string, mixed>`
- `isGreaterThan()`, `isGreaterThanOrEqual()`, `isLessThan()`, and `isLessThanOrEqual()` expectations for one-sided numeric bounds, narrowing to the bounded int range OR'd with the float arm (e.g. `isGreaterThan(5)` gives `float|int<6, max>`). Chained bounds clamp: `isGreaterThanOrEqual(0)->isLessThanOrEqual(10)` narrows to `float|int<0, 10>`
- `hasCount(int<0, max> $count)`, `hasMinCount(int<0, max> $min)`, and `hasMaxCount(int<0, max> $max)` expectations for countables, narrowing to `array<mixed>|Countable`. A minimum of 1 or more and an exact count statically known to be positive narrow the array arm to `non-empty-array<mixed>`; `hasCount(0)` narrows it to `array{}`
- `isArrayAccessible()` expectation, narrowing to `array<mixed, mixed>|ArrayAccess`

## [v1.4.0](https://github.com/NexusPHP/assert/compare/v1.3.0...v1.4.0) - 2026-08-08

### Added
- `isNonEmptyList()` expectation, narrowing to `non-empty-list<mixed>`
- `isSameOrSubclassOf(class-string<T>|T $class)` expectation, the non-strict counterpart of `isSubclassOf`, narrowing to `class-string<T>|T` for the given class as well as its subclasses. Unlike `isSubclassOf`, a literal class argument also narrows under `not()`, to `mixed~(class-string<T>|T)`
- `implementsInterface(class-string<T> $interface)` expectation, narrowing to `class-string<T>`
- `isInstanceOfAny(non-empty-list<class-string> $classes)` expectation, narrowing to the union of the given classes, or to `object` when the list is not known statically
- `isClassString()` expectation, narrowing to `class-string`. Accepts interface names as well as class names, matching what PHPStan counts as a `class-string`

### Changed
- `ExpectationMethodResolver::__construct()` now takes a `PHPStan\Reflection\ReflectionProvider`. The service is autowired through `extension.neon`, so registration is unaffected

## [v1.3.0](https://github.com/NexusPHP/assert/compare/v1.2.0...v1.3.0) - 2026-08-05

### Added
- `isSubclassOf(class-string<T>|T $class)` expectation, narrowing to `class-string<T>|T` for objects and class strings that are a strict subclass of the given class

### Fixed
- Restored the chained double-negation narrowing reported in v1.2.0's known issues. On PHPStan 2.2.8 and later, `isInt()->not()->isNegativeInt()->isPositiveInt()` narrows to `0` again instead of `int<0, max>`, following the upstream fix for [phpstan/phpstan#15039](https://github.com/phpstan/phpstan/issues/15039)

## [v1.2.0](https://github.com/NexusPHP/assert/compare/v1.1.1...v1.2.0) - 2026-08-02

### Added
- `isIntOrNonEmptyString()` expectation, narrowing to `int|non-empty-string`

### Fixed
- Restored type narrowing on PHPStan 2.2.7, which changed how the type specifier composes `&&` and `||` conditions and left chained `not()` / `nullOr()` assertions widening back to their unnarrowed type

### Known issues
- On PHPStan 2.2.7, a chain that negates two overlapping ranges (e.g. `isInt()->not()->isNegativeInt()->isPositiveInt()`) keeps only the first negation, narrowing to `int<0, max>` rather than `0`. Tracked upstream at [phpstan/phpstan#15039](https://github.com/phpstan/phpstan/issues/15039)

## [v1.1.1](https://github.com/NexusPHP/assert/compare/v1.1.0...v1.1.1) - 2026-05-11

### Fixed
- Preserved `list<>`, `non-empty-list<>`, and `non-empty-array<>` shapes when narrowing through `keys()` / `values()`; previously the rebuilt iterable lost its accessory wrappers (e.g. `list<mixed>` downgraded to `array<int<0, max>, mixed>`)

## [v1.1.0](https://github.com/NexusPHP/assert/compare/v1.0.0...v1.1.0) - 2026-05-11

### Added
- `keys()` and `values()` iterating expectations to apply assertions across an iterable's keys or values
- `isBetween(float|int $min, float|int $max, bool $inclusive = true)` expectation for numeric range checks
- `isOneOf(non-empty-list<mixed> $choices)` expectation, with PHPStan narrowing to the union of literal allowed values when the list is constant
- `hasMinLength(int<1, max> $min)` and `hasMaxLength(int<1, max> $max)` expectations for bounded-string checks
- `isUrl()` expectation, backed by `filter_var($value, FILTER_VALIDATE_URL)`

### Fixed
- Improved failure-message wording for iterating expectations (`keys()`, `values()`) to clearly indicate which key or value triggered the failure

## [v1.0.0](https://github.com/NexusPHP/assert/releases/tag/v1.0.0) - 2026-03-15

### Added
- Initial release of Nexus Assert library
- Chainable type-safety assertions API
- Dynamic method return type extensions for PHPStan support
- Type inference for fluent assertions
- Support for PHP 8.2+
