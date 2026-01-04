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
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\MethodTypeSpecifyingExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\ThisType;

final class ExpectationMethodTypeSpecifyingExtension implements MethodTypeSpecifyingExtension, TypeSpecifierAwareExtension
{
    private TypeSpecifier $typeSpecifier;

    public function __construct(
        private ExpectationMethodResolver $resolver,
    ) {}

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
        return $this->resolver->isSupported($methodReflection->getName());
    }

    public function specifyTypes(
        MethodReflection $methodReflection,
        MethodCall $node,
        Scope $scope,
        TypeSpecifierContext $context,
    ): SpecifiedTypes {
        $calledOnType = $scope->getType($node->var);

        if ($calledOnType instanceof ThisType) {
            $objectType = $calledOnType->getStaticObjectType();
            $calledOnType = new ExpectationObjectType(
                $objectType->getClassName(),
                [new MixedType(true)],
                new Node\Expr\PropertyFetch($node->var, 'value'),
            );
        }

        if (! $calledOnType instanceof ExpectationObjectType) {
            return new SpecifiedTypes();
        }

        if ([] === $calledOnType->getTypes()) {
            return new SpecifiedTypes();
        }

        /** @var class-string $expectationClass */
        $expectationClass = $calledOnType->getClassName();
        $expr = $this->resolver->resolveExpr(
            $expectationClass,
            $methodReflection->getName(),
            $scope,
            new Node\Arg($calledOnType->getValueExpr()),
            ...$node->getArgs(),
        );

        if (null === $expr) {
            return new SpecifiedTypes();
        }

        $storedExpr = $calledOnType->getStoredExpr();

        if (null !== $storedExpr) {
            $expr = new Node\Expr\BinaryOp\BooleanAnd($storedExpr, $expr);
        }

        return $this->typeSpecifier->specifyTypesInCondition($scope, $expr, TypeSpecifierContext::createTruthy())->setRootExpr($expr);
    }
}
