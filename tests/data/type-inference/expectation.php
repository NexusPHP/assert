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

namespace Nexus\Assert\Tests\TypeInference\Expectation;

use Nexus\Assert\Assert;

use function PHPStan\Testing\assertType;

function test_contains(mixed $a, mixed $b): void
{
    $assertA = Assert::that($a)->contains('needle');
    assertType('Nexus\\Assert\\Expectation<non-empty-string>', $assertA);
    assertType('non-empty-string', $a);

    $assertB = Assert::that($b)->contains('');
    assertType('Nexus\\Assert\\Expectation<string>', $assertB);
    assertType('string', $b);
}

function test_ends_with(mixed $a, mixed $b): void
{
    $assert = Assert::that($a)->endsWith('world');
    assertType('Nexus\\Assert\\Expectation<non-empty-string>', $assert);
    assertType('non-empty-string', $a);

    $assertB = Assert::that($b)->endsWith('');
    assertType('Nexus\\Assert\\Expectation<string>', $assertB);
    assertType('string', $b);
}

function test_has_max_length(mixed $value): void
{
    $assert = Assert::that($value)->hasMaxLength(10);
    assertType('Nexus\\Assert\\Expectation<string>', $assert);
    assertType('string', $value);
}

function test_has_method(mixed $value): void
{
    $assert = Assert::that($value)->hasMethod('jsonSerialize');
    assertType('Nexus\\Assert\\Expectation<object&hasMethod(jsonSerialize)>', $assert);
    assertType('object&hasMethod(jsonSerialize)', $value);
}

function test_has_min_length(mixed $value): void
{
    $assert = Assert::that($value)->hasMinLength(1);
    assertType('Nexus\\Assert\\Expectation<non-empty-string>', $assert);
    assertType('non-empty-string', $value);
}

function test_has_offset(mixed $value): void
{
    $assert = Assert::that($value)->hasOffset('id');
    assertType('Nexus\\Assert\\Expectation<non-empty-array<mixed, mixed>&hasOffset(\'id\')>', $assert);
    assertType('non-empty-array<mixed, mixed>&hasOffset(\'id\')', $value);
}

function test_has_property(mixed $value): void
{
    $assert = Assert::that($value)->hasProperty('length');
    assertType('Nexus\\Assert\\Expectation<object&hasProperty(length)>', $assert);
    assertType('object&hasProperty(length)', $value);
}

function test_is_array(mixed $value): void
{
    $assert = Assert::that($value)->isArray();
    assertType('Nexus\\Assert\\Expectation<array<mixed, mixed>>', $assert);
    assertType('array<mixed, mixed>', $value);
}

function test_is_array_key(mixed $value): void
{
    $assert = Assert::that($value)->isArrayKey();
    assertType('Nexus\\Assert\\Expectation<int|string>', $assert);
    assertType('int|string', $value);
}

function test_is_between(mixed $value): void
{
    $assert = Assert::that($value)->isBetween(0, 10);
    assertType('Nexus\\Assert\\Expectation<float|int<0, 10>>', $assert);
    assertType('float|int<0, 10>', $value);
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

function test_is_countable(mixed $value): void
{
    $assert = Assert::that($value)->isCountable();
    assertType('Nexus\\Assert\\Expectation<array<mixed>|Countable>', $assert);
    assertType('array<mixed>|Countable', $value);
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

function test_is_int(mixed $value): void
{
    $assert = Assert::that($value)->isInt();
    assertType('Nexus\\Assert\\Expectation<int>', $assert);
    assertType('int', $value);
}

function test_is_int_or_non_empty_string(mixed $value): void
{
    $assert = Assert::that($value)->isIntOrNonEmptyString();
    assertType('Nexus\\Assert\\Expectation<int|non-empty-string>', $assert);
    assertType('int|non-empty-string', $value);
}

function test_is_iterable(mixed $value): void
{
    $assert = Assert::that($value)->isIterable();
    assertType('Nexus\\Assert\\Expectation<iterable>', $assert);
    assertType('iterable', $value);
}

function test_is_list(mixed $value): void
{
    $assert = Assert::that($value)->isList();
    assertType('Nexus\\Assert\\Expectation<list<mixed>>', $assert);
    assertType('list<mixed>', $value);
}

function test_is_lowercase_string(mixed $value): void
{
    $assert = Assert::that($value)->isLowercaseString();
    assertType('Nexus\\Assert\\Expectation<lowercase-string>', $assert);
    assertType('lowercase-string', $value);
}

function test_is_map(mixed $value): void
{
    $assert = Assert::that($value)->isMap();
    assertType('Nexus\\Assert\\Expectation<array<string, mixed>>', $assert);
    assertType('array<string, mixed>', $value);
}

function test_is_natural_int(mixed $value): void
{
    $assert = Assert::that($value)->isNaturalInt();
    assertType('Nexus\\Assert\\Expectation<int<0, max>>', $assert);
    assertType('int<0, max>', $value);
}

function test_is_negative_int(mixed $value): void
{
    $assert = Assert::that($value)->isNegativeInt();
    assertType('Nexus\\Assert\\Expectation<int<min, -1>>', $assert);
    assertType('int<min, -1>', $value);
}

function test_is_non_empty_string(mixed $value): void
{
    $assert = Assert::that($value)->isNonEmptyString();
    assertType('Nexus\\Assert\\Expectation<non-empty-string>', $assert);
    assertType('non-empty-string', $value);
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

function test_is_one_of(mixed $value): void
{
    $assert = Assert::that($value)->isOneOf(['light', 'dark']);
    assertType('Nexus\\Assert\\Expectation<\'dark\'|\'light\'>', $assert);
    assertType('\'dark\'|\'light\'', $value);
}

function test_is_positive_int(mixed $value): void
{
    $assert = Assert::that($value)->isPositiveInt();
    assertType('Nexus\\Assert\\Expectation<int<1, max>>', $assert);
    assertType('int<1, max>', $value);
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

function test_is_uppercase_string(mixed $value): void
{
    $assert = Assert::that($value)->isUppercaseString();
    assertType('Nexus\\Assert\\Expectation<uppercase-string>', $assert);
    assertType('uppercase-string', $value);
}

function test_is_url(mixed $value): void
{
    $assert = Assert::that($value)->isUrl();
    assertType('Nexus\\Assert\\Expectation<string>', $assert);
    assertType('string', $value);
}

function test_matches_regular_expression(mixed $value, string $pattern): void
{
    $assert = Assert::that($value)->matchesRegularExpression($pattern);
    assertType('Nexus\\Assert\\Expectation<string>', $assert);
    assertType('string', $value);
}

function test_starts_with(mixed $a, mixed $b): void
{
    $assert = Assert::that($a)->startsWith('hello');
    assertType('Nexus\\Assert\\Expectation<non-empty-string>', $assert);
    assertType('non-empty-string', $a);

    $assertB = Assert::that($b)->startsWith('');
    assertType('Nexus\\Assert\\Expectation<string>', $assertB);
    assertType('string', $b);
}
