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

namespace Nexus\Assert\Type\Resolver;

use PhpParser\Node;
use PHPStan\Analyser\Scope;

/**
 * Narrows to instances of any of the given classes.
 */
final class IsInstanceOfAnyResolver implements ResolverInterface
{
    public function __construct(private readonly IsObjectResolver $isObject) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        \assert(isset($args[0]));

        $classNames = [];

        foreach ($scope->getType($args[0]->value)->getConstantArrays() as $constantArray) {
            foreach ($constantArray->getValueTypes() as $valueType) {
                foreach ($valueType->getObjectTypeOrClassStringObjectType()->getObjectClassNames() as $className) {
                    $classNames[$className] = $className;
                }
            }
        }

        if ([] === $classNames) {
            return $this->isObject->resolve($scope, $arg, ...$args);
        }

        $exprs = array_map(
            static fn(string $className): Node\Expr => new Node\Expr\Instanceof_(
                $arg->value,
                new Node\Name\FullyQualified($className),
            ),
            array_values($classNames),
        );

        $firstExpr = array_shift($exprs);

        return array_reduce(
            $exprs,
            static fn(Node\Expr $carry, Node\Expr $expr): Node\Expr => new Node\Expr\BinaryOp\BooleanOr($carry, $expr),
            $firstExpr,
        );
    }
}
