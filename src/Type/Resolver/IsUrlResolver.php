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
 * Narrows to `non-empty-string`.
 */
final class IsUrlResolver implements ResolverInterface
{
    public function __construct(private readonly IsStringResolver $isString) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        return new Node\Expr\BinaryOp\BooleanAnd(
            $this->isString->resolve($scope, $arg, ...$args),
            new Node\Expr\BinaryOp\NotIdentical(
                new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('filter_var'),
                    [
                        $arg,
                        new Node\Arg(new Node\Expr\ConstFetch(new Node\Name\FullyQualified('FILTER_VALIDATE_URL'))),
                    ],
                ),
                new Node\Expr\ConstFetch(new Node\Name('false')),
            ),
        );
    }
}
