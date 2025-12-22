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

function test_is_array(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isArray();
    assertType('Nexus\\Assert\\NullableExpectation<array|null>', $assert);
    assertType('array|null', $value);
}

function test_is_bool(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isBool();
    assertType('Nexus\\Assert\\NullableExpectation<bool|null>', $assert);
    assertType('bool|null', $value);
}

function test_is_false(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isFalse();
    assertType('Nexus\\Assert\\NullableExpectation<false|null>', $assert);
    assertType('false|null', $value);
}

function test_is_float(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isFloat();
    assertType('Nexus\\Assert\\NullableExpectation<float|null>', $assert);
    assertType('float|null', $value);
}

function test_is_instance_of(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isInstanceOf(\DateTimeInterface::class);
    assertType('Nexus\\Assert\\NullableExpectation<DateTimeInterface|null>', $assert);
    assertType('DateTimeInterface|null', $value);
}

function test_is_int(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isInt();
    assertType('Nexus\\Assert\\NullableExpectation<int|null>', $assert);
    assertType('int|null', $value);
}

function test_is_iterable(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isIterable();
    assertType('Nexus\\Assert\\NullableExpectation<iterable|null>', $assert);
    assertType('iterable|null', $value);
}

function test_is_null(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isNull();
    assertType('Nexus\\Assert\\NullableExpectation<null>', $assert);
    assertType('null', $value);
}

function test_is_numeric(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isNumeric();
    assertType('Nexus\\Assert\\NullableExpectation<float|int|numeric-string|null>', $assert);
    assertType('float|int|numeric-string|null', $value);
}

function test_is_object(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isObject();
    assertType('Nexus\\Assert\\NullableExpectation<object|null>', $assert);
    assertType('object|null', $value);
}

function test_is_scalar(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isScalar();
    assertType('Nexus\\Assert\\NullableExpectation<bool|float|int|string|null>', $assert);
    assertType('bool|float|int|string|null', $value);
}

function test_is_string(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isString();
    assertType('Nexus\\Assert\\NullableExpectation<string|null>', $assert);
    assertType('string|null', $value);
}

function test_is_true(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isTrue();
    assertType('Nexus\\Assert\\NullableExpectation<true|null>', $assert);
    assertType('true|null', $value);
}
