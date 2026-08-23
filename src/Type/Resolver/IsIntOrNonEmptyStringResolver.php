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
 * Narrows to `int|non-empty-string`.
 */
final class IsIntOrNonEmptyStringResolver implements ResolverInterface
{
    public function __construct(
        private readonly IsIntResolver $isInt,
        private readonly IsNonEmptyStringResolver $isNonEmptyString,
    ) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        return new Node\Expr\BinaryOp\BooleanOr(
            $this->isInt->resolve($scope, $arg, ...$args),
            $this->isNonEmptyString->resolve($scope, $arg, ...$args),
        );
    }
}
