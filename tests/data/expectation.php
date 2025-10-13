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

use function PHPStan\Testing\assertType;

function test_is_bool(mixed $value): void
{
    $assert = Assert::that($value)->isBool();
    assertType('Nexus\\Assert\\Expectation<bool>', $assert);
}

function test_is_float(mixed $value): void
{
    $assert = Assert::that($value)->isFloat();
    assertType('Nexus\\Assert\\Expectation<float>', $assert);
}

function test_is_int(mixed $value): void
{
    $assert = Assert::that($value)->isInt();
    assertType('Nexus\\Assert\\Expectation<int>', $assert);
}

function test_is_null(mixed $value): void
{
    $assert = Assert::that($value)->isNull();
    assertType('Nexus\\Assert\\Expectation<null>', $assert);
}

function test_is_numeric(mixed $value): void
{
    $assert = Assert::that($value)->isNumeric();
    assertType('Nexus\\Assert\\Expectation<float|int|numeric-string>', $assert);
}

function test_is_object(mixed $value): void
{
    $assert = Assert::that($value)->isObject();
    assertType('Nexus\\Assert\\Expectation<object>', $assert);
}

function test_is_scalar(mixed $value): void
{
    $assert = Assert::that($value)->isScalar();
    assertType('Nexus\\Assert\\Expectation<bool|float|int|string>', $assert);
}

function test_is_string(mixed $value): void
{
    $assert = Assert::that($value)->isString();
    assertType('Nexus\\Assert\\Expectation<string>', $assert);
}
