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
            \assert(isset($args[0]));

            $expr = new Node\Expr\BinaryOp\BooleanAnd(
                $expr,
                new Node\Expr\FuncCall(
                    new Node\Name(\sprintf('FAUX_FUNCTION_%s', $methodName)),
                    [$arg, $args[0]],
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

    /**
     * @param class-string $expectationClass
     */
    public function resolveType(
        TypeSpecifier $typeSpecifier,
        Node\Expr $resolvedExpr,
        Type $originalType,
        string $expectationClass,
        Scope $scope,
        Node\Arg $arg,
    ): Type {
        $context = TypeSpecifierContext::createTruthy();
        $specifiedTypes = $typeSpecifier->specifyTypesInCondition($scope, $resolvedExpr, $context);

        if (NegatedExpectation::class === $expectationClass) {
            $type = $originalType;

            foreach ($specifiedTypes->getSureNotTypes() as [$expr, $sureNotType]) {
                if ($expr === $arg->value) {
                    $type = TypeCombinator::remove($type, $sureNotType);
                }
            }

            foreach ($specifiedTypes->getSureTypes() as [$expr, $sureType]) {
                if ($expr === $arg->value) {
                    $type = TypeCombinator::intersect($type, $sureType);
                }
            }

            return $type;
        }

        $sureType = self::findSureTypeFor($specifiedTypes, $arg->value);

        if (null === $sureType) {
            return $originalType;
        }

        $type = TypeCombinator::intersect($originalType, $sureType);

        if (NullableExpectation::class === $expectationClass) {
            return TypeCombinator::addNull($type);
        }

        return $type;
    }

    public static function isIteratingVariant(string $className): bool
    {
        return \in_array($className, self::ITERATING_VARIANT_CLASSES, true);
    }

    /**
     * @return null|array{Type, Node\Expr}
     */
    public function narrowIterating(
        TypeSpecifier $typeSpecifier,
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

        $specifiedTypes = $typeSpecifier->specifyTypesInCondition(
            $scope,
            $fauxPredicate,
            TypeSpecifierContext::createTruthy(),
        );

        $innerType = self::findSureTypeFor($specifiedTypes, $fauxExpr);

        if (null === $innerType) {
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
        $narrowed = $this->narrowIterating($typeSpecifier, $scope, $calledOnType, $methodName, ...$args);

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

    private static function findSureTypeFor(SpecifiedTypes $specifiedTypes, Node\Expr $target): ?Type
    {
        $sureNotTypes = $specifiedTypes->getSureNotTypes();
        $matches = [];

        foreach ($specifiedTypes->getSureTypes() as $key => [$expr, $type]) {
            if ($expr !== $target) {
                continue;
            }

            $matches[] = TypeCombinator::remove($type, $sureNotTypes[$key][1] ?? new NeverType());
        }

        if ([] === $matches) {
            return null;
        }

        return TypeCombinator::union(...$matches);
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

        foreach ($currentType->getArrays() as $arrayType) {
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

            $resultTypes[] = new ArrayType($newKeyType, $newValueType);
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
        $isNonEmptyString = new Resolver\IsNonEmptyStringResolver($isString);

        $stringDispatching = new Resolver\StringDispatchingResolver($isString, $isNonEmptyString);

        return [
            'contains' => $stringDispatching,
            'endsWith' => $stringDispatching,
            'hasMethod' => new Resolver\HasMethodResolver($isObject),
            'hasOffset' => new Resolver\HasOffsetResolver($isArray),
            'hasProperty' => new Resolver\HasPropertyResolver($isObject),
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
            'isIterable' => $isIterable,
            'isList' => new Resolver\IsListResolver($isArray),
            'isLowercaseString' => new Resolver\IsLowercaseStringResolver($isString),
            'isMap' => new Resolver\IsMapResolver($isArray),
            'isNaturalInt' => new Resolver\IsNaturalIntResolver($isInt),
            'isNegativeInt' => new Resolver\IsNegativeIntResolver($isInt),
            'isNonEmptyString' => $isNonEmptyString,
            'isNull' => new Resolver\IsNullResolver(),
            'isNumeric' => new Resolver\IsNumericResolver(),
            'isObject' => $isObject,
            'isPositiveInt' => new Resolver\IsPositiveIntResolver($isInt),
            'isResource' => new Resolver\IsResourceResolver(),
            'isScalar' => new Resolver\IsScalarResolver(),
            'isString' => $isString,
            'isTrue' => new Resolver\IsTrueResolver(),
            'isUppercaseString' => new Resolver\IsUppercaseStringResolver($isString),
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
