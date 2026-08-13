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

namespace Nexus\Assert\Tests\TypeInference\ValuesIteratingExpectation;

use Nexus\Assert\Assert;

use function PHPStan\Testing\assertType;

function test_contains(mixed $a, mixed $b): void
{
    $assertA = Assert::that($a)->values()->contains('needle');
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<non-empty-string>>', $assertA);
    assertType('iterable<non-empty-string>', $a);

    $assertB = Assert::that($b)->values()->contains('');
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<string>>', $assertB);
    assertType('iterable<string>', $b);
}

function test_ends_with(mixed $a, mixed $b): void
{
    $assertA = Assert::that($a)->values()->endsWith('world');
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<non-empty-string>>', $assertA);
    assertType('iterable<non-empty-string>', $a);

    $assertB = Assert::that($b)->values()->endsWith('');
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<string>>', $assertB);
    assertType('iterable<string>', $b);
}

function test_has_max_length(mixed $value): void
{
    $assert = Assert::that($value)->values()->hasMaxLength(10);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<string>>', $assert);
    assertType('iterable<string>', $value);
}

function test_has_method(mixed $value): void
{
    $assert = Assert::that($value)->values()->hasMethod('jsonSerialize');
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<object&hasMethod(jsonSerialize)>>', $assert);
    assertType('iterable<object&hasMethod(jsonSerialize)>', $value);
}

function test_has_min_length(mixed $value): void
{
    $assert = Assert::that($value)->values()->hasMinLength(1);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<non-empty-string>>', $assert);
    assertType('iterable<non-empty-string>', $value);
}

function test_has_offset(mixed $value): void
{
    $assert = Assert::that($value)->values()->hasOffset('id');
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<non-empty-array<mixed, mixed>&hasOffset(\'id\')>>', $assert);
    assertType('iterable<non-empty-array<mixed, mixed>&hasOffset(\'id\')>', $value);
}

function test_has_property(mixed $value): void
{
    $assert = Assert::that($value)->values()->hasProperty('length');
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<object&hasProperty(length)>>', $assert);
    assertType('iterable<object&hasProperty(length)>', $value);
}

function test_implements_interface(mixed $value): void
{
    $assert = Assert::that($value)->values()->implementsInterface(\Countable::class);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<class-string<Countable>>>', $assert);
    assertType('iterable<class-string<Countable>>', $value);
}

function test_is_array(mixed $value): void
{
    $assert = Assert::that($value)->values()->isArray();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<array<mixed, mixed>>>', $assert);
    assertType('iterable<array<mixed, mixed>>', $value);
}

function test_is_array_key(mixed $value): void
{
    $assert = Assert::that($value)->values()->isArrayKey();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<int|string>>', $assert);
    assertType('iterable<int|string>', $value);
}

function test_is_between(mixed $value): void
{
    $assert = Assert::that($value)->values()->isBetween(0, 10);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<float|int<0, 10>>>', $assert);
    assertType('iterable<float|int<0, 10>>', $value);
}

function test_is_bool(mixed $value): void
{
    $assert = Assert::that($value)->values()->isBool();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<bool>>', $assert);
    assertType('iterable<bool>', $value);
}

function test_is_callable(mixed $value): void
{
    $assert = Assert::that($value)->values()->isCallable();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<callable(): mixed>>', $assert);
    assertType('iterable<callable(): mixed>', $value);
}

function test_is_class_string(mixed $value): void
{
    $assert = Assert::that($value)->values()->isClassString();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<class-string>>', $assert);
    assertType('iterable<class-string>', $value);
}

function test_is_countable(mixed $value): void
{
    $assert = Assert::that($value)->values()->isCountable();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<array<mixed>|Countable>>', $assert);
    assertType('iterable<array<mixed>|Countable>', $value);
}

function test_is_false(mixed $value): void
{
    $assert = Assert::that($value)->values()->isFalse();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<false>>', $assert);
    assertType('iterable<false>', $value);
}

function test_is_float(mixed $value): void
{
    $assert = Assert::that($value)->values()->isFloat();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<float>>', $assert);
    assertType('iterable<float>', $value);
}

function test_is_identical(mixed $value, string $other): void
{
    $assert = Assert::that($value)->values()->isIdentical($other);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<string>>', $assert);
    assertType('iterable<string>', $value);
}

function test_is_instance_of(mixed $value): void
{
    $assert = Assert::that($value)->values()->isInstanceOf(\stdClass::class);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<stdClass>>', $assert);
    assertType('iterable<stdClass>', $value);
}

function test_is_instance_of_any(mixed $value): void
{
    $assert = Assert::that($value)->values()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<Countable|DateTimeInterface>>', $assert);
    assertType('iterable<Countable|DateTimeInterface>', $value);
}

function test_is_int(mixed $value): void
{
    $assert = Assert::that($value)->values()->isInt();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<int>>', $assert);
    assertType('iterable<int>', $value);
}

function test_is_int_or_non_empty_string(mixed $value): void
{
    $assert = Assert::that($value)->values()->isIntOrNonEmptyString();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<int|non-empty-string>>', $assert);
    assertType('iterable<int|non-empty-string>', $value);
}

function test_is_iterable(mixed $value): void
{
    $assert = Assert::that($value)->values()->isIterable();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<iterable>>', $assert);
    assertType('iterable<iterable>', $value);
}

function test_is_list(mixed $value): void
{
    $assert = Assert::that($value)->values()->isList();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<list<mixed>>>', $assert);
    assertType('iterable<list<mixed>>', $value);
}

function test_is_lowercase_string(mixed $value): void
{
    $assert = Assert::that($value)->values()->isLowercaseString();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<lowercase-string>>', $assert);
    assertType('iterable<lowercase-string>', $value);
}

function test_is_map(mixed $value): void
{
    $assert = Assert::that($value)->values()->isMap();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<array<string, mixed>>>', $assert);
    assertType('iterable<array<string, mixed>>', $value);
}

function test_is_natural_int(mixed $value): void
{
    $assert = Assert::that($value)->values()->isNaturalInt();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<int<0, max>>>', $assert);
    assertType('iterable<int<0, max>>', $value);
}

function test_is_negative_int(mixed $value): void
{
    $assert = Assert::that($value)->values()->isNegativeInt();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<int<min, -1>>>', $assert);
    assertType('iterable<int<min, -1>>', $value);
}

function test_is_non_empty_list(mixed $value): void
{
    $assert = Assert::that($value)->values()->isNonEmptyList();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<non-empty-list<mixed>>>', $assert);
    assertType('iterable<non-empty-list<mixed>>', $value);
}

function test_is_non_empty_string(mixed $value): void
{
    $assert = Assert::that($value)->values()->isNonEmptyString();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<non-empty-string>>', $assert);
    assertType('iterable<non-empty-string>', $value);
}

function test_is_null(mixed $value): void
{
    $assert = Assert::that($value)->values()->isNull();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<null>>', $assert);
    assertType('iterable<null>', $value);
}

function test_is_numeric(mixed $value): void
{
    $assert = Assert::that($value)->values()->isNumeric();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<float|int|numeric-string>>', $assert);
    assertType('iterable<float|int|numeric-string>', $value);
}

function test_is_numeric_string(mixed $value): void
{
    $assert = Assert::that($value)->values()->isNumericString();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<numeric-string>>', $assert);
    assertType('iterable<numeric-string>', $value);
}

function test_is_object(mixed $value): void
{
    $assert = Assert::that($value)->values()->isObject();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<object>>', $assert);
    assertType('iterable<object>', $value);
}

function test_is_one_of(mixed $value): void
{
    $assert = Assert::that($value)->values()->isOneOf(['light', 'dark']);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<\'dark\'|\'light\'>>', $assert);
    assertType('iterable<\'dark\'|\'light\'>', $value);
}

function test_is_positive_int(mixed $value): void
{
    $assert = Assert::that($value)->values()->isPositiveInt();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<int<1, max>>>', $assert);
    assertType('iterable<int<1, max>>', $value);
}

function test_is_resource(mixed $value): void
{
    $assert = Assert::that($value)->values()->isResource();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<resource>>', $assert);
    assertType('iterable<resource>', $value);
}

function test_is_same_or_subclass_of(mixed $value): void
{
    $assert = Assert::that($value)->values()->isSameOrSubclassOf(\stdClass::class);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<class-string<stdClass>|stdClass>>', $assert);
    assertType('iterable<class-string<stdClass>|stdClass>', $value);
}

function test_is_scalar(mixed $value): void
{
    $assert = Assert::that($value)->values()->isScalar();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<bool|float|int|string>>', $assert);
    assertType('iterable<bool|float|int|string>', $value);
}

function test_is_string(mixed $value): void
{
    $assert = Assert::that($value)->values()->isString();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<string>>', $assert);
    assertType('iterable<string>', $value);
}

function test_is_subclass_of(mixed $value): void
{
    $assert = Assert::that($value)->values()->isSubclassOf(\stdClass::class);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<class-string<stdClass>|stdClass>>', $assert);
    assertType('iterable<class-string<stdClass>|stdClass>', $value);
}

function test_is_true(mixed $value): void
{
    $assert = Assert::that($value)->values()->isTrue();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<true>>', $assert);
    assertType('iterable<true>', $value);
}

function test_is_uppercase_string(mixed $value): void
{
    $assert = Assert::that($value)->values()->isUppercaseString();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<uppercase-string>>', $assert);
    assertType('iterable<uppercase-string>', $value);
}

function test_is_url(mixed $value): void
{
    $assert = Assert::that($value)->values()->isUrl();
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<string>>', $assert);
    assertType('iterable<string>', $value);
}

function test_matches_regular_expression(mixed $value, string $pattern): void
{
    $assert = Assert::that($value)->values()->matchesRegularExpression($pattern);
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<string>>', $assert);
    assertType('iterable<string>', $value);
}

function test_starts_with(mixed $a, mixed $b): void
{
    $assertA = Assert::that($a)->values()->startsWith('hello');
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<non-empty-string>>', $assertA);
    assertType('iterable<non-empty-string>', $a);

    $assertB = Assert::that($b)->values()->startsWith('');
    assertType('Nexus\\Assert\\ValuesIteratingExpectation<iterable<string>>', $assertB);
    assertType('iterable<string>', $b);
}
