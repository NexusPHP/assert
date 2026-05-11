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
 * Narrows to the union of the given choices.
 */
final class IsOneOfResolver implements ResolverInterface
{
    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        \assert(isset($args[0]));

        return new Node\Expr\FuncCall(
            new Node\Name\FullyQualified('in_array'),
            [
                $arg,
                $args[0],
                new Node\Arg(new Node\Expr\ConstFetch(new Node\Name('true'))),
            ],
        );
    }
}
