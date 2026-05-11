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
    public const METHODS_USING_PRIMARY_RESOLVERS = [
        'matchesRegularExpression' => 'isString',
    ];
    public const METHODS_USING_STRING_RESOLVERS = [
        'contains',
        'endsWith',
        'startsWith',
    ];
    private const UNSUPPORTED_EXPECTATION_METHODS = [
        'not',
        'nullOr',
    ];
    private const ITERATING_VARIANT_METHODS = [
        'keys',
        'values',
    ];
    private const ITERATING_VARIANT_CLASSES = [
        KeysIteratingExpectation::class,
        ValuesIteratingExpectation::class,
    ];

    /**
     * @var array<string, callable(Scope, Node\Arg, Node\Arg): Node\Expr>
     */
    private static array $resolvers = [];

    public function __construct()
    {
        self::createExprResolvers();
    }

    public function isSupported(string $methodName): bool
    {
        return ! \in_array($methodName, self::UNSUPPORTED_EXPECTATION_METHODS, true)
            && \array_key_exists($methodName, self::$resolvers);
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
        Node\Arg $other,
    ): ?Node\Expr {
        if (! $this->isSupported($methodName)) {
            return null; // do not throw on yet unsupported methods
        }

        $expr = self::$resolvers[$methodName]($scope, $arg, $other);

        if (
            \array_key_exists($methodName, self::METHODS_USING_PRIMARY_RESOLVERS)
            || \in_array($methodName, self::METHODS_USING_STRING_RESOLVERS, true)
        ) {
            $expr = new Node\Expr\BinaryOp\BooleanAnd(
                $expr,
                new Node\Expr\FuncCall(
                    new Node\Name(\sprintf('FAUX_FUNCTION_%s', $methodName)),
                    [$arg, $other],
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
            foreach ($specifiedTypes->getSureNotTypes() as [$expr, $type]) {
                if ($expr === $arg->value) {
                    return TypeCombinator::remove($originalType, $type);
                }
            }

            foreach ($specifiedTypes->getSureTypes() as [$expr, $type]) {
                if ($expr === $arg->value) {
                    return TypeCombinator::intersect($originalType, $type);
                }
            }

            return $originalType;
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
     * @param list<Node\Arg> $args
     *
     * @return null|array{Type, Node\Expr}
     */
    public function narrowIterating(
        TypeSpecifier $typeSpecifier,
        Scope $scope,
        ExpectationObjectType $calledOnType,
        string $methodName,
        array $args,
    ): ?array {
        $valueExpr = $calledOnType->getValueExpr();
        $iteratingClass = $calledOnType->getClassName();
        \assert(class_exists($iteratingClass));

        $otherArg = $args[0] ?? new Node\Arg(new Node\Scalar\Int_(1));

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
            $otherArg,
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
            $otherArg,
        );
        \assert(null !== $storedPredicate);

        return [$newType, self::reduceExprWithStoredExpr($calledOnType->getStoredExpr(), $storedPredicate)];
    }

    /**
     * @param list<Node\Arg> $args
     */
    public function specifyIteratingOuter(
        TypeSpecifier $typeSpecifier,
        Scope $scope,
        ExpectationObjectType $calledOnType,
        string $methodName,
        array $args,
    ): SpecifiedTypes {
        $narrowed = $this->narrowIterating($typeSpecifier, $scope, $calledOnType, $methodName, $args);

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

    private static function createExprResolvers(): void
    {
        if ([] === self::$resolvers) {
            self::$resolvers = [
                'hasMethod' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $method): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isObject']($scope, $arg, $method),
                    new Node\Expr\FuncCall(
                        new Node\Name('method_exists'),
                        [$arg, $method],
                    ),
                ),
                'hasOffset' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $key): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isArray']($scope, $arg, $key),
                    new Node\Expr\FuncCall(
                        new Node\Name\FullyQualified('array_key_exists'),
                        [$key, $arg],
                    ),
                ),
                'hasProperty' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $property): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isObject']($scope, $arg, $property),
                    new Node\Expr\FuncCall(
                        new Node\Name('property_exists'),
                        [$arg, $property],
                    ),
                ),
                'isArray' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_array'),
                    [$arg],
                ),
                'isArrayKey' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\BooleanOr(
                    self::$resolvers['isInt']($scope, $arg, $other),
                    self::$resolvers['isString']($scope, $arg, $other),
                ),
                'isBool' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_bool'),
                    [$arg],
                ),
                'isCallable' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_callable'),
                    [$arg],
                ),
                'isCountable' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name('is_countable'),
                    [$arg],
                ),
                'isFalse' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\ConstFetch(new Node\Name('false')),
                    $arg->value,
                ),
                'isFloat' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_float'),
                    [$arg],
                ),
                'isIdentical' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $expected): Node\Expr => new Node\Expr\BinaryOp\Identical(
                    $arg->value,
                    $expected->value,
                ),
                'isInstanceOf' => static function (Scope $scope, Node\Arg $arg, Node\Arg $class): Node\Expr {
                    $classType = $scope->getType($class->value)->getObjectTypeOrClassStringObjectType();
                    $classNames = $classType->getObjectClassNames();

                    if ([] === $classNames) {
                        return new Node\Expr\Instanceof_($arg->value, $class->value);
                    }

                    $exprs = array_map(
                        static fn(string $className): Node\Expr => new Node\Expr\Instanceof_(
                            $arg->value,
                            new Node\Name\FullyQualified($className),
                        ),
                        $classNames,
                    );

                    if (\count($exprs) === 1) {
                        return $exprs[0];
                    }

                    $firstExpr = array_shift($exprs);

                    return array_reduce(
                        $exprs,
                        static fn(Node\Expr $carry, Node\Expr $expr): Node\Expr => new Node\Expr\BinaryOp\BooleanOr($carry, $expr),
                        $firstExpr,
                    );
                },
                'isInt' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_int'),
                    [$arg],
                ),
                'isIterable' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name('is_iterable'),
                    [$arg],
                ),
                'isList' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isArray']($scope, $arg, $other),
                    new Node\Expr\BinaryOp\Identical(
                        new Node\Expr\FuncCall(
                            new Node\Name('array_values'),
                            [$arg],
                        ),
                        $arg->value,
                    ),
                ),
                'isLowercaseString' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isString']($scope, $arg, $other),
                    new Node\Expr\BinaryOp\Identical(
                        new Node\Expr\FuncCall(
                            new Node\Name('strtolower'),
                            [$arg],
                        ),
                        $arg->value,
                    ),
                ),
                'isMap' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isArray']($scope, $arg, $other),
                    new Node\Expr\BinaryOp\Identical(
                        new Node\Expr\FuncCall(
                            new Node\Name('array_filter'),
                            [
                                $arg,
                                new Node\Arg(new Node\Expr\FuncCall(
                                    new Node\Name\FullyQualified('is_string'),
                                    [new Node\VariadicPlaceholder()],
                                )),
                                new Node\Arg(new Node\Expr\ConstFetch(new Node\Name('ARRAY_FILTER_USE_KEY'))),
                            ],
                        ),
                        $arg->value,
                    ),
                ),
                'isNaturalInt' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isInt']($scope, $arg, $other),
                    new Node\Expr\BinaryOp\GreaterOrEqual(
                        $arg->value,
                        new Node\Scalar\Int_(0),
                    ),
                ),
                'isNegativeInt' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isInt']($scope, $arg, $other),
                    new Node\Expr\BinaryOp\Smaller(
                        $arg->value,
                        new Node\Scalar\Int_(0),
                    ),
                ),
                'isNonEmptyString' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isString']($scope, $arg, $other),
                    new Node\Expr\BinaryOp\NotIdentical(
                        new Node\Scalar\String_(''),
                        $arg->value,
                    ),
                ),
                'isNull' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\ConstFetch(new Node\Name('null')),
                    $arg->value,
                ),
                'isNumeric' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name('is_numeric'),
                    [$arg],
                ),
                'isObject' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_object'),
                    [$arg],
                ),
                'isPositiveInt' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isInt']($scope, $arg, $other),
                    new Node\Expr\BinaryOp\Greater(
                        $arg->value,
                        new Node\Scalar\Int_(0),
                    ),
                ),
                'isResource' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_resource'),
                    [$arg],
                ),
                'isScalar' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_scalar'),
                    [$arg],
                ),
                'isString' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_string'),
                    [$arg],
                ),
                'isTrue' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\ConstFetch(new Node\Name('true')),
                    $arg->value,
                ),
                'isUppercaseString' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $other): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isString']($scope, $arg, $other),
                    new Node\Expr\BinaryOp\Identical(
                        new Node\Expr\FuncCall(
                            new Node\Name('strtoupper'),
                            [$arg],
                        ),
                        $arg->value,
                    ),
                ),
            ];

            foreach (self::METHODS_USING_PRIMARY_RESOLVERS as $methodName => $primaryResolverName) {
                self::$resolvers[$methodName] = self::$resolvers[$primaryResolverName];
            }

            foreach (self::METHODS_USING_STRING_RESOLVERS as $methodName) {
                self::$resolvers[$methodName] = static function (Scope $scope, Node\Arg $haystack, Node\Arg $needle): Node\Expr {
                    if ($scope->getType($needle->value)->isNonEmptyString()->yes()) {
                        return self::$resolvers['isNonEmptyString']($scope, $haystack, $needle);
                    }

                    return self::$resolvers['isString']($scope, $haystack, $needle);
                };
            }

            foreach (self::ITERATING_VARIANT_METHODS as $methodName) {
                self::$resolvers[$methodName] = self::$resolvers['isIterable'];
            }
        }
    }
}
