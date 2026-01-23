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

function test_is_array_not_has_offset(mixed $value): void
{
    $assert = Assert::that($value)->isArray()->not()->hasOffset('id');
    assertType('Nexus\\Assert\\NegatedExpectation<array<mixed, mixed>>', $assert);
    assertType('array<mixed, mixed>', $value);
}

function test_is_countable_not_is_array(mixed $value): void
{
    $assert = Assert::that($value)->isCountable()->not()->isArray();
    assertType('Nexus\\Assert\\NegatedExpectation<Countable>', $assert);
    assertType(\Countable::class, $value);
}

function test_is_int_not_is_natural_int(mixed $value): void
{
    $assert = Assert::that($value)->isInt()->not()->isNaturalInt();
    assertType('Nexus\\Assert\\NegatedExpectation<int<min, -1>>', $assert);
    assertType('int<min, -1>', $value);
}

function test_is_int_not_is_negative_int(mixed $value): void
{
    $assert = Assert::that($value)->isInt()->not()->isNegativeInt();
    assertType('Nexus\\Assert\\NegatedExpectation<int<0, max>>', $assert);
    assertType('int<0, max>', $value);
}

function test_is_int_not_is_negative_int_or_positive_int(mixed $value): void
{
    $assert = Assert::that($value)->isInt()->not()->isNegativeInt()->isPositiveInt();
    assertType('Nexus\\Assert\\NegatedExpectation<0>', $assert);
    assertType('0', $value);
}

function test_is_int_not_is_positive_int(mixed $value): void
{
    $assert = Assert::that($value)->isInt()->not()->isPositiveInt();
    assertType('Nexus\\Assert\\NegatedExpectation<int<min, 0>>', $assert);
    assertType('int<min, 0>', $value);
}

function test_is_numeric_string(mixed $a, mixed $b): void
{
    $assert1 = Assert::that($a)->isString()->isNumeric();
    assertType('Nexus\\Assert\\Expectation<numeric-string>', $assert1);
    assertType('numeric-string', $a);

    $assert2 = Assert::that($b)->isNumeric()->isString();
    assertType('Nexus\\Assert\\Expectation<numeric-string>', $assert2);
    assertType('numeric-string', $b);
}

function test_is_numeric_not_is_string(mixed $value): void
{
    $assert = Assert::that($value)->isNumeric()->not()->isString();
    assertType('Nexus\\Assert\\NegatedExpectation<float|int>', $assert);
    assertType('float|int', $value);
}

function test_is_object_not_has_method(mixed $value): void
{
    $assert = Assert::that($value)->isObject()->not()->hasMethod('jsonSerialize');
    assertType('Nexus\\Assert\\NegatedExpectation<object>', $assert);
    assertType('object', $value);
}

function test_is_object_not_has_property(mixed $value): void
{
    $assert = Assert::that($value)->isObject()->not()->hasProperty('id');
    assertType('Nexus\\Assert\\NegatedExpectation<object>', $assert);
    assertType('object', $value);
}

function test_is_scalar_not_is_float_or_is_int(mixed $value): void
{
    $assert = Assert::that($value)->isScalar()->not()->isFloat()->isInt();
    assertType('Nexus\\Assert\\NegatedExpectation<bool|string>', $assert);
    assertType('bool|string', $value);
}

function test_is_string_not_is_non_empty_string(mixed $value): void
{
    $assert = Assert::that($value)->isString()->not()->isNonEmptyString();
    assertType('Nexus\\Assert\\NegatedExpectation<\'\'>', $assert);
    assertType('\'\'', $value);
}
