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

        $returnType = ParametersAcceptorSelector::selectFromArgs(
            $scope,
            $methodCall->getArgs(),
            $methodReflection->getVariants(),
        )->getReturnType();

        if ($returnType instanceof GenericObjectType) {
            $expectationClass = $returnType->getClassName();
            $args = [
                new Node\Arg($calledOnType->getValueExpr()),
                ...$methodCall->getArgs(),
            ];

            if (NegatedExpectation::class === $expectationClass) {
                return self::getTypeFromNegatedExpectationMethodCall(
                    $methodReflection,
                    $returnType,
                    $calledOnType,
                    $scope,
                    ...$args,
                );
            }

            if (NullableExpectation::class === $expectationClass) {
                return self::getTypeFromNullableExpectationMethodCall(
                    $methodReflection,
                    $returnType,
                    $calledOnType,
                    $scope,
                    ...$args,
                );
            }

            return self::getTypeFromRegularExpectationMethodCall(
                $methodReflection,
                $returnType,
                $calledOnType,
                $scope,
                ...$args,
            );
        }

        return $returnType;
    }

    private static function getTypeFromNegatedExpectationMethodCall(
        MethodReflection $methodReflection,
        GenericObjectType $returnType,
        ExpectationObjectType $calledOnType,
        Scope $scope,
        Node\Arg ...$args,
    ): Type {
        $methodName = $methodReflection->getName();
        $subtractedType = ExpectationMethodResolver::create()->resolve($methodName, $scope, ...$args);

        if (null === $subtractedType) {
            return new ExpectationObjectType(
                NegatedExpectation::class,
                $returnType->getTypes(),
                $calledOnType->getValueExpr(),
            );
        }

        $newType = TypeCombinator::remove(
            TypeCombinator::union(...$returnType->getTypes()),
            $subtractedType,
        );

        if ($newType instanceof NeverType) {
            return new NeverType(true);
        }

        return new ExpectationObjectType(NegatedExpectation::class, [$newType], $calledOnType->getValueExpr());
    }

    private static function getTypeFromNullableExpectationMethodCall(
        MethodReflection $methodReflection,
        GenericObjectType $returnType,
        ExpectationObjectType $calledOnType,
        Scope $scope,
        Node\Arg ...$args,
    ): Type {
        $methodName = $methodReflection->getName();
        $unionedType = ExpectationMethodResolver::create()->resolve($methodName, $scope, ...$args);

        if (null === $unionedType) {
            return new ExpectationObjectType(
                NullableExpectation::class,
                $returnType->getTypes(),
                $calledOnType->getValueExpr(),
            );
        }

        $newType = TypeCombinator::intersect(
            TypeCombinator::union(...$returnType->getTypes()),
            $unionedType,
        );

        if ($newType instanceof NeverType) {
            return new NeverType(true);
        }

        $newTypeWithNull = TypeCombinator::addNull($newType);

        return new ExpectationObjectType(NullableExpectation::class, [$newTypeWithNull], $calledOnType->getValueExpr());
    }

    private static function getTypeFromRegularExpectationMethodCall(
        MethodReflection $methodReflection,
        GenericObjectType $returnType,
        ExpectationObjectType $calledOnType,
        Scope $scope,
        Node\Arg ...$args,
    ): Type {
        $methodName = $methodReflection->getName();
        $intersectedType = ExpectationMethodResolver::create()->resolve($methodName, $scope, ...$args);

        if (null === $intersectedType) {
            return new ExpectationObjectType(
                Expectation::class,
                $returnType->getTypes(),
                $calledOnType->getValueExpr(),
            );
        }

        $newType = TypeCombinator::intersect(
            TypeCombinator::union(...$returnType->getTypes()),
            $intersectedType,
        );

        if ($newType instanceof NeverType) {
            return new NeverType(true);
        }

        return new ExpectationObjectType(Expectation::class, [$newType], $calledOnType->getValueExpr());
    }
}
