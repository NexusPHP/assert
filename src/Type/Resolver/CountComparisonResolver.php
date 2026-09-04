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
use PHPStan\Type\IntegerRangeType;

/**
 * Narrows to `array<mixed>|Countable`, non-empty on the array arm when the count bound implies it.
 */
final class CountComparisonResolver implements ResolverInterface
{
    /**
     * @param class-string<Node\Expr\BinaryOp> $comparison
     */
    public function __construct(
        private readonly string $comparison,
        private readonly IsCountableResolver $isCountable,
    ) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        \assert(isset($args[0]));

        $expr = new Node\Expr\BinaryOp\BooleanAnd(
            $this->isCountable->resolve($scope, $arg, ...$args),
            new ($this->comparison)(
                new Node\Expr\FuncCall(new Node\Name\FullyQualified('count'), [$arg]),
                $args[0]->value,
            ),
        );

        // PHPStan derives non-emptiness from `count() >= n` but not from `count() === n`,
        // so an exact positive count needs the emptiness pruned explicitly.
        if (Node\Expr\BinaryOp\Identical::class === $this->comparison
            && IntegerRangeType::fromInterval(1, null)->isSuperTypeOf($scope->getType($args[0]->value))->yes()
        ) {
            $expr = new Node\Expr\BinaryOp\BooleanAnd(
                $expr,
                new Node\Expr\BinaryOp\NotIdentical(new Node\Expr\Array_(), $arg->value),
            );
        }

        return $expr;
    }
}
