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
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\NeverType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

final class ExpectationDynamicMethodReturnTypeExtension implements DynamicMethodReturnTypeExtension, TypeSpecifierAwareExtension
{
    private TypeSpecifier $typeSpecifier;

    public function __construct(
        private ExpectationMethodResolver $resolver,
    ) {}

    public function getClass(): string
    {
        return Expectable::class;
    }

    public function setTypeSpecifier(TypeSpecifier $typeSpecifier): void
    {
        $this->typeSpecifier = $typeSpecifier;
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
            $methodCall->getArgs()[0] ?? new Node\Arg(new Node\Scalar\Int_(1)),
        );

        if (null === $resolvedExpr) {
            return null;
        }

        $resolvedType = $this->resolver->resolveType(
            $this->typeSpecifier,
            $resolvedExpr,
            TypeCombinator::union(...$returnType->getTypes()),
            $expectationClass,
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
