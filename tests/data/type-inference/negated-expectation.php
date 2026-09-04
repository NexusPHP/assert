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

namespace Nexus\Assert\Tests\TypeInference\NegatedExpectation;

use Nexus\Assert\Assert;

use function PHPStan\Testing\assertType;

function test_contains(mixed $a, mixed $b): void
{
    $assertA = Assert::that($a)->not()->contains('needle');
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assertA);
    assertType('mixed', $a);

    $assertB = Assert::that($b)->not()->contains('');
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assertB);
    assertType('mixed', $b);
}

function test_ends_with(mixed $a, mixed $b): void
{
    $assertA = Assert::that($a)->not()->endsWith('world');
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assertA);
    assertType('mixed', $a);

    $assertB = Assert::that($b)->not()->endsWith('');
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assertB);
    assertType('mixed', $b);
}

function test_has_count(mixed $value): void
{
    $assert = Assert::that($value)->not()->hasCount(3);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_has_length(mixed $value): void
{
    $assert = Assert::that($value)->not()->hasLength(32);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_has_max_count(mixed $value): void
{
    $assert = Assert::that($value)->not()->hasMaxCount(3);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_has_max_length(mixed $value): void
{
    $assert = Assert::that($value)->not()->hasMaxLength(10);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_has_method(mixed $value): void
{
    $assert = Assert::that($value)->not()->hasMethod('jsonSerialize');
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_has_min_count(mixed $value): void
{
    $assert = Assert::that($value)->not()->hasMinCount(1);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_has_min_length(mixed $value): void
{
    $assert = Assert::that($value)->not()->hasMinLength(3);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_has_offset(mixed $value): void
{
    $assert = Assert::that($value)->not()->hasOffset('id');
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_has_property(mixed $value): void
{
    $assert = Assert::that($value)->not()->hasProperty('length');
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_implements_interface(mixed $value): void
{
    $assert = Assert::that($value)->not()->implementsInterface(\Countable::class);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~class-string<Countable>>', $assert);
    assertType('mixed~class-string<Countable>', $value);
}

function test_is_array(mixed $value): void
{
    $assert = Assert::that($value)->not()->isArray();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~array<mixed, mixed>>', $assert);
    assertType('mixed~array<mixed, mixed>', $value);
}

function test_is_array_accessible(mixed $value): void
{
    $assert = Assert::that($value)->not()->isArrayAccessible();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(array<mixed, mixed>|ArrayAccess)>', $assert);
    assertType('mixed~(array<mixed, mixed>|ArrayAccess)', $value);
}

function test_is_array_key(mixed $value): void
{
    $assert = Assert::that($value)->not()->isArrayKey();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(int|string)>', $assert);
    assertType('mixed~(int|string)', $value);
}

function test_is_between(mixed $value): void
{
    $assert = Assert::that($value)->not()->isBetween(0, 10);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(float|int<0, 10>)>', $assert);
    assertType('mixed~(float|int<0, 10>)', $value);
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

function test_is_class_string(mixed $value): void
{
    $assert = Assert::that($value)->not()->isClassString();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_is_countable(mixed $value): void
{
    $assert = Assert::that($value)->not()->isCountable();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(array<mixed>|Countable)>', $assert);
    assertType('mixed~(array<mixed>|Countable)', $value);
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

function test_is_greater_than(mixed $value): void
{
    $assert = Assert::that($value)->not()->isGreaterThan(5);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(float|int<6, max>)>', $assert);
    assertType('mixed~(float|int<6, max>)', $value);
}

function test_is_greater_than_or_equal(mixed $value): void
{
    $assert = Assert::that($value)->not()->isGreaterThanOrEqual(5);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(float|int<5, max>)>', $assert);
    assertType('mixed~(float|int<5, max>)', $value);
}

function test_is_instance_of_any(mixed $value): void
{
    $assert = Assert::that($value)->not()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(Countable|DateTimeInterface)>', $assert);
    assertType('mixed~(Countable|DateTimeInterface)', $value);
}

function test_is_int(mixed $value): void
{
    $assert = Assert::that($value)->not()->isInt();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~int>', $assert);
    assertType('mixed~int', $value);
}

function test_is_int_or_non_empty_string(mixed $value): void
{
    $assert = Assert::that($value)->not()->isIntOrNonEmptyString();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(int|non-empty-string)>', $assert);
    assertType('mixed~(int|non-empty-string)', $value);
}

function test_is_iterable(mixed $value): void
{
    $assert = Assert::that($value)->not()->isIterable();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~iterable>', $assert);
    assertType('mixed~iterable', $value);
}

function test_is_less_than(mixed $value): void
{
    $assert = Assert::that($value)->not()->isLessThan(5);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(float|int<min, 4>)>', $assert);
    assertType('mixed~(float|int<min, 4>)', $value);
}

function test_is_less_than_or_equal(mixed $value): void
{
    $assert = Assert::that($value)->not()->isLessThanOrEqual(5);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(float|int<min, 5>)>', $assert);
    assertType('mixed~(float|int<min, 5>)', $value);
}

function test_is_list(mixed $value): void
{
    $assert = Assert::that($value)->not()->isList();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_is_lowercase_string(mixed $value): void
{
    $assert = Assert::that($value)->not()->isLowercaseString();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_is_map(mixed $value): void
{
    $assert = Assert::that($value)->not()->isMap();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_is_natural_int(mixed $value): void
{
    $assert = Assert::that($value)->not()->isNaturalInt();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~int<0, max>>', $assert);
    assertType('mixed~int<0, max>', $value);
}

function test_is_negative_int(mixed $value): void
{
    $assert = Assert::that($value)->not()->isNegativeInt();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~int<min, -1>>', $assert);
    assertType('mixed~int<min, -1>', $value);
}

function test_is_non_empty_list(mixed $value): void
{
    $assert = Assert::that($value)->not()->isNonEmptyList();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_is_non_empty_map(mixed $value): void
{
    $assert = Assert::that($value)->not()->isNonEmptyMap();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_is_non_empty_string(mixed $value): void
{
    $assert = Assert::that($value)->not()->isNonEmptyString();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~non-empty-string>', $assert);
    assertType('mixed~non-empty-string', $value);
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

function test_is_numeric_string(mixed $value): void
{
    $assert = Assert::that($value)->not()->isNumericString();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~numeric-string>', $assert);
    assertType('mixed~numeric-string', $value);
}

function test_is_object(mixed $value): void
{
    $assert = Assert::that($value)->not()->isObject();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~object>', $assert);
    assertType('mixed~object', $value);
}

function test_is_one_of(mixed $value): void
{
    $assert = Assert::that($value)->not()->isOneOf(['light', 'dark']);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(\'dark\'|\'light\')>', $assert);
    assertType('mixed~(\'dark\'|\'light\')', $value);
}

function test_is_positive_int(mixed $value): void
{
    $assert = Assert::that($value)->not()->isPositiveInt();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~int<1, max>>', $assert);
    assertType('mixed~int<1, max>', $value);
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

function test_is_uppercase_string(mixed $value): void
{
    $assert = Assert::that($value)->not()->isUppercaseString();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_is_url(mixed $value): void
{
    $assert = Assert::that($value)->not()->isUrl();
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_matches_regular_expression(mixed $value, string $pattern): void
{
    $assert = Assert::that($value)->not()->matchesRegularExpression($pattern);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert);
    assertType('mixed', $value);
}

function test_starts_with(mixed $a, mixed $b): void
{
    $assertA = Assert::that($a)->not()->startsWith('hello');
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assertA);
    assertType('mixed', $a);

    $assertB = Assert::that($b)->not()->startsWith('');
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assertB);
    assertType('mixed', $b);
}
