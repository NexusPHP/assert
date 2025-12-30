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

use Nexus\Assert\Expectable;
use Nexus\Assert\Expectation;
use Nexus\Assert\NegatedExpectation;
use Nexus\Assert\NullableExpectation;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
#[Group('auto-review')]
final class ExpectableAutoReviewTest extends TestCase
{
    /**
     * @param class-string<Expectable<mixed>> $expectable
     */
    #[DataProvider('provideExpectationMethodsAreArrangedInOrderCases')]
    public function testExpectationMethodsAreArrangedInOrder(string $expectable): void
    {
        $reflection = new \ReflectionClass($expectable);
        $publicMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        $sortedMethods = $publicMethods;

        usort($sortedMethods, static function (\ReflectionMethod $a, \ReflectionMethod $b): int {
            if ($a->isConstructor()) {
                return -1;
            }

            if ($b->isConstructor()) {
                return 1;
            }

            if (\in_array($a->getName(), ['not', 'nullOr'], true)) {
                return -1;
            }

            if (\in_array($b->getName(), ['not', 'nullOr'], true)) {
                return 1;
            }

            return strcmp($a->getName(), $b->getName());
        });

        $publicMethods = array_map(
            static fn(\ReflectionMethod $method): string => $method->getName(),
            $publicMethods,
        );
        $sortedMethods = array_map(
            static fn(\ReflectionMethod $method): string => $method->getName(),
            $sortedMethods,
        );

        self::assertSame($sortedMethods, $publicMethods);
    }

    public static function provideExpectationMethodsAreArrangedInOrderCases(): iterable
    {
        yield [Expectable::class];

        yield [Expectation::class];

        yield [NegatedExpectation::class];

        yield [NullableExpectation::class];
    }

    /**
     * @param class-string<TestCase> $expectationTest
     */
    #[DataProvider('provideExpectationTestMethodsAreArrangedInOrderCases')]
    public function testExpectationTestMethodsAreArrangedInOrder(string $expectationTest): void
    {
        $reflection = new \ReflectionClass($expectationTest);
        $publicMethods = array_values(array_filter(
            $reflection->getMethods(\ReflectionMethod::IS_PUBLIC),
            static fn(\ReflectionMethod $method): bool => str_starts_with($method->getName(), 'test'),
        ));
        $sortedMethods = $publicMethods;

        usort($sortedMethods, static fn(\ReflectionMethod $a, \ReflectionMethod $b): int => strcmp($a->getName(), $b->getName()));

        $publicMethods = array_map(
            static fn(\ReflectionMethod $method): string => $method->getName(),
            $publicMethods,
        );
        $sortedMethods = array_map(
            static fn(\ReflectionMethod $method): string => $method->getName(),
            $sortedMethods,
        );

        self::assertSame($sortedMethods, $publicMethods);
    }

    public static function provideExpectationTestMethodsAreArrangedInOrderCases(): iterable
    {
        yield [ExpectationTest::class];

        yield [NegatedExpectationTest::class];

        yield [NullableExpectationTest::class];
    }
}
