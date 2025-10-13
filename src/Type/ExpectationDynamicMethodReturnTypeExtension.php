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

use Nexus\Assert\Expectation;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Type;

final class ExpectationDynamicMethodReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return Expectation::class;
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

        $returnType = ParametersAcceptorSelector::selectFromArgs(
            $scope,
            $methodCall->getArgs(),
            $methodReflection->getVariants(),
        )->getReturnType();

        if ($returnType instanceof GenericObjectType) {
            return new ExpectationObjectType($returnType->getTypes(), $calledOnType->getValueExpr());
        }

        return $returnType;
    }
}
