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

        $returnType = ParametersAcceptorSelector::selectFromArgs(
            $scope,
            $methodCall->getArgs(),
            $methodReflection->getVariants(),
        )->getReturnType();

        if ($returnType instanceof GenericObjectType) {
            /** @var class-string $expectationClass */
            $expectationClass = $returnType->getClassName();
            $resolvedType = $this->resolver->resolveType(
                $this->typeSpecifier,
                $expectationClass,
                $methodReflection->getName(),
                $scope,
                new Node\Arg($calledOnType->getValueExpr()),
                ...$methodCall->getArgs(),
            );

            if (NegatedExpectation::class === $expectationClass) {
                return self::getTypeFromNegatedExpectationMethodCall($returnType, $calledOnType, $resolvedType);
            }

            if (NullableExpectation::class === $expectationClass) {
                return self::getTypeFromNullableExpectationMethodCall($returnType, $calledOnType, $resolvedType);
            }

            return self::getTypeFromRegularExpectationMethodCall($returnType, $calledOnType, $resolvedType);
        }

        return $returnType;
    }

    private static function getTypeFromNegatedExpectationMethodCall(
        GenericObjectType $returnType,
        ExpectationObjectType $calledOnType,
        ?Type $resolvedType,
    ): Type {
        if (null === $resolvedType) {
            return new ExpectationObjectType(
                NegatedExpectation::class,
                $returnType->getTypes(),
                $calledOnType->getValueExpr(),
            );
        }

        $newType = TypeCombinator::remove(
            TypeCombinator::union(...$returnType->getTypes()),
            $resolvedType,
        );

        if ($newType instanceof NeverType) {
            return new NeverType(true);
        }

        return new ExpectationObjectType(NegatedExpectation::class, [$newType], $calledOnType->getValueExpr());
    }

    private static function getTypeFromNullableExpectationMethodCall(
        GenericObjectType $returnType,
        ExpectationObjectType $calledOnType,
        ?Type $resolvedType,
    ): Type {
        if (null === $resolvedType) {
            return new ExpectationObjectType(
                NullableExpectation::class,
                $returnType->getTypes(),
                $calledOnType->getValueExpr(),
            );
        }

        $newType = TypeCombinator::intersect(
            TypeCombinator::union(...$returnType->getTypes()),
            $resolvedType,
        );

        if ($newType instanceof NeverType) {
            return new NeverType(true);
        }

        $newTypeWithNull = TypeCombinator::addNull($newType);

        return new ExpectationObjectType(NullableExpectation::class, [$newTypeWithNull], $calledOnType->getValueExpr());
    }

    private static function getTypeFromRegularExpectationMethodCall(
        GenericObjectType $returnType,
        ExpectationObjectType $calledOnType,
        ?Type $resolvedType,
    ): Type {
        if (null === $resolvedType) {
            return new ExpectationObjectType(
                Expectation::class,
                $returnType->getTypes(),
                $calledOnType->getValueExpr(),
            );
        }

        $newType = TypeCombinator::intersect(
            TypeCombinator::union(...$returnType->getTypes()),
            $resolvedType,
        );

        if ($newType instanceof NeverType) {
            return new NeverType(true);
        }

        return new ExpectationObjectType(Expectation::class, [$newType], $calledOnType->getValueExpr());
    }
}
