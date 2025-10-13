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

use Nexus\Assert\Assert;
use Nexus\Assert\Expectation;
use Nexus\Assert\ExpectationFailedException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Assert::class)]
#[CoversClass(Expectation::class)]
#[Group('unit')]
final class ExpectationTest extends TestCase
{
    public function testIsArray(): void
    {
        $expectation = Assert::that([]);
        self::assertSame($expectation, $expectation->isArray());

        $expectation = Assert::that([1, 2, 3]);
        self::assertSame($expectation, $expectation->isArray());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be an array but got int instead.');
        Assert::that(42)->isArray(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsBool(): void
    {
        $expectation = Assert::that(true);
        self::assertSame($expectation, $expectation->isBool());

        $expectation = Assert::that(false);
        self::assertSame($expectation, $expectation->isBool());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "1" is expected to be a bool but got int instead.');
        Assert::that(1)->isBool(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsFalse(): void
    {
        $expectation = Assert::that(false);
        self::assertSame($expectation, $expectation->isFalse());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'\'" is expected to be false but got string instead.');
        Assert::that('')->isFalse(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsFloat(): void
    {
        $expectation = Assert::that(3.14);
        self::assertSame($expectation, $expectation->isFloat());

        $expectation = Assert::that(0.0);
        self::assertSame($expectation, $expectation->isFloat());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello\'" is expected to be a float but got string instead.');
        Assert::that('hello')->isFloat(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsInt(): void
    {
        $expectation = Assert::that(1);
        self::assertSame($expectation, $expectation->isInt());

        $expectation = Assert::that(0);
        self::assertSame($expectation, $expectation->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is expected to be an int but got bool instead.');
        Assert::that(true)->isInt(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsIterable(): void
    {
        $expectation = Assert::that([]);
        self::assertSame($expectation, $expectation->isIterable());

        $expectation = Assert::that(new \ArrayIterator([1, 2, 3]));
        self::assertSame($expectation, $expectation->isIterable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be iterable but got int instead.');
        Assert::that(42)->isIterable(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsNull(): void
    {
        $expectation = Assert::that(null);
        self::assertSame($expectation, $expectation->isNull());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "0" is expected to be null but got int instead.');
        Assert::that(0)->isNull(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsNumeric(): void
    {
        $expectation = Assert::that(42);
        self::assertSame($expectation, $expectation->isNumeric());

        $expectation = Assert::that(3.14);
        self::assertSame($expectation, $expectation->isNumeric());

        $expectation = Assert::that('42');
        self::assertSame($expectation, $expectation->isNumeric());

        $expectation = Assert::that('3.14');
        self::assertSame($expectation, $expectation->isNumeric());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is expected to be numeric but got bool instead.');
        Assert::that(true)->isNumeric(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsObject(): void
    {
        $expectation = Assert::that(new \stdClass());
        self::assertSame($expectation, $expectation->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be an object but got int instead.');
        Assert::that(42)->isObject(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsScalar(): void
    {
        $expectation = Assert::that(42);
        self::assertSame($expectation, $expectation->isScalar());

        $expectation = Assert::that(3.14);
        self::assertSame($expectation, $expectation->isScalar());

        $expectation = Assert::that('hello');
        self::assertSame($expectation, $expectation->isScalar());

        $expectation = Assert::that(true);
        self::assertSame($expectation, $expectation->isScalar());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is expected to be a scalar but got array instead.');
        Assert::that([])->isScalar(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsTrue(): void
    {
        $expectation = Assert::that(true);
        self::assertSame($expectation, $expectation->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "12" is expected to be true but got int instead.');
        Assert::that(12)->isTrue(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testIsString(): void
    {
        $expectation = Assert::that('hello');
        self::assertSame($expectation, $expectation->isString());

        $expectation = Assert::that('');
        self::assertSame($expectation, $expectation->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is expected to be a string but got float instead.');
        Assert::that(3.14)->isString(); // @phpstan-ignore method.unresolvableReturnType
    }

    public function testExpectationMethodsAreArrangedInOrder(): void
    {
        $reflection = new \ReflectionClass(Expectation::class);
        $publicMethods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        $sortedMethods = $publicMethods;

        usort($sortedMethods, static function (\ReflectionMethod $a, \ReflectionMethod $b): int {
            if ($a->isConstructor()) {
                return -1;
            }

            if ($b->isConstructor()) {
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
}
