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
use Nexus\Assert\Expectation;
use Nexus\Assert\NegatedExpectation;
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
    private const EXPECTATION_OBJECT_TYPE_MAP = [
        Expectation::class => ExpectationObjectType::class,
        NegatedExpectation::class => NegatedExpectationObjectType::class,
    ];

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

        if (! $calledOnType instanceof ExpectableObjectType) {
            return null;
        }

        $returnType = ParametersAcceptorSelector::selectFromArgs(
            $scope,
            $methodCall->getArgs(),
            $methodReflection->getVariants(),
        )->getReturnType();

        if ($returnType instanceof GenericObjectType) {
            $expectationClass = $returnType->getClassName();

            if (! \array_key_exists($expectationClass, self::EXPECTATION_OBJECT_TYPE_MAP)) {
                return $returnType;
            }

            $expectationObjectType = self::EXPECTATION_OBJECT_TYPE_MAP[$expectationClass];

            if (NegatedExpectationObjectType::class === $expectationObjectType) {
                return self::getTypeFromNegatedExpectationMethodCall(
                    $methodReflection,
                    $returnType,
                    $calledOnType,
                );
            }

            return self::getTypeFromRegularExpectationMethodCall(
                $methodReflection,
                $returnType,
                $calledOnType,
            );
        }

        return $returnType;
    }

    private static function getTypeFromNegatedExpectationMethodCall(MethodReflection $methodReflection, GenericObjectType $returnType, ExpectableObjectType $calledOnType): Type
    {
        $methodName = $methodReflection->getName();
        $subtractedType = ExpectationMethodResolver::create()->resolve($methodName);
        $newType = null !== $subtractedType
            ? TypeCombinator::remove(
                TypeCombinator::union(...$returnType->getTypes()),
                $subtractedType,
            )
            : TypeCombinator::union(...$returnType->getTypes());

        if ($newType instanceof NeverType) {
            return new NeverType(true);
        }

        return new NegatedExpectationObjectType([$newType], $calledOnType->getValueExpr());
    }

    private static function getTypeFromRegularExpectationMethodCall(MethodReflection $methodReflection, GenericObjectType $returnType, ExpectableObjectType $calledOnType): Type
    {
        $methodName = $methodReflection->getName();
        $intersectedType = ExpectationMethodResolver::create()->resolve($methodName);
        $newType = null !== $intersectedType
            ? TypeCombinator::intersect(
                TypeCombinator::union(...$returnType->getTypes()),
                $intersectedType,
            )
            : TypeCombinator::union(...$returnType->getTypes());

        if ($newType instanceof NeverType) {
            return new NeverType(true);
        }

        return new ExpectationObjectType([$newType], $calledOnType->getValueExpr());
    }
}
