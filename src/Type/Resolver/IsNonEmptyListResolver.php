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
 * Narrows to `non-empty-list<mixed>`.
 */
final class IsNonEmptyListResolver implements ResolverInterface
{
    public function __construct(private readonly IsListResolver $isList) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        return new Node\Expr\BinaryOp\BooleanAnd(
            $this->isList->resolve($scope, $arg, ...$args),
            new Node\Expr\BinaryOp\NotIdentical(
                new Node\Expr\Array_(),
                $arg->value,
            ),
        );
    }
}
