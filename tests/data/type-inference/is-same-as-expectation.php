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

namespace Nexus\Assert\Tests\TypeInference\IsSameAsExpectation;

use Nexus\Assert\Assert;

use function PHPStan\Testing\assertType;

function test_is_same_as_array(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(\is_array($other));

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<array<mixed, mixed>>', $assert1);
    assertType('array<mixed, mixed>', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<array<mixed, mixed>|null>', $assert3);
    assertType('array<mixed, mixed>|null', $c);
}

function test_is_same_as_bool(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(\is_bool($other));

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<bool>', $assert1);
    assertType('bool', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<bool|null>', $assert3);
    assertType('bool|null', $c);
}

function test_is_same_as_callable(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(\is_callable($other));

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<callable(): mixed>', $assert1);
    assertType('callable(): mixed', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<(callable(): mixed)|null>', $assert3);
    assertType('(callable(): mixed)|null', $c);
}

function test_is_same_as_float(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(\is_float($other));

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<float>', $assert1);
    assertType('float', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<float|null>', $assert3);
    assertType('float|null', $c);
}

function test_is_same_as_int(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(\is_int($other));

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<int>', $assert1);
    assertType('int', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<int|null>', $assert3);
    assertType('int|null', $c);
}

function test_is_same_as_iterable(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(is_iterable($other));

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<iterable>', $assert1);
    assertType('iterable', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<iterable|null>', $assert3);
    assertType('iterable|null', $c);
}

function test_is_same_as_null(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(null === $other);

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<null>', $assert1);
    assertType('null', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~null>', $assert2);
    assertType('mixed~null', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<null>', $assert3);
    assertType('null', $c);
}

function test_is_same_as_numeric(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(is_numeric($other));

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<float|int|numeric-string>', $assert1);
    assertType('float|int|numeric-string', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<float|int|numeric-string|null>', $assert3);
    assertType('float|int|numeric-string|null', $c);
}

function test_is_same_as_object(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(\is_object($other));

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<object>', $assert1);
    assertType('object', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<object|null>', $assert3);
    assertType('object|null', $c);
}

function test_is_same_as_scalar(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(\is_scalar($other));

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<bool|float|int|string>', $assert1);
    assertType('bool|float|int|string', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<bool|float|int|string|null>', $assert3);
    assertType('bool|float|int|string|null', $c);
}

function test_is_same_as_string(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(\is_string($other));

    $assert1 = Assert::that($a)->isSameAs($other);
    assertType('Nexus\\Assert\\Expectation<string>', $assert1);
    assertType('string', $a);

    $assert2 = Assert::that($b)->not()->isSameAs($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameAs($other);
    assertType('Nexus\\Assert\\NullableExpectation<string|null>', $assert3);
    assertType('string|null', $c);
}
