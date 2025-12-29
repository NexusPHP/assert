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
    $assert = Assert::that($value)->not()->isArray();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~array<mixed, mixed>>', $assert);
    assertType('mixed~array<mixed, mixed>', $value);
}

function test_is_bool(mixed $value): void
{
    $assert = Assert::that($value)->not()->isBool();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~bool>', $assert);
    assertType('mixed~bool', $value);
}

function test_is_callable(mixed $value): void
{
    $assert = Assert::that($value)->not()->isCallable();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~callable(): mixed>', $assert);
    assertType('mixed~callable(): mixed', $value);
}

function test_is_false(mixed $value): void
{
    $assert = Assert::that($value)->not()->isFalse();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~false>', $assert);
    assertType('mixed~false', $value);
}

function test_is_float(mixed $value): void
{
    $assert = Assert::that($value)->not()->isFloat();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~float>', $assert);
    assertType('mixed~float', $value);
}

function test_is_instance_of(mixed $value): void
{
    $assert = Assert::that($value)->not()->isInstanceOf(\DateTimeInterface::class);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~DateTimeInterface>', $assert);
    assertType('mixed~DateTimeInterface', $value);
}

function test_is_int(mixed $value): void
{
    $assert = Assert::that($value)->not()->isInt();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~int>', $assert);
    assertType('mixed~int', $value);
}

function test_is_iterable(mixed $value): void
{
    $assert = Assert::that($value)->not()->isIterable();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~iterable>', $assert);
    assertType('mixed~iterable', $value);
}

function test_is_null(mixed $value): void
{
    $assert = Assert::that($value)->not()->isNull();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~null>', $assert);
    assertType('mixed~null', $value);
}

function test_is_numeric(mixed $value): void
{
    $assert = Assert::that($value)->not()->isNumeric();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(float|int|numeric-string)>', $assert);
    assertType('mixed~(float|int|numeric-string)', $value);
}

function test_is_object(mixed $value): void
{
    $assert = Assert::that($value)->not()->isObject();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~object>', $assert);
    assertType('mixed~object', $value);
}

function test_is_resource(mixed $value): void
{
    // failing is_resource check will not guarantee that $value is not a resource
    // as it can be a closed resource
    $assert = Assert::that($value)->not()->isResource();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_is_scalar(mixed $value): void
{
    $assert = Assert::that($value)->not()->isScalar();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(bool|float|int|string)>', $assert);
    assertType('mixed~(bool|float|int|string)', $value);
}

function test_is_string(mixed $value): void
{
    $assert = Assert::that($value)->not()->isString();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~string>', $assert);
    assertType('mixed~string', $value);
}

function test_is_true(mixed $value): void
{
    $assert = Assert::that($value)->not()->isTrue();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~true>', $assert);
    assertType('mixed~true', $value);
}
