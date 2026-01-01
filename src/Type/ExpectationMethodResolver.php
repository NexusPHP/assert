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

use Nexus\Assert\NegatedExpectation;
use Nexus\Assert\NullableExpectation;
use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Type\Type;

final class ExpectationMethodResolver
{
    private const UNSUPPORTED_EXPECTATION_METHODS = [
        'not',
        'nullOr',
    ];

    /**
     * @var array{
     *   hasMethod: \Closure(Scope, Node\Arg, Node\Arg): Node\Expr,
     *   hasProperty: \Closure(Scope, Node\Arg, Node\Arg): Node\Expr,
     *   isArray: \Closure(Scope, Node\Arg): Node\Expr,
     *   isBool: \Closure(Scope, Node\Arg): Node\Expr,
     *   isCallable: \Closure(Scope, Node\Arg): Node\Expr,
     *   isCountable: \Closure(Scope, Node\Arg): Node\Expr,
     *   isFalse: \Closure(Scope, Node\Arg): Node\Expr,
     *   isFloat: \Closure(Scope, Node\Arg): Node\Expr,
     *   isInstanceOf: \Closure(Scope, Node\Arg, Node\Arg): Node\Expr,
     *   isInt: \Closure(Scope, Node\Arg): Node\Expr,
     *   isIterable: \Closure(Scope, Node\Arg): Node\Expr,
     *   isNull: \Closure(Scope, Node\Arg): Node\Expr,
     *   isNumeric: \Closure(Scope, Node\Arg): Node\Expr,
     *   isObject: \Closure(Scope, Node\Arg): Node\Expr,
     *   isResource: \Closure(Scope, Node\Arg): Node\Expr,
     *   isSameAs: \Closure(Scope, Node\Arg, Node\Arg): Node\Expr,
     *   isScalar: \Closure(Scope, Node\Arg): Node\Expr,
     *   isString: \Closure(Scope, Node\Arg): Node\Expr,
     *   isTrue: \Closure(Scope, Node\Arg): Node\Expr,
     * }
     */
    private static array $resolvers = [];

    public function __construct()
    {
        self::createExprResolvers();
    }

    public function isSupported(string $methodName): bool
    {
        return ! \in_array($methodName, self::UNSUPPORTED_EXPECTATION_METHODS, true)
            && isset(self::$resolvers[$methodName]);
    }

    /**
     * @param class-string $expectationClass
     */
    public function resolveExpr(
        string $expectationClass,
        string $methodName,
        Scope $scope,
        Node\Arg $arg,
        Node\Arg ...$args,
    ): ?Node\Expr {
        if (! $this->isSupported($methodName)) {
            return null;
        }

        $expr = self::$resolvers[$methodName]($scope, $arg, ...$args);

        if (null === $expr) {
            return null;
        }

        if (NegatedExpectation::class === $expectationClass) {
            return new Node\Expr\BooleanNot($expr);
        }

        if (NullableExpectation::class === $expectationClass) {
            return new Node\Expr\BinaryOp\BooleanOr(
                new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\ConstFetch(new Node\Name('null')),
                    $arg->value,
                ),
                $expr,
            );
        }

        return $expr;
    }

    /**
     * @param class-string $expectationClass
     */
    public function resolveType(
        TypeSpecifier $typeSpecifier,
        ?Node\Expr $resolvedExpr,
        string $expectationClass,
        Scope $scope,
        Node\Arg $arg,
    ): ?Type {
        if (null === $resolvedExpr) {
            return null;
        }

        $context = TypeSpecifierContext::createTruthy();
        $specifiedTypes = $typeSpecifier->specifyTypesInCondition($scope, $resolvedExpr, $context);

        if (NegatedExpectation::class === $expectationClass) {
            foreach ($specifiedTypes->getSureNotTypes() as [$expr, $type]) {
                if ($expr === $arg->value) {
                    return $type;
                }
            }

            return null;
        }

        foreach ($specifiedTypes->getSureTypes() as [$expr, $type]) {
            if ($expr === $arg->value) {
                return $type;
            }
        }

        return null;
    }

    private static function createExprResolvers(): void
    {
        if ([] === self::$resolvers) {
            self::$resolvers = [
                'hasMethod' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $method): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isObject']($scope, $arg),
                    new Node\Expr\FuncCall(
                        new Node\Name('method_exists'),
                        [$arg, $method],
                    ),
                ),
                'hasProperty' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $property): Node\Expr => new Node\Expr\BinaryOp\BooleanAnd(
                    self::$resolvers['isObject']($scope, $arg),
                    new Node\Expr\FuncCall(
                        new Node\Name('property_exists'),
                        [$arg, $property],
                    ),
                ),
                'isArray' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_array'),
                    [$arg],
                ),
                'isBool' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_bool'),
                    [$arg],
                ),
                'isCallable' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_callable'),
                    [$arg],
                ),
                'isCountable' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name('is_countable'),
                    [$arg],
                ),
                'isFalse' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\ConstFetch(new Node\Name('false')),
                    $arg->value,
                ),
                'isFloat' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_float'),
                    [$arg],
                ),
                'isInstanceOf' => static function (Scope $scope, Node\Arg $arg, Node\Arg $class): Node\Expr {
                    $classType = $scope->getType($class->value)->getClassStringObjectType();
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
                'isInt' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_int'),
                    [$arg],
                ),
                'isIterable' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name('is_iterable'),
                    [$arg],
                ),
                'isNull' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\ConstFetch(new Node\Name('null')),
                    $arg->value,
                ),
                'isNumeric' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name('is_numeric'),
                    [$arg],
                ),
                'isObject' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_object'),
                    [$arg],
                ),
                'isResource' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_resource'),
                    [$arg],
                ),
                'isSameAs' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $expected): Node\Expr => new Node\Expr\BinaryOp\Identical(
                    $arg->value,
                    $expected->value,
                ),
                'isScalar' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_scalar'),
                    [$arg],
                ),
                'isString' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_string'),
                    [$arg],
                ),
                'isTrue' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\ConstFetch(new Node\Name('true')),
                    $arg->value,
                ),
            ];
        }
    }
}
