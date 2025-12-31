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

function test_has_method(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->hasMethod('jsonSerialize');
    assertType('Nexus\\Assert\\NullableExpectation<(object&hasMethod(jsonSerialize))|null>', $assert);
    assertType('(object&hasMethod(jsonSerialize))|null', $value);
}

function test_has_property(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->hasProperty('length');
    assertType('Nexus\\Assert\\NullableExpectation<(object&hasProperty(length))|null>', $assert);
    assertType('(object&hasProperty(length))|null', $value);
}

function test_is_array(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isArray();
    assertType('Nexus\\Assert\\NullableExpectation<array<mixed, mixed>|null>', $assert);
    assertType('array<mixed, mixed>|null', $value);
}

function test_is_bool(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isBool();
    assertType('Nexus\\Assert\\NullableExpectation<bool|null>', $assert);
    assertType('bool|null', $value);
}

function test_is_callable(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isCallable();
    assertType('Nexus\\Assert\\NullableExpectation<(callable(): mixed)|null>', $assert);
    assertType('(callable(): mixed)|null', $value);
}

function test_is_countable(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isCountable();
    assertType('Nexus\\Assert\\NullableExpectation<array<mixed>|Countable|null>', $assert);
    assertType('array<mixed>|Countable|null', $value);
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

function test_is_resource(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isResource();
    assertType('Nexus\\Assert\\NullableExpectation<resource|null>', $assert);
    assertType('resource|null', $value);
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
