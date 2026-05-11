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
use Nexus\Assert\KeysIteratingExpectation;
use Nexus\Assert\NegatedExpectation;
use Nexus\Assert\NullableExpectation;
use Nexus\Assert\ValuesIteratingExpectation;
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

        $mutatingOrder = ['not' => 0, 'nullOr' => 1, 'keys' => 2, 'values' => 3];

        usort($sortedMethods, static function (\ReflectionMethod $a, \ReflectionMethod $b) use ($mutatingOrder): int {
            if ($a->isConstructor()) {
                return -1;
            }

            if ($b->isConstructor()) {
                return 1;
            }

            $aRank = $mutatingOrder[$a->getName()] ?? null;
            $bRank = $mutatingOrder[$b->getName()] ?? null;

            if (null !== $aRank && null !== $bRank) {
                return $aRank <=> $bRank;
            }

            if (null !== $aRank) {
                return -1;
            }

            if (null !== $bRank) {
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

        yield [KeysIteratingExpectation::class];

        yield [NegatedExpectation::class];

        yield [NullableExpectation::class];

        yield [ValuesIteratingExpectation::class];
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

        $expectationReflection = new \ReflectionClass(Expectation::class);

        usort(
            $sortedMethods,
            static function (\ReflectionMethod $a, \ReflectionMethod $b) use ($expectationReflection): int {
                $methodA = lcfirst(substr($a->getName(), 4));
                $methodB = lcfirst(substr($b->getName(), 4));

                if ($expectationReflection->hasMethod($methodA) && ! $expectationReflection->hasMethod($methodB)) {
                    return 1;
                }

                if (! $expectationReflection->hasMethod($methodA) && $expectationReflection->hasMethod($methodB)) {
                    return -1;
                }

                return strcmp($a->getName(), $b->getName());
            },
        );

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

        yield [KeysIteratingExpectationTest::class];

        yield [NegatedExpectationTest::class];

        yield [NullableExpectationTest::class];

        yield [ValuesIteratingExpectationTest::class];
    }

    /**
     * @param class-string<Expectable<mixed>> $variant
     * @param null|non-empty-string           $chainPrefix
     */
    #[DataProvider('provideTypeInferenceFixturesCoverEveryMethodCases')]
    public function testTypeInferenceFixturesCoverEveryMethod(string $variant, ?string $chainPrefix): void
    {
        $methods = array_map(
            static fn(\ReflectionMethod $method): string => $method->getName(),
            (new \ReflectionClass(Expectable::class))->getMethods(\ReflectionMethod::IS_PUBLIC),
        );

        $fixtures = glob(__DIR__.'/data/type-inference/*.php');
        \assert(\is_array($fixtures) && [] !== $fixtures);

        $haystack = '';

        foreach ($fixtures as $file) {
            $haystack .= file_get_contents($file);
        }

        $missing = [];

        foreach ($methods as $method) {
            if (null === $chainPrefix) {
                $matched = preg_match(
                    \sprintf('/Assert::that(\((?:[^()]++|(?1))*\))->%s\(/', preg_quote($method, '/')),
                    $haystack,
                ) === 1;
            } else {
                $matched = str_contains($haystack, $chainPrefix.$method.'(');
            }

            if (! $matched) {
                $missing[] = $method;
            }
        }

        self::assertSame([], $missing, \sprintf(
            'Variant %s is missing type-inference fixtures for: %s. Add a test_<method> entry calling %sMETHOD() in tests/data/type-inference/.',
            $variant,
            implode(', ', $missing),
            $chainPrefix ?? 'Assert::that($x)->',
        ));
    }

    public static function provideTypeInferenceFixturesCoverEveryMethodCases(): iterable
    {
        yield [Expectation::class, null];

        yield [KeysIteratingExpectation::class, '->keys()->'];

        yield [NegatedExpectation::class, '->not()->'];

        yield [NullableExpectation::class, '->nullOr()->'];

        yield [ValuesIteratingExpectation::class, '->values()->'];
    }
}
