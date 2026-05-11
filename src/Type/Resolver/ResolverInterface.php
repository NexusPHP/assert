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

interface ResolverInterface
{
    /**
     * Builds the synthetic predicate AST that PHPStan uses to narrow `$arg`.
     *
     * `$args` carries the additional method-call arguments after the value;
     * resolvers that only care about the value can ignore it.
     */
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr;
}
