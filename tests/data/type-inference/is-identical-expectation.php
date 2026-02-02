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

namespace Nexus\Assert\Tests\TypeInference\IsIdenticalExpectation;

use Nexus\Assert\Assert;

use function PHPStan\Testing\assertType;

/**
 * @param array<string, mixed> $other
 */
function test_is_identical_array(mixed $a, mixed $b, mixed $c, array $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<array<string, mixed>>', $assert1);
    assertType('array<string, mixed>', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<array<string, mixed>|null>', $assert3);
    assertType('array<string, mixed>|null', $c);
}

function test_is_identical_bool(mixed $a, mixed $b, mixed $c, bool $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<bool>', $assert1);
    assertType('bool', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<bool|null>', $assert3);
    assertType('bool|null', $c);
}

/**
 * @param callable(): mixed $other
 */
function test_is_identical_callable(mixed $a, mixed $b, mixed $c, callable $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<callable(): mixed>', $assert1);
    assertType('callable(): mixed', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<(callable(): mixed)|null>', $assert3);
    assertType('(callable(): mixed)|null', $c);
}

function test_is_identical_false(mixed $a, mixed $b, mixed $c, false $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<false>', $assert1);
    assertType('false', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~false>', $assert2);
    assertType('mixed~false', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<false|null>', $assert3);
    assertType('false|null', $c);
}

function test_is_identical_float(mixed $a, mixed $b, mixed $c, float $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<float>', $assert1);
    assertType('float', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<float|null>', $assert3);
    assertType('float|null', $c);
}

function test_is_identical_int(mixed $a, mixed $b, mixed $c, int $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<int>', $assert1);
    assertType('int', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<int|null>', $assert3);
    assertType('int|null', $c);
}

/**
 * @param iterable<mixed> $other
 */
function test_is_identical_iterable(mixed $a, mixed $b, mixed $c, iterable $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<iterable>', $assert1);
    assertType('iterable', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<iterable|null>', $assert3);
    assertType('iterable|null', $c);
}

function test_is_identical_null(mixed $a, mixed $b, mixed $c, null $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<null>', $assert1);
    assertType('null', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~null>', $assert2);
    assertType('mixed~null', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<null>', $assert3);
    assertType('null', $c);
}

function test_is_identical_numeric(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(is_numeric($other));

    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<float|int|numeric-string>', $assert1);
    assertType('float|int|numeric-string', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<float|int|numeric-string|null>', $assert3);
    assertType('float|int|numeric-string|null', $c);
}

function test_is_identical_object(mixed $a, mixed $b, mixed $c, object $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<object>', $assert1);
    assertType('object', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<object|null>', $assert3);
    assertType('object|null', $c);
}

function test_is_identical_scalar(mixed $a, mixed $b, mixed $c, mixed $other): void
{
    \assert(\is_scalar($other));

    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<bool|float|int|string>', $assert1);
    assertType('bool|float|int|string', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<bool|float|int|string|null>', $assert3);
    assertType('bool|float|int|string|null', $c);
}

function test_is_identical_string(mixed $a, mixed $b, mixed $c, string $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<string>', $assert1);
    assertType('string', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<string|null>', $assert3);
    assertType('string|null', $c);
}

function test_is_identical_true(mixed $a, mixed $b, mixed $c, true $other): void
{
    $assert1 = Assert::that($a)->isIdentical($other);
    assertType('Nexus\\Assert\\Expectation<true>', $assert1);
    assertType('true', $a);

    $assert2 = Assert::that($b)->not()->isIdentical($other);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~true>', $assert2);
    assertType('mixed~true', $b);

    $assert3 = Assert::that($c)->nullOr()->isIdentical($other);
    assertType('Nexus\\Assert\\NullableExpectation<true|null>', $assert3);
    assertType('true|null', $c);
}
