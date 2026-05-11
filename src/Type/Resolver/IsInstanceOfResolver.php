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
 * Narrows to instances of the given class.
 */
final class IsInstanceOfResolver implements ResolverInterface
{
    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        \assert(isset($args[0]));

        $class = $args[0];
        $classType = $scope->getType($class->value)->getObjectTypeOrClassStringObjectType();
        $classNames = $classType->getObjectClassNames();

        if ([] === $classNames) {
            return new Node\Expr\Instanceof_($arg->value, $class->value);
        }

        $exprs = array_map(
            static fn(string $className): Node\Expr => new Node\Expr\Instanceof_(
                $arg->value,
                new Node\Name\FullyQualified($className),
            ),
            $classNames,
        );

        if (\count($exprs) === 1) {
            return $exprs[0];
        }

        $firstExpr = array_shift($exprs);

        return array_reduce(
            $exprs,
            static fn(Node\Expr $carry, Node\Expr $expr): Node\Expr => new Node\Expr\BinaryOp\BooleanOr($carry, $expr),
            $firstExpr,
        );
    }
}
