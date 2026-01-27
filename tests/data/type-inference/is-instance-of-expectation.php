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

namespace Nexus\Assert\Tests\TypeInference\IsInstanceOfExpectation;

use Nexus\Assert\Assert;
use Nexus\Assert\Expectation;

use function PHPStan\Testing\assertType;

function test_is_instance_of_with_string(mixed $a, mixed $b, mixed $c, string $className): void
{
    $assert1 = Assert::that($a)->isInstanceOf($className);
    assertType('Nexus\\Assert\\Expectation<object>', $assert1);
    assertType('object', $a);

    $assert2 = Assert::that($b)->not()->isInstanceOf($className);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isInstanceOf($className);
    assertType('Nexus\\Assert\\NullableExpectation<object|null>', $assert3);
    assertType('object|null', $c);
}

/**
 * @param class-string $className
 */
function test_is_instance_of_with_class_string(mixed $a, mixed $b, mixed $c, string $className): void
{
    $assert1 = Assert::that($a)->isInstanceOf($className);
    assertType('Nexus\\Assert\\Expectation<object>', $assert1);
    assertType('object', $a);

    $assert2 = Assert::that($b)->not()->isInstanceOf($className);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isInstanceOf($className);
    assertType('Nexus\\Assert\\NullableExpectation<object|null>', $assert3);
    assertType('object|null', $c);
}

function test_is_instance_of_with_class_constant(mixed $a, mixed $b, mixed $c): void
{
    $assert1 = Assert::that($a)->isInstanceOf(\DateTimeInterface::class);
    assertType('Nexus\\Assert\\Expectation<DateTimeInterface>', $assert1);
    assertType(\DateTimeInterface::class, $a);

    $assert2 = Assert::that($b)->not()->isInstanceOf(\DateTimeInterface::class);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~DateTimeInterface>', $assert2);
    assertType('mixed~DateTimeInterface', $b);

    $assert3 = Assert::that($c)->nullOr()->isInstanceOf(\DateTimeInterface::class);
    assertType('Nexus\\Assert\\NullableExpectation<DateTimeInterface|null>', $assert3);
    assertType('DateTimeInterface|null', $c);
}

/**
 * @param class-string<\stdClass> $className
 */
function test_is_instance_of_with_generic_class_string(mixed $a, mixed $b, mixed $c, string $className): void
{
    $assert1 = Assert::that($a)->isInstanceOf($className);
    assertType('Nexus\\Assert\\Expectation<stdClass>', $assert1);
    assertType(\stdClass::class, $a);

    $assert2 = Assert::that($b)->not()->isInstanceOf($className);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~stdClass>', $assert2);
    assertType('mixed~stdClass', $b);

    $assert3 = Assert::that($c)->nullOr()->isInstanceOf($className);
    assertType('Nexus\\Assert\\NullableExpectation<stdClass|null>', $assert3);
    assertType('stdClass|null', $c);
}

/**
 * @param class-string<Expectation<\ArrayObject<mixed, mixed>>> $className
 */
function test_is_instance_of_with_generic_class_in_generic_class_string(mixed $a, mixed $b, mixed $c, string $className): void
{
    $assert1 = Assert::that($a)->isInstanceOf($className);
    assertType('Nexus\\Assert\\Expectation<Nexus\\Assert\\Expectation>', $assert1);
    assertType(Expectation::class, $a);

    $assert2 = Assert::that($b)->not()->isInstanceOf($className);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~Nexus\\Assert\\Expectation>', $assert2);
    assertType('mixed~Nexus\\Assert\\Expectation', $b);

    $assert3 = Assert::that($c)->nullOr()->isInstanceOf($className);
    assertType('Nexus\\Assert\\NullableExpectation<Nexus\\Assert\\Expectation|null>', $assert3);
    assertType('Nexus\\Assert\\Expectation|null', $c);
}

/**
 * @param class-string<\Exception|\stdClass> $className
 */
function test_is_instance_of_with_union_generic_class_string(mixed $a, mixed $b, mixed $c, string $className): void
{
    $assert1 = Assert::that($a)->isInstanceOf($className);
    assertType('Nexus\\Assert\\Expectation<Exception|stdClass>', $assert1);
    assertType('Exception|stdClass', $a);

    $assert2 = Assert::that($b)->not()->isInstanceOf($className);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(Exception|stdClass)>', $assert2);
    assertType('mixed~(Exception|stdClass)', $b);

    $assert3 = Assert::that($c)->nullOr()->isInstanceOf($className);
    assertType('Nexus\\Assert\\NullableExpectation<Exception|stdClass|null>', $assert3);
    assertType('Exception|stdClass|null', $c);
}
