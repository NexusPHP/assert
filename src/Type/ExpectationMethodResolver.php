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
     * @var array<string, \Closure(Scope, Node\Arg, Node\Arg): (null|Node\Expr)>
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
        if (\in_array($methodName, self::UNSUPPORTED_EXPECTATION_METHODS, true)) {
            return null;
        }

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
        string $expectationClass,
        string $methodName,
        Scope $scope,
        Node\Arg $arg,
        Node\Arg ...$args,
    ): ?Type {
        $resolvedExpr = $this->resolveExpr($expectationClass, $methodName, $scope, $arg, ...$args);

        if (null === $resolvedExpr) {
            return null;
        }

        $context = TypeSpecifierContext::createTruthy();

        if (NegatedExpectation::class === $expectationClass) {
            foreach ($typeSpecifier->specifyTypesInCondition($scope, $resolvedExpr, $context)->getSureNotTypes() as [$expr, $type]) {
                if ($expr === $arg->value) {
                    return $type;
                }
            }
        }

        foreach ($typeSpecifier->specifyTypesInCondition($scope, $resolvedExpr, $context)->getSureTypes() as [$expr, $type]) {
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
                'isFalse' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\ConstFetch(new Node\Name('false')),
                    $arg->value,
                ),
                'isFloat' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_float'),
                    [$arg],
                ),
                'isInstanceOf' => static function (Scope $scope, Node\Arg $arg, Node\Arg $class): ?Node\Expr {
                    $classType = $scope->getType($class->value);

                    if (\count($classType->getConstantStrings()) === 1) {
                        $className = $classType->getConstantStrings()[0]->getValue();

                        return new Node\Expr\Instanceof_(
                            $arg->value,
                            new Node\Name\FullyQualified($className),
                        );
                    }

                    if ($classType->isClassString()->yes()) {
                        $objectType = $classType->getClassStringObjectType();

                        if ($objectType->getObjectClassNames() !== []) {
                            return new Node\Expr\Instanceof_(
                                $arg->value,
                                new Node\Name\FullyQualified($objectType->getObjectClassNames()[0]),
                            );
                        }

                        return new Node\Expr\Instanceof_(
                            $arg->value,
                            $class->value,
                        );
                    }

                    return null;
                },
                'isInt' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_int'),
                    [$arg],
                ),
                'isIterable' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_iterable'),
                    [$arg],
                ),
                'isNull' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\ConstFetch(new Node\Name('null')),
                    $arg->value,
                ),
                'isNumeric' => static fn(Scope $scope, Node\Arg $arg): Node\Expr => new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('is_numeric'),
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
