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
    $assert = Assert::that($value)->isArray();
    assertType('Nexus\\Assert\\Expectation<array<mixed, mixed>>', $assert);
    assertType('array<mixed, mixed>', $value);
}

function test_is_bool(mixed $value): void
{
    $assert = Assert::that($value)->isBool();
    assertType('Nexus\\Assert\\Expectation<bool>', $assert);
    assertType('bool', $value);
}

function test_is_callable(mixed $value): void
{
    $assert = Assert::that($value)->isCallable();
    assertType('Nexus\\Assert\\Expectation<callable(): mixed>', $assert);
    assertType('callable(): mixed', $value);
}

function test_is_false(mixed $value): void
{
    $assert = Assert::that($value)->isFalse();
    assertType('Nexus\\Assert\\Expectation<false>', $assert);
    assertType('false', $value);
}

function test_is_float(mixed $value): void
{
    $assert = Assert::that($value)->isFloat();
    assertType('Nexus\\Assert\\Expectation<float>', $assert);
    assertType('float', $value);
}

function test_is_instance_of(mixed $value): void
{
    $assert = Assert::that($value)->isInstanceOf(\DateTimeInterface::class);
    assertType('Nexus\\Assert\\Expectation<DateTimeInterface>', $assert);
    assertType(\DateTimeInterface::class, $value);
}

function test_is_int(mixed $value): void
{
    $assert = Assert::that($value)->isInt();
    assertType('Nexus\\Assert\\Expectation<int>', $assert);
    assertType('int', $value);
}

function test_is_iterable(mixed $value): void
{
    $assert = Assert::that($value)->isIterable();
    assertType('Nexus\\Assert\\Expectation<iterable>', $assert);
    assertType('iterable', $value);
}

function test_is_null(mixed $value): void
{
    $assert = Assert::that($value)->isNull();
    assertType('Nexus\\Assert\\Expectation<null>', $assert);
    assertType('null', $value);
}

function test_is_numeric(mixed $value): void
{
    $assert = Assert::that($value)->isNumeric();
    assertType('Nexus\\Assert\\Expectation<float|int|numeric-string>', $assert);
    assertType('float|int|numeric-string', $value);
}

function test_is_object(mixed $value): void
{
    $assert = Assert::that($value)->isObject();
    assertType('Nexus\\Assert\\Expectation<object>', $assert);
    assertType('object', $value);
}

function test_is_resource(mixed $value): void
{
    $assert = Assert::that($value)->isResource();
    assertType('Nexus\\Assert\\Expectation<resource>', $assert);
    assertType('resource', $value);
}

function test_is_scalar(mixed $value): void
{
    $assert = Assert::that($value)->isScalar();
    assertType('Nexus\\Assert\\Expectation<bool|float|int|string>', $assert);
    assertType('bool|float|int|string', $value);
}

function test_is_string(mixed $value): void
{
    $assert = Assert::that($value)->isString();
    assertType('Nexus\\Assert\\Expectation<string>', $assert);
    assertType('string', $value);
}

function test_is_true(mixed $value): void
{
    $assert = Assert::that($value)->isTrue();
    assertType('Nexus\\Assert\\Expectation<true>', $assert);
    assertType('true', $value);
}
