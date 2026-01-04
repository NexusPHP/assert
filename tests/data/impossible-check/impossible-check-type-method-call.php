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

namespace Nexus\Assert\Tests;

use Nexus\Assert\Assert;

/**
 * @param array<string, mixed> $value
 */
function test_is_array(array $value): void
{
    Assert::that($value)->isArray();
}

function test_is_instance_of(\stdClass $value): void
{
    Assert::that($value)->isInstanceOf(\stdClass::class);
    Assert::that($value)->isInstanceOf($value);
}
