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
 * Narrows to `array<mixed, mixed>|ArrayAccess`.
 */
final class IsArrayAccessibleResolver implements ResolverInterface
{
    public function __construct(
        private readonly IsArrayResolver $isArray,
        private readonly IsInstanceOfResolver $isInstanceOf,
    ) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        $arrayAccess = new Node\Arg(new Node\Expr\ClassConstFetch(
            new Node\Name\FullyQualified(\ArrayAccess::class),
            'class',
        ));

        return new Node\Expr\BinaryOp\BooleanOr(
            $this->isArray->resolve($scope, $arg, ...$args),
            $this->isInstanceOf->resolve($scope, $arg, $arrayAccess),
        );
    }
}
