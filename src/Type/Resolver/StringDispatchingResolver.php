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
 * Narrows to `string`, or `non-empty-string` when the needle is statically known to be non-empty. Shared by `contains`/`startsWith`/`endsWith`.
 */
final class StringDispatchingResolver implements ResolverInterface
{
    public function __construct(
        private readonly IsStringResolver $isString,
        private readonly IsNonEmptyStringResolver $isNonEmptyString,
    ) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        \assert(isset($args[0]));

        if ($scope->getType($args[0]->value)->isNonEmptyString()->yes()) {
            return $this->isNonEmptyString->resolve($scope, $arg, ...$args);
        }

        return $this->isString->resolve($scope, $arg, ...$args);
    }
}
