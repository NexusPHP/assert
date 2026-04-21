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
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\MethodTypeSpecifyingExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\ThisType;

final class ExpectationMethodTypeSpecifyingExtension implements MethodTypeSpecifyingExtension, TypeSpecifierAwareExtension
{
    private TypeSpecifier $typeSpecifier;

    public function __construct(private ExpectationMethodResolver $resolver) {}

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

            $className = $objectType->getClassName();
            \assert(class_exists($className));

            $calledOnType = new ExpectationObjectType(
                $className,
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

        $expectationClass = $calledOnType->getClassName();
        \assert(class_exists($expectationClass));

        $expr = $this->resolver->resolveExpr(
            $expectationClass,
            $methodReflection->getName(),
            $calledOnType->getStoredExpr(),
            $scope,
            new Node\Arg($calledOnType->getValueExpr()),
            $node->getArgs()[0] ?? new Node\Arg(new Node\Scalar\Int_(1)),
        );

        if (null === $expr) {
            return new SpecifiedTypes();
        }

        $context = TypeSpecifierContext::createTruthy();
        $specifiedTypes = $this->typeSpecifier->specifyTypesInCondition($scope, $expr, $context)->setRootExpr($expr);

        if (
            ! \array_key_exists($methodReflection->getName(), ExpectationMethodResolver::METHODS_USING_PRIMARY_RESOLVERS)
            && ! \in_array($methodReflection->getName(), ExpectationMethodResolver::METHODS_USING_STRING_RESOLVERS, true)
        ) {
            return $specifiedTypes;
        }

        // make consecutive calls to the faux function to always return true
        return $specifiedTypes->unionWith($this->typeSpecifier->create($expr, new ConstantBooleanType(true), $context, $scope));
    }
}
