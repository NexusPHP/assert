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

namespace Nexus\Assert\Tests\TypeInference\KeysIteratingExpectation;

use Nexus\Assert\Assert;

use function PHPStan\Testing\assertType;

function test_contains(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->contains('needle');
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<non-empty-string, mixed>>', $assert1);
    assertType('iterable<non-empty-string, mixed>', $value1);

    $assert2 = Assert::that($value2)->keys()->contains('');
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<string, mixed>>', $assert2);
    assertType('iterable<string, mixed>', $value2);
}

function test_ends_with(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->endsWith('world');
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<non-empty-string, mixed>>', $assert1);
    assertType('iterable<non-empty-string, mixed>', $value1);

    $assert2 = Assert::that($value2)->keys()->endsWith('');
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<string, mixed>>', $assert2);
    assertType('iterable<string, mixed>', $value2);
}

function test_has_length(mixed $value): void
{
    $assert = Assert::that($value)->keys()->hasLength(32);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<non-falsy-string, mixed>>', $assert);
    assertType('iterable<non-falsy-string, mixed>', $value);
}

function test_has_max_length(mixed $value): void
{
    $assert = Assert::that($value)->keys()->hasMaxLength(10);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<string, mixed>>', $assert);
    assertType('iterable<string, mixed>', $value);
}

function test_has_method(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->hasMethod('jsonSerialize');
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<object&hasMethod(jsonSerialize), mixed>>', $assert1);
    assertType('iterable<object&hasMethod(jsonSerialize), mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->hasMethod('jsonSerialize');
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_has_min_length(mixed $value): void
{
    $assert = Assert::that($value)->keys()->hasMinLength(1);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<non-empty-string, mixed>>', $assert);
    assertType('iterable<non-empty-string, mixed>', $value);
}

function test_has_offset(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->hasOffset('id');
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<non-empty-array<mixed, mixed>&hasOffset(\'id\'), mixed>>', $assert1);
    assertType('iterable<non-empty-array<mixed, mixed>&hasOffset(\'id\'), mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->hasOffset('id');
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_has_property(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->hasProperty('length');
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<object&hasProperty(length), mixed>>', $assert1);
    assertType('iterable<object&hasProperty(length), mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->hasProperty('length');
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_implements_interface(mixed $value): void
{
    $assert = Assert::that($value)->keys()->implementsInterface(\Countable::class);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<class-string<Countable>, mixed>>', $assert);
    assertType('iterable<class-string<Countable>, mixed>', $value);
}

function test_is_array(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isArray();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<array<mixed, mixed>, mixed>>', $assert1);
    assertType('iterable<array<mixed, mixed>, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isArray();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_array_key(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isArrayKey();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<int|string, mixed>>', $assert);
    assertType('iterable<int|string, mixed>', $value);
}

function test_is_between(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isBetween(0, 10);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<float|int<0, 10>, mixed>>', $assert);
    assertType('iterable<float|int<0, 10>, mixed>', $value);
}

function test_is_bool(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isBool();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<bool, mixed>>', $assert1);
    assertType('iterable<bool, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isBool();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_callable(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isCallable();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<callable(): mixed, mixed>>', $assert);
    assertType('iterable<callable(): mixed, mixed>', $value);
}

function test_is_class_string(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isClassString();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<class-string, mixed>>', $assert);
    assertType('iterable<class-string, mixed>', $value);
}

function test_is_countable(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isCountable();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<array<mixed>|Countable, mixed>>', $assert1);
    assertType('iterable<array<mixed>|Countable, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isCountable();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_false(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isFalse();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<false, mixed>>', $assert1);
    assertType('iterable<false, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isFalse();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_float(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isFloat();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<float, mixed>>', $assert1);
    assertType('iterable<float, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isFloat();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_identical(mixed $value, string $other): void
{
    $assert = Assert::that($value)->keys()->isIdentical($other);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<string, mixed>>', $assert);
    assertType('iterable<string, mixed>', $value);
}

function test_is_instance_of(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isInstanceOf(\stdClass::class);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<stdClass, mixed>>', $assert1);
    assertType('iterable<stdClass, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isInstanceOf(\stdClass::class);
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_instance_of_any(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<Countable|DateTimeInterface, mixed>>', $assert);
    assertType('iterable<Countable|DateTimeInterface, mixed>', $value);
}

function test_is_int(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isInt();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<int, mixed>>', $assert);
    assertType('iterable<int, mixed>', $value);
}

function test_is_int_or_non_empty_string(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isIntOrNonEmptyString();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<int|non-empty-string, mixed>>', $assert);
    assertType('iterable<int|non-empty-string, mixed>', $value);
}

function test_is_iterable(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isIterable();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<iterable, mixed>>', $assert1);
    assertType('iterable<iterable, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isIterable();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_list(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isList();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<list<mixed>, mixed>>', $assert1);
    assertType('iterable<list<mixed>, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isList();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_lowercase_string(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isLowercaseString();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<lowercase-string, mixed>>', $assert);
    assertType('iterable<lowercase-string, mixed>', $value);
}

function test_is_map(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isMap();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<array<string, mixed>, mixed>>', $assert1);
    assertType('iterable<array<string, mixed>, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isMap();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_natural_int(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isNaturalInt();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<int<0, max>, mixed>>', $assert);
    assertType('iterable<int<0, max>, mixed>', $value);
}

function test_is_negative_int(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isNegativeInt();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<int<min, -1>, mixed>>', $assert);
    assertType('iterable<int<min, -1>, mixed>', $value);
}

function test_is_non_empty_list(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isNonEmptyList();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<non-empty-list<mixed>, mixed>>', $assert1);
    assertType('iterable<non-empty-list<mixed>, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isNonEmptyList();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_non_empty_string(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isNonEmptyString();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<non-empty-string, mixed>>', $assert);
    assertType('iterable<non-empty-string, mixed>', $value);
}

function test_is_null(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isNull();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<null, mixed>>', $assert1);
    assertType('iterable<null, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isNull();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_numeric(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isNumeric();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<float|int|numeric-string, mixed>>', $assert);
    assertType('iterable<float|int|numeric-string, mixed>', $value);
}

function test_is_numeric_string(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isNumericString();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<numeric-string, mixed>>', $assert);
    assertType('iterable<numeric-string, mixed>', $value);
}

function test_is_object(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isObject();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<object, mixed>>', $assert1);
    assertType('iterable<object, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isObject();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_one_of(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isOneOf(['light', 'dark']);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<\'dark\'|\'light\', mixed>>', $assert);
    assertType('iterable<\'dark\'|\'light\', mixed>', $value);
}

function test_is_positive_int(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isPositiveInt();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<int<1, max>, mixed>>', $assert);
    assertType('iterable<int<1, max>, mixed>', $value);
}

function test_is_resource(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isResource();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<resource, mixed>>', $assert1);
    assertType('iterable<resource, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isResource();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_same_or_subclass_of(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isSameOrSubclassOf(\stdClass::class);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<class-string<stdClass>|stdClass, mixed>>', $assert);
    assertType('iterable<class-string<stdClass>|stdClass, mixed>', $value);
}

function test_is_scalar(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isScalar();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<bool|float|int|string, mixed>>', $assert);
    assertType('iterable<bool|float|int|string, mixed>', $value);
}

function test_is_string(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isString();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<string, mixed>>', $assert);
    assertType('iterable<string, mixed>', $value);
}

function test_is_subclass_of(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isSubclassOf(\stdClass::class);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<class-string<stdClass>|stdClass, mixed>>', $assert);
    assertType('iterable<class-string<stdClass>|stdClass, mixed>', $value);
}

function test_is_true(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->isTrue();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<true, mixed>>', $assert1);
    assertType('iterable<true, mixed>', $value1);

    $assert2 = Assert::that($value2)->isArray()->keys()->isTrue();
    assertType('*NEVER*', $assert2);
    assertType('*NEVER*', $value2);
}

function test_is_uppercase_string(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isUppercaseString();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<uppercase-string, mixed>>', $assert);
    assertType('iterable<uppercase-string, mixed>', $value);
}

function test_is_url(mixed $value): void
{
    $assert = Assert::that($value)->keys()->isUrl();
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<string, mixed>>', $assert);
    assertType('iterable<string, mixed>', $value);
}

function test_matches_regular_expression(mixed $value, string $pattern): void
{
    $assert = Assert::that($value)->keys()->matchesRegularExpression($pattern);
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<string, mixed>>', $assert);
    assertType('iterable<string, mixed>', $value);
}

function test_starts_with(mixed $value1, mixed $value2): void
{
    $assert1 = Assert::that($value1)->keys()->startsWith('hello');
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<non-empty-string, mixed>>', $assert1);
    assertType('iterable<non-empty-string, mixed>', $value1);

    $assert2 = Assert::that($value2)->keys()->startsWith('');
    assertType('Nexus\\Assert\\KeysIteratingExpectation<iterable<string, mixed>>', $assert2);
    assertType('iterable<string, mixed>', $value2);
}
