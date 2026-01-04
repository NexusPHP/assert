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
        \assert($returnType instanceof GenericObjectType);

        /** @var class-string $expectationClass */
        $expectationClass = $returnType->getClassName();

        // When calling `not()` or `nullOr()`, the stored expr gets lost,
        // so we need to get it from the $calledOnType.
        $resolvedExpr = $this->resolver->resolveExpr(
            $expectationClass,
            $methodReflection->getName(),
            $scope,
            new Node\Arg($calledOnType->getValueExpr()),
            ...$methodCall->getArgs(),
        );
        $resolvedExpr = array_reduce(
            [$resolvedExpr],
            static function (?Node\Expr $carry, ?Node\Expr $expr): ?Node\Expr {
                if (null === $carry || null === $expr) {
                    return $expr ?? $carry;
                }

                return new Node\Expr\BinaryOp\BooleanAnd($carry, $expr);
            },
            $calledOnType->getStoredExpr(),
        );

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
