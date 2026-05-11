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
 * Narrows to an `object` that has the given property.
 */
final class HasPropertyResolver implements ResolverInterface
{
    public function __construct(private readonly IsObjectResolver $isObject) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        \assert(isset($args[0]));

        return new Node\Expr\BinaryOp\BooleanAnd(
            $this->isObject->resolve($scope, $arg, ...$args),
            new Node\Expr\FuncCall(
                new Node\Name('property_exists'),
                [$arg, $args[0]],
            ),
        );
    }
}
