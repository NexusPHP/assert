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

use Nexus\Assert\Expectable;
use Nexus\Assert\NegatedExpectation;
use Nexus\Assert\NullableExpectation;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\NeverType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

final class ExpectationDynamicMethodReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function __construct(private ExpectationMethodResolver $resolver) {}

    public function getClass(): string
    {
        return Expectable::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return true;
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): ?Type
    {
        $calledOnType = $scope->getType($methodCall->var);

        if (! $calledOnType instanceof ExpectationObjectType) {
            return null;
        }

        if ($methodReflection->getName() === 'not') {
            return new ExpectationObjectType(
                NegatedExpectation::class,
                $calledOnType->getTypes(),
                $calledOnType->getValueExpr(),
                $calledOnType->getStoredExpr(),
            );
        }

        if ($methodReflection->getName() === 'nullOr') {
            return new ExpectationObjectType(
                NullableExpectation::class,
                [TypeCombinator::addNull(...$calledOnType->getTypes())],
                $calledOnType->getValueExpr(),
                $calledOnType->getStoredExpr(),
            );
        }

        $iteratingClass = $calledOnType->getClassName();

        if (ExpectationMethodResolver::isIteratingVariant($iteratingClass)) {
            \assert(class_exists($iteratingClass));

            $narrowed = $this->resolver->narrowIterating(
                $scope,
                $calledOnType,
                $methodReflection->getName(),
                ...array_values($methodCall->getArgs()),
            );

            if (null === $narrowed) {
                return $calledOnType;
            }

            [$newType, $newStoredExpr] = $narrowed;

            if ($newType instanceof NeverType) {
                return new NeverType(true);
            }

            return new ExpectationObjectType(
                $iteratingClass,
                [$newType],
                $calledOnType->getValueExpr(),
                $newStoredExpr,
            );
        }

        $returnType = ParametersAcceptorSelector::selectFromArgs(
            $scope,
            $methodCall->getArgs(),
            $methodReflection->getVariants(),
        )->getReturnType();
        \assert($returnType instanceof GenericObjectType);

        $expectationClass = $returnType->getClassName();
        \assert(class_exists($expectationClass));

        $resolvedExpr = $this->resolver->resolveExpr(
            $expectationClass,
            $methodReflection->getName(),
            $calledOnType->getStoredExpr(),
            $scope,
            new Node\Arg($calledOnType->getValueExpr()),
            ...array_values($methodCall->getArgs()),
        );

        if (null === $resolvedExpr) {
            return null;
        }

        $resolvedType = $this->resolver->resolveType(
            $resolvedExpr,
            TypeCombinator::union(...$returnType->getTypes()),
            $scope,
            new Node\Arg($calledOnType->getValueExpr()),
        );

        if ($resolvedType instanceof NeverType) {
            return new NeverType(true);
        }

        return new ExpectationObjectType(
            $expectationClass,
            [$resolvedType],
            $calledOnType->getValueExpr(),
            $resolvedExpr,
        );
    }
}
