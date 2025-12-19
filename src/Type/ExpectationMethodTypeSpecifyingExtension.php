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
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\MethodTypeSpecifyingExtension;
use PHPStan\Type\TypeCombinator;

final class ExpectationMethodTypeSpecifyingExtension implements MethodTypeSpecifyingExtension, TypeSpecifierAwareExtension
{
    private TypeSpecifier $typeSpecifier;

    public function setTypeSpecifier(TypeSpecifier $typeSpecifier): void
    {
        $this->typeSpecifier = $typeSpecifier;
    }

    public function getClass(): string
    {
        return Expectable::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection, MethodCall $node, TypeSpecifierContext $context): bool
    {
        return true;
    }

    public function specifyTypes(
        MethodReflection $methodReflection,
        MethodCall $node,
        Scope $scope,
        TypeSpecifierContext $context,
    ): SpecifiedTypes {
        $calledOnType = $scope->getType($node->var);

        if (! $calledOnType instanceof ExpectationObjectType) {
            return new SpecifiedTypes();
        }

        if ([] === $calledOnType->getTypes()) {
            return new SpecifiedTypes();
        }

        $returnType = ExpectationMethodResolver::create()->resolve($methodReflection->getName());

        if (null === $returnType) {
            return new SpecifiedTypes();
        }

        if ($calledOnType->getClassName() === NegatedExpectation::class) {
            return $this->typeSpecifier->create(
                $calledOnType->getValueExpr(),
                TypeCombinator::remove(TypeCombinator::union(...$calledOnType->getTypes()), $returnType),
                TypeSpecifierContext::createTruthy(),
                $scope,
            );
        }

        if ($calledOnType->getClassName() === NullableExpectation::class) {
            return $this->typeSpecifier->create(
                $calledOnType->getValueExpr(),
                TypeCombinator::addNull(TypeCombinator::intersect(...$calledOnType->getTypes(), ...[$returnType])),
                TypeSpecifierContext::createTruthy(),
                $scope,
            );
        }

        return $this->typeSpecifier->create(
            $calledOnType->getValueExpr(),
            TypeCombinator::intersect(...$calledOnType->getTypes(), ...[$returnType]),
            TypeSpecifierContext::createTruthy(),
            $scope,
        );
    }
}
