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

namespace Nexus\Assert\Tests\TypeInference\NullableExpectation;

use Nexus\Assert\Assert;

use function PHPStan\Testing\assertType;

function test_contains(mixed $a, mixed $b): void
{
    $assertA = Assert::that($a)->nullOr()->contains('needle');
    assertType('Nexus\\Assert\\NullableExpectation<non-empty-string|null>', $assertA);
    assertType('non-empty-string|null', $a);

    $assertB = Assert::that($b)->nullOr()->contains('');
    assertType('Nexus\\Assert\\NullableExpectation<string|null>', $assertB);
    assertType('string|null', $b);
}

function test_ends_with(mixed $a, mixed $b): void
{
    $assertA = Assert::that($a)->nullOr()->endsWith('world');
    assertType('Nexus\\Assert\\NullableExpectation<non-empty-string|null>', $assertA);
    assertType('non-empty-string|null', $a);

    $assertB = Assert::that($b)->nullOr()->endsWith('');
    assertType('Nexus\\Assert\\NullableExpectation<string|null>', $assertB);
    assertType('string|null', $b);
}

function test_has_method(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->hasMethod('jsonSerialize');
    assertType('Nexus\\Assert\\NullableExpectation<(object&hasMethod(jsonSerialize))|null>', $assert);
    assertType('(object&hasMethod(jsonSerialize))|null', $value);
}

function test_has_offset(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->hasOffset('id');
    assertType('Nexus\\Assert\\NullableExpectation<(non-empty-array<mixed, mixed>&hasOffset(\'id\'))|null>', $assert);
    assertType('(non-empty-array<mixed, mixed>&hasOffset(\'id\'))|null', $value);
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

function test_is_array_key(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isArrayKey();
    assertType('Nexus\\Assert\\NullableExpectation<int|string|null>', $assert);
    assertType('int|string|null', $value);
}

function test_is_between(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isBetween(0, 10);
    assertType('Nexus\\Assert\\NullableExpectation<float|int<0, 10>|null>', $assert);
    assertType('float|int<0, 10>|null', $value);
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

function test_is_list(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isList();
    assertType('Nexus\\Assert\\NullableExpectation<list<mixed>|null>', $assert);
    assertType('list<mixed>|null', $value);
}

function test_is_lowercase_string(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isLowercaseString();
    assertType('Nexus\\Assert\\NullableExpectation<lowercase-string|null>', $assert);
    assertType('lowercase-string|null', $value);
}

function test_is_map(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isMap();
    assertType('Nexus\\Assert\\NullableExpectation<array<string, mixed>|null>', $assert);
    assertType('array<string, mixed>|null', $value);
}

function test_is_natural_int(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isNaturalInt();
    assertType('Nexus\\Assert\\NullableExpectation<int<0, max>|null>', $assert);
    assertType('int<0, max>|null', $value);
}

function test_is_negative_int(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isNegativeInt();
    assertType('Nexus\\Assert\\NullableExpectation<int<min, -1>|null>', $assert);
    assertType('int<min, -1>|null', $value);
}

function test_is_non_empty_string(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isNonEmptyString();
    assertType('Nexus\\Assert\\NullableExpectation<non-empty-string|null>', $assert);
    assertType('non-empty-string|null', $value);
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

function test_is_positive_int(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isPositiveInt();
    assertType('Nexus\\Assert\\NullableExpectation<int<1, max>|null>', $assert);
    assertType('int<1, max>|null', $value);
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

function test_is_uppercase_string(mixed $value): void
{
    $assert = Assert::that($value)->nullOr()->isUppercaseString();
    assertType('Nexus\\Assert\\NullableExpectation<uppercase-string|null>', $assert);
    assertType('uppercase-string|null', $value);
}

function test_matches_regular_expression(mixed $value, string $pattern): void
{
    $assert = Assert::that($value)->nullOr()->matchesRegularExpression($pattern);
    assertType('Nexus\\Assert\\NullableExpectation<string|null>', $assert);
    assertType('string|null', $value);
}

function test_starts_with(mixed $a, mixed $b): void
{
    $assertA = Assert::that($a)->nullOr()->startsWith('hello');
    assertType('Nexus\\Assert\\NullableExpectation<non-empty-string|null>', $assertA);
    assertType('non-empty-string|null', $a);

    $assertB = Assert::that($b)->nullOr()->startsWith('');
    assertType('Nexus\\Assert\\NullableExpectation<string|null>', $assertB);
    assertType('string|null', $b);
}
