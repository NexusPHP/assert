<?php

declare(strict_types=1);

/**
 * This file is part of the Nexus Assert library.
 *
 * (c) 2025 John Paul E. Balandan, CPA <paulbalandan@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Nexus\Assert\Type;

use Nexus\Assert\KeysIteratingExpectation;
use Nexus\Assert\NegatedExpectation;
use Nexus\Assert\NullableExpectation;
use Nexus\Assert\ValuesIteratingExpectation;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Type\Accessory\AccessoryArrayListType;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NeverType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;

final class ExpectationMethodResolver
{
    /**
     * Methods whose narrowing predicate must be paired with a synthetic
     * `FAUX_FUNCTION_<method>` call so PHPStan threads them through the
     * chained `storedExpr`.
     */
    private const METHODS_NEEDING_FAUX_WRAP = [
        'contains',
        'endsWith',
        'hasMaxLength',
        'hasMinLength',
        'isUrl',
        'matchesRegularExpression',
        'startsWith',
    ];

    private const UNSUPPORTED_EXPECTATION_METHODS = [
        'not',
        'nullOr',
    ];
    private const ITERATING_VARIANT_CLASSES = [
        KeysIteratingExpectation::class,
        ValuesIteratingExpectation::class,
    ];

    /**
     * @var array<string, Resolver\ResolverInterface>
     */
    private array $resolvers;

    public function __construct()
    {
        $this->resolvers = self::createExprResolvers();
    }

    public function isSupported(string $methodName): bool
    {
        return ! \in_array($methodName, self::UNSUPPORTED_EXPECTATION_METHODS, true)
            && \array_key_exists($methodName, $this->resolvers);
    }

    /**
     * @param class-string $expectationClass
     */
    public function resolveExpr(
        string $expectationClass,
        string $methodName,
        ?Node\Expr $storedExpr,
        Scope $scope,
        Node\Arg $arg,
        Node\Arg ...$args,
    ): ?Node\Expr {
        if (! $this->isSupported($methodName)) {
            return null; // do not throw on yet unsupported methods
        }

        $expr = $this->resolvers[$methodName]->resolve($scope, $arg, ...$args);

        if (\in_array($methodName, self::METHODS_NEEDING_FAUX_WRAP, true)) {
            $expr = new Node\Expr\BinaryOp\BooleanAnd(
                $expr,
                new Node\Expr\FuncCall(
                    new Node\Name(\sprintf('FAUX_FUNCTION_%s', $methodName)),
                    isset($args[0]) ? [$arg, $args[0]] : [$arg],
                ),
            );
        }

        if (NegatedExpectation::class === $expectationClass) {
            $expr = new Node\Expr\BooleanNot($expr);
        } elseif (NullableExpectation::class === $expectationClass) {
            $expr = new Node\Expr\BinaryOp\BooleanOr(
                new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\ConstFetch(new Node\Name('null')),
                    $arg->value,
                ),
                $expr,
            );
        }

        return self::reduceExprWithStoredExpr($storedExpr, $expr);
    }

    public function isFauxWrapped(string $methodName): bool
    {
        return \in_array($methodName, self::METHODS_NEEDING_FAUX_WRAP, true);
    }

    public function resolveType(
        Node\Expr $resolvedExpr,
        Type $originalType,
        Scope $scope,
        Node\Arg $arg,
    ): Type {
        $narrowed = $scope->filterByTruthyValue($resolvedExpr)->getType($arg->value);

        return TypeCombinator::intersect($originalType, $narrowed);
    }

    public static function isIteratingVariant(string $className): bool
    {
        return \in_array($className, self::ITERATING_VARIANT_CLASSES, true);
    }

    /**
     * @return null|array{Type, Node\Expr}
     */
    public function narrowIterating(
        Scope $scope,
        ExpectationObjectType $calledOnType,
        string $methodName,
        Node\Arg ...$args,
    ): ?array {
        $valueExpr = $calledOnType->getValueExpr();
        $iteratingClass = $calledOnType->getClassName();
        \assert(class_exists($iteratingClass));

        // Faux variable: unknown to scope, so PHPStan's OR-specifier cannot prune
        // disjuncts as impossible against the iterable's outer type. Returns the
        // predicate's pure narrowing type (e.g. int|string for isArrayKey).
        $fauxExpr = new Node\Expr\Variable('__faux_iterating_value__');
        $fauxPredicate = $this->resolveExpr(
            $iteratingClass,
            $methodName,
            null,
            $scope,
            new Node\Arg($fauxExpr),
            ...$args,
        );

        if (null === $fauxPredicate) {
            return null;
        }

        $innerType = $scope->filterByTruthyValue($fauxPredicate)->getType($fauxExpr);

        // ErrorType extends MixedType, so an unresolvable faux variable lands here too.
        if ($innerType instanceof MixedType) {
            return null;
        }

        $newType = self::rebuildIterable(
            $calledOnType->getTypes()[0],
            KeysIteratingExpectation::class === $iteratingClass,
            $innerType,
        );

        if (null === $newType) {
            return null;
        }

        $storedPredicate = $this->resolveExpr(
            $iteratingClass,
            $methodName,
            null,
            $scope,
            new Node\Arg($valueExpr),
            ...$args,
        );
        \assert(null !== $storedPredicate);

        return [$newType, self::reduceExprWithStoredExpr($calledOnType->getStoredExpr(), $storedPredicate)];
    }

    public function specifyIteratingOuter(
        TypeSpecifier $typeSpecifier,
        Scope $scope,
        ExpectationObjectType $calledOnType,
        string $methodName,
        Node\Arg ...$args,
    ): SpecifiedTypes {
        $narrowed = $this->narrowIterating($scope, $calledOnType, $methodName, ...$args);

        if (null === $narrowed) {
            $storedExpr = $calledOnType->getStoredExpr();

            if (null === $storedExpr) {
                return new SpecifiedTypes();
            }

            return $typeSpecifier
                ->specifyTypesInCondition($scope, $storedExpr, TypeSpecifierContext::createTruthy())
                ->setRootExpr($storedExpr)
            ;
        }

        [$newType, $newStoredExpr] = $narrowed;

        return $typeSpecifier
            ->create($calledOnType->getValueExpr(), $newType, TypeSpecifierContext::createTruthy(), $scope)
            ->setRootExpr($newStoredExpr)
        ;
    }

    private static function reduceExprWithStoredExpr(?Node\Expr $storedExpr, Node\Expr $expr): Node\Expr
    {
        if (null === $storedExpr) {
            return $expr;
        }

        return new Node\Expr\BinaryOp\BooleanAnd($storedExpr, $expr);
    }

    private static function rebuildIterable(
        Type $wrappedType,
        bool $narrowKey,
        Type $innerType,
    ): ?Type {
        $iterable = new IterableType(new MixedType(), new MixedType());
        $currentType = TypeCombinator::intersect($wrappedType, $iterable);

        if (! $iterable->isSuperTypeOf($currentType)->yes()) {
            return null;
        }

        $arrayKeyConstraint = new BenevolentUnionType([new IntegerType(), new StringType()]);

        $resultTypes = [];

        // Walk union branches so per-branch list/non-empty accessories survive;
        // `getArrays()` flattens intersections and drops them.
        $branches = $currentType instanceof UnionType
            ? $currentType->getTypes()
            : [$currentType];

        foreach ($branches as $branch) {
            if (! $branch->isArray()->yes()) {
                continue;
            }

            $branchIsList = $branch->isList()->yes();
            $branchIsNonEmpty = $branch->isIterableAtLeastOnce()->yes();

            foreach ($branch->getArrays() as $arrayType) {
                $constantArrays = $arrayType->getConstantArrays();

                if (\count($constantArrays) === 1) {
                    $rebuilt = self::rebuildConstantArray($constantArrays[0], $narrowKey, $innerType, $arrayKeyConstraint);

                    if (null !== $rebuilt) {
                        $resultTypes[] = $rebuilt;
                    }

                    continue;
                }

                if ($narrowKey) {
                    $newKeyType = TypeCombinator::intersect($arrayType->getKeyType(), $innerType, $arrayKeyConstraint);
                    $newValueType = $arrayType->getItemType();
                } else {
                    $newKeyType = $arrayType->getKeyType();
                    $newValueType = TypeCombinator::intersect($arrayType->getItemType(), $innerType);
                }

                if ($newKeyType instanceof NeverType || $newValueType instanceof NeverType) {
                    continue;
                }

                $resultTypes[] = self::applyArrayAccessories(
                    new ArrayType($newKeyType, $newValueType),
                    $branchIsList,
                    $branchIsNonEmpty,
                );
            }
        }

        if (! $currentType->isArray()->yes()) {
            if ($narrowKey) {
                $newKeyType = TypeCombinator::intersect($currentType->getIterableKeyType(), $innerType);
                $newValueType = $currentType->getIterableValueType();
            } else {
                $newKeyType = $currentType->getIterableKeyType();
                $newValueType = TypeCombinator::intersect($currentType->getIterableValueType(), $innerType);
            }

            if (! ($newKeyType instanceof NeverType) && ! ($newValueType instanceof NeverType)) {
                $resultTypes[] = new IterableType($newKeyType, $newValueType);
            }
        }

        if ([] === $resultTypes) {
            return new NeverType();
        }

        return TypeCombinator::union(...$resultTypes);
    }

    private static function applyArrayAccessories(
        Type $array,
        bool $isList,
        bool $isNonEmpty,
    ): Type {
        $accessories = [];

        if ($isNonEmpty) {
            $accessories[] = new NonEmptyArrayType();
        }

        if ($isList) {
            $accessories[] = new AccessoryArrayListType();
        }

        if ([] === $accessories) {
            return $array;
        }

        return TypeCombinator::intersect($array, ...$accessories);
    }

    private static function rebuildConstantArray(
        ConstantArrayType $constantArray,
        bool $narrowKey,
        Type $innerType,
        Type $arrayKeyConstraint,
    ): ?Type {
        $builder = ConstantArrayTypeBuilder::createEmpty();

        foreach ($constantArray->getKeyTypes() as $i => $keyType) {
            $valueType = $constantArray->getValueTypes()[$i];
            $isOptional = $constantArray->isOptionalKey($i);

            if ($narrowKey) {
                $newKeyType = TypeCombinator::intersect($keyType, $innerType, $arrayKeyConstraint);

                if ($newKeyType instanceof NeverType) {
                    if ($isOptional) {
                        continue;
                    }

                    return null;
                }

                $newValueType = $valueType;
            } else {
                $newKeyType = $keyType;
                $newValueType = TypeCombinator::intersect($valueType, $innerType);

                if ($newValueType instanceof NeverType) {
                    if ($isOptional) {
                        continue;
                    }

                    return null;
                }
            }

            $builder->setOffsetValueType($newKeyType, $newValueType, $isOptional);
        }

        return $builder->getArray();
    }

    /**
     * @return array<string, Resolver\ResolverInterface>
     */
    private static function createExprResolvers(): array
    {
        $isArray = new Resolver\IsArrayResolver();
        $isFloat = new Resolver\IsFloatResolver();
        $isInt = new Resolver\IsIntResolver();
        $isIterable = new Resolver\IsIterableResolver();
        $isObject = new Resolver\IsObjectResolver();
        $isString = new Resolver\IsStringResolver();
        $isList = new Resolver\IsListResolver($isArray);
        $isNonEmptyString = new Resolver\IsNonEmptyStringResolver($isString);
        $isSameOrSubclassOf = new Resolver\IsSameOrSubclassOfResolver();

        $stringDispatching = new Resolver\StringDispatchingResolver($isString, $isNonEmptyString);

        return [
            'contains' => $stringDispatching,
            'endsWith' => $stringDispatching,
            'hasMaxLength' => new Resolver\HasMaxLengthResolver($isString),
            'hasMethod' => new Resolver\HasMethodResolver($isObject),
            'hasMinLength' => new Resolver\HasMinLengthResolver($isString),
            'hasOffset' => new Resolver\HasOffsetResolver($isArray),
            'hasProperty' => new Resolver\HasPropertyResolver($isObject),
            'implementsInterface' => new Resolver\ImplementsInterfaceResolver($isString, $isSameOrSubclassOf),
            'isArray' => $isArray,
            'isArrayKey' => new Resolver\IsArrayKeyResolver($isInt, $isString),
            'isBetween' => new Resolver\IsBetweenResolver($isInt, $isFloat),
            'isBool' => new Resolver\IsBoolResolver(),
            'isCallable' => new Resolver\IsCallableResolver(),
            'isCountable' => new Resolver\IsCountableResolver(),
            'isFalse' => new Resolver\IsFalseResolver(),
            'isFloat' => $isFloat,
            'isIdentical' => new Resolver\IsIdenticalResolver(),
            'isInstanceOf' => new Resolver\IsInstanceOfResolver(),
            'isInt' => $isInt,
            'isIntOrNonEmptyString' => new Resolver\IsIntOrNonEmptyStringResolver($isInt, $isNonEmptyString),
            'isIterable' => $isIterable,
            'isList' => $isList,
            'isLowercaseString' => new Resolver\IsLowercaseStringResolver($isString),
            'isMap' => new Resolver\IsMapResolver($isArray),
            'isNaturalInt' => new Resolver\IsNaturalIntResolver($isInt),
            'isNegativeInt' => new Resolver\IsNegativeIntResolver($isInt),
            'isNonEmptyList' => new Resolver\IsNonEmptyListResolver($isList),
            'isNonEmptyString' => $isNonEmptyString,
            'isNull' => new Resolver\IsNullResolver(),
            'isNumeric' => new Resolver\IsNumericResolver(),
            'isObject' => $isObject,
            'isOneOf' => new Resolver\IsOneOfResolver(),
            'isPositiveInt' => new Resolver\IsPositiveIntResolver($isInt),
            'isResource' => new Resolver\IsResourceResolver(),
            'isSameOrSubclassOf' => $isSameOrSubclassOf,
            'isScalar' => new Resolver\IsScalarResolver(),
            'isString' => $isString,
            'isSubclassOf' => new Resolver\IsSubclassOfResolver(),
            'isTrue' => new Resolver\IsTrueResolver(),
            'isUppercaseString' => new Resolver\IsUppercaseStringResolver($isString),
            'isUrl' => new Resolver\IsUrlResolver($isString),
            'matchesRegularExpression' => $isString,
            'startsWith' => $stringDispatching,
            // iterating variant methods (`keys`, `values`) just assert the
            // outer value is iterable; the element-narrowing happens in
            // `narrowIterating` against the next method's resolver.
            'keys' => $isIterable,
            'values' => $isIterable,
        ];
    }
}
