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
use PHPUnit\Framework\Attributes\DataProvider;
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
    public function testExpectationVariantReturns(): void
    {
        $expectation = Assert::that(42);
        self::assertSame($expectation, $expectation->isInt());

        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isString());

        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isArray());
    }

    public function testIsArray(): void
    {
        $expectation = Assert::that([]);
        self::assertSame($expectation, $expectation->isArray());

        $expectation = Assert::that([1, 2, 3]);
        self::assertSame($expectation, $expectation->isArray());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be an array but got int instead.');
        Assert::that(42)->isArray();
    }

    public function testIsBool(): void
    {
        $expectation = Assert::that(true);
        self::assertSame($expectation, $expectation->isBool());

        $expectation = Assert::that(false);
        self::assertSame($expectation, $expectation->isBool());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "1" is expected to be a bool but got int instead.');
        Assert::that(1)->isBool();
    }

    public function testIsCallable(): void
    {
        $expectation = Assert::that(static fn(): bool => true);
        self::assertSame($expectation, $expectation->isCallable());

        $expectation = Assert::that('trim');
        self::assertSame($expectation, $expectation->isCallable());

        $expectation = Assert::that([new \Exception('Hi'), '__toString']);
        self::assertSame($expectation, $expectation->isCallable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be callable but got int instead.');
        Assert::that(42)->isCallable();
    }

    public function testIsCountable(): void
    {
        $expectation = Assert::that([]);
        self::assertSame($expectation, $expectation->isCountable());

        $expectation = Assert::that(new \ArrayObject([1, 2, 3]));
        self::assertSame($expectation, $expectation->isCountable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be countable but got int instead.');
        Assert::that(42)->isCountable();
    }

    public function testIsFalse(): void
    {
        $expectation = Assert::that(false);
        self::assertSame($expectation, $expectation->isFalse());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'\'" is expected to be false but got string instead.');
        Assert::that('')->isFalse();
    }

    public function testIsFloat(): void
    {
        $expectation = Assert::that(3.14);
        self::assertSame($expectation, $expectation->isFloat());

        $expectation = Assert::that(0.0);
        self::assertSame($expectation, $expectation->isFloat());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello\'" is expected to be a float but got string instead.');
        Assert::that('hello')->isFloat();
    }

    public function testIsInstanceOf(): void
    {
        $expectation = Assert::that(new \DateTimeImmutable());
        self::assertSame($expectation, $expectation->isInstanceOf(\DateTimeInterface::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is expected to be an instance of DateTimeInterface but got stdClass instead.');
        Assert::that(new \stdClass())->isInstanceOf(\DateTimeInterface::class);
    }

    public function testIsInt(): void
    {
        $expectation = Assert::that(1);
        self::assertSame($expectation, $expectation->isInt());

        $expectation = Assert::that(0);
        self::assertSame($expectation, $expectation->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is expected to be an int but got bool instead.');
        Assert::that(true)->isInt();
    }

    public function testIsIterable(): void
    {
        $expectation = Assert::that([]);
        self::assertSame($expectation, $expectation->isIterable());

        $expectation = Assert::that(new \ArrayIterator([1, 2, 3]));
        self::assertSame($expectation, $expectation->isIterable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be iterable but got int instead.');
        Assert::that(42)->isIterable();
    }

    public function testIsNull(): void
    {
        $expectation = Assert::that(null);
        self::assertSame($expectation, $expectation->isNull());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "0" is expected to be null but got int instead.');
        Assert::that(0)->isNull();
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
        Assert::that(true)->isNumeric();
    }

    public function testIsObject(): void
    {
        $expectation = Assert::that(new \stdClass());
        self::assertSame($expectation, $expectation->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be an object but got int instead.');
        Assert::that(42)->isObject();
    }

    public function testIsResource(): void
    {
        $resource = fopen('php://temp', 'rb');
        self::assertNotFalse($resource);

        $expectation = Assert::that($resource);
        self::assertSame($expectation, $expectation->isResource());
        fclose($resource);

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be a resource but got int instead.');
        Assert::that(42)->isResource();
    }

    #[DataProvider('provideIsSameAsCases')]
    public function testIsSameAs(mixed $value, mixed $other): void
    {
        $expectation = Assert::that($value);
        self::assertSame($expectation, $expectation->isSameAs($other));

        $this->expectException(ExpectationFailedException::class);
        Assert::that($value)->isSameAs('different');
    }

    public static function provideIsSameAsCases(): iterable
    {
        $object = new \stdClass();

        yield 'int' => [42, 42];

        yield 'float' => [3.14, 3.14];

        yield 'string' => ['hello', 'hello'];

        yield 'null' => [null, null];

        yield 'array' => [[1, 2, 3], [1, 2, 3]];

        yield 'object' => [$object, $object];
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
        Assert::that([])->isScalar();
    }

    public function testIsString(): void
    {
        $expectation = Assert::that('hello');
        self::assertSame($expectation, $expectation->isString());

        $expectation = Assert::that('');
        self::assertSame($expectation, $expectation->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is expected to be a string but got float instead.');
        Assert::that(3.14)->isString();
    }

    public function testIsTrue(): void
    {
        $expectation = Assert::that(true);
        self::assertSame($expectation, $expectation->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "12" is expected to be true but got int instead.');
        Assert::that(12)->isTrue();
    }
}
