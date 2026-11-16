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
 * Narrows to `float<min, max>|int<min, max>` within the given bounds.
 */
final class IsBetweenResolver implements ResolverInterface
{
    public function __construct(
        private readonly IsIntResolver $isInt,
        private readonly IsFloatResolver $isFloat,
    ) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        \assert(isset($args[0], $args[1]));

        $exclusive = isset($args[2]) && $scope->getType($args[2]->value)->isFalse()->yes();

        $lowerBound = $exclusive
            ? new Node\Expr\BinaryOp\Greater($arg->value, $args[0]->value)
            : new Node\Expr\BinaryOp\GreaterOrEqual($arg->value, $args[0]->value);
        $upperBound = $exclusive
            ? new Node\Expr\BinaryOp\Smaller($arg->value, $args[1]->value)
            : new Node\Expr\BinaryOp\SmallerOrEqual($arg->value, $args[1]->value);

        return new Node\Expr\BinaryOp\BooleanAnd(
            new Node\Expr\BinaryOp\BooleanOr(
                $this->isInt->resolve($scope, $arg, ...$args),
                $this->isFloat->resolve($scope, $arg, ...$args),
            ),
            new Node\Expr\BinaryOp\BooleanAnd($lowerBound, $upperBound),
        );
    }
}
