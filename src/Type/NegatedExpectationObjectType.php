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

namespace Nexus\Assert\Type;

use Nexus\Assert\NegatedExpectation;
use PhpParser\Node;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Type;

final class NegatedExpectationObjectType extends GenericObjectType implements ExpectableObjectType
{
    /**
     * @param array<int, Type> $types
     */
    public function __construct(
        array $types,
        private readonly Node\Expr $expr,
    ) {
        parent::__construct(NegatedExpectation::class, $types);
    }

    public function getValueExpr(): Node\Expr
    {
        return $this->expr;
    }
}
