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
 * Narrows to the comparison-bounded `float|int` range.
 */
final class NumberComparisonResolver implements ResolverInterface
{
    /**
     * @param class-string<Node\Expr\BinaryOp> $comparison
     */
    public function __construct(
        private readonly string $comparison,
        private readonly IsIntResolver $isInt,
        private readonly IsFloatResolver $isFloat,
    ) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        \assert(isset($args[0]));

        return new Node\Expr\BinaryOp\BooleanAnd(
            new Node\Expr\BinaryOp\BooleanOr(
                $this->isInt->resolve($scope, $arg, ...$args),
                $this->isFloat->resolve($scope, $arg, ...$args),
            ),
            new ($this->comparison)($arg->value, $args[0]->value),
        );
    }
}
