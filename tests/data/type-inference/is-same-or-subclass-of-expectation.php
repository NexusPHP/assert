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

namespace Nexus\Assert\Tests\TypeInference\IsSameOrSubclassOfExpectation;

use Nexus\Assert\Assert;

use function PHPStan\Testing\assertType;

function test_is_same_or_subclass_of_with_string(mixed $a, mixed $b, mixed $c, string $className): void
{
    $assert1 = Assert::that($a)->isSameOrSubclassOf($className);
    assertType('Nexus\\Assert\\Expectation<class-string|object>', $assert1);
    assertType('class-string|object', $a);

    $assert2 = Assert::that($b)->not()->isSameOrSubclassOf($className);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed>', $assert2);
    assertType('mixed', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameOrSubclassOf($className);
    assertType('Nexus\\Assert\\NullableExpectation<class-string|object|null>', $assert3);
    assertType('class-string|object|null', $c);
}

function test_is_same_or_subclass_of_with_class_constant(mixed $a, mixed $b, mixed $c): void
{
    $assert1 = Assert::that($a)->isSameOrSubclassOf(\DateTimeInterface::class);
    assertType('Nexus\\Assert\\Expectation<class-string<DateTimeInterface>|DateTimeInterface>', $assert1);
    assertType('class-string<DateTimeInterface>|DateTimeInterface', $a);

    $assert2 = Assert::that($b)->not()->isSameOrSubclassOf(\DateTimeInterface::class);
    assertType('Nexus\\Assert\\NegatedExpectation<mixed~(class-string<DateTimeInterface>|DateTimeInterface)>', $assert2);
    assertType('mixed~(class-string<DateTimeInterface>|DateTimeInterface)', $b);

    $assert3 = Assert::that($c)->nullOr()->isSameOrSubclassOf(\DateTimeInterface::class);
    assertType('Nexus\\Assert\\NullableExpectation<class-string<DateTimeInterface>|DateTimeInterface|null>', $assert3);
    assertType('class-string<DateTimeInterface>|DateTimeInterface|null', $c);
}

/**
 * @param class-string<\stdClass> $className
 */
function test_is_same_or_subclass_of_with_generic_class_string(mixed $a, string $className): void
{
    $assert = Assert::that($a)->isSameOrSubclassOf($className);
    assertType('Nexus\\Assert\\Expectation<class-string<stdClass>|stdClass>', $assert);
    assertType('class-string<stdClass>|stdClass', $a);
}

/**
 * @param class-string<\Exception|\stdClass> $className
 */
function test_is_same_or_subclass_of_with_union_generic_class_string(mixed $a, string $className): void
{
    $assert = Assert::that($a)->isSameOrSubclassOf($className);
    assertType('Nexus\\Assert\\Expectation<class-string<Exception>|class-string<stdClass>|Exception|stdClass>', $assert);
    assertType('class-string<Exception>|class-string<stdClass>|Exception|stdClass', $a);
}

function test_is_same_or_subclass_of_with_object(mixed $a, \DateTimeInterface $class): void
{
    $assert = Assert::that($a)->isSameOrSubclassOf($class);
    assertType('Nexus\\Assert\\Expectation<class-string<DateTimeInterface>|DateTimeInterface>', $assert);
    assertType('class-string<DateTimeInterface>|DateTimeInterface', $a);
}
