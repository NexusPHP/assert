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
use Nexus\Assert\ExpectationFailedException;
use Nexus\Assert\NullableExpectation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(NullableExpectation::class)]
#[Group('unit')]
final class NullableExpectationTest extends TestCase
{
    public function testIsArray(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isArray());

        $nullableExpectation = Assert::that([])->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isArray());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or pass the expectation for method "isArray".');
        Assert::that(42)->nullOr()->isArray();
    }

    public function testIsBool(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isBool());

        $nullableExpectation = Assert::that(true)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isBool());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or pass the expectation for method "isBool".');
        Assert::that(42)->nullOr()->isBool();
    }

    public function testIsCallable(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isCallable());

        $nullableExpectation = Assert::that(static function (): void {})->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isCallable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or pass the expectation for method "isCallable".');
        Assert::that(42)->nullOr()->isCallable();
    }

    public function testIsFalse(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isFalse());

        $nullableExpectation = Assert::that(false)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isFalse());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is expected to be null or pass the expectation for method "isFalse".');
        Assert::that(true)->nullOr()->isFalse();
    }

    public function testIsFloat(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isFloat());

        $nullableExpectation = Assert::that(3.14)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isFloat());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or pass the expectation for method "isFloat".');
        Assert::that(42)->nullOr()->isFloat();
    }

    public function testIsInstanceOf(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isInstanceOf(\stdClass::class));

        $nullableExpectation = Assert::that(new \stdClass())->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isInstanceOf(\stdClass::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is expected to be null or pass the expectation for method "isInstanceOf".');
        Assert::that(new \stdClass())->nullOr()->isInstanceOf(\Generator::class);
    }

    public function testIsInt(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isInt());

        $nullableExpectation = Assert::that(42)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is expected to be null or pass the expectation for method "isInt".');
        Assert::that(3.14)->nullOr()->isInt();
    }

    public function testIsIterable(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isIterable());

        $nullableExpectation = Assert::that([1])->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isIterable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or pass the expectation for method "isIterable".');
        Assert::that(42)->nullOr()->isIterable();
    }

    public function testIsNull(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isNull());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null but got int instead.');
        Assert::that(42)->nullOr()->isNull();
    }

    public function testIsNumeric(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isNumeric());

        $nullableExpectation = Assert::that(42)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isNumeric());

        $nullableExpectation = Assert::that(3.14)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isNumeric());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is expected to be null or pass the expectation for method "isNumeric".');
        Assert::that(true)->nullOr()->isNumeric();
    }

    public function testIsObject(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isObject());

        $nullableExpectation = Assert::that(new \stdClass())->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or pass the expectation for method "isObject".');
        Assert::that(42)->nullOr()->isObject();
    }

    public function testIsResource(): void
    {
        $resource = fopen('php://temp', 'rb');
        self::assertNotFalse($resource);

        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isResource());

        $nullableExpectation = Assert::that($resource)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isResource());

        fclose($resource);

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or pass the expectation for method "isResource".');
        Assert::that(42)->nullOr()->isResource();
    }

    public function testIsScalar(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isScalar());

        $nullableExpectation = Assert::that(42)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isScalar());

        $nullableExpectation = Assert::that(3.14)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isScalar());

        $nullableExpectation = Assert::that('hello')->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isScalar());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is expected to be null or pass the expectation for method "isScalar".');
        Assert::that([])->nullOr()->isScalar();
    }

    public function testIsString(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isString());

        $nullableExpectation = Assert::that('hello')->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or pass the expectation for method "isString".');
        Assert::that(42)->nullOr()->isString();
    }

    public function testIsTrue(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isTrue());

        $nullableExpectation = Assert::that(true)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "false" is expected to be null or pass the expectation for method "isTrue".');
        Assert::that(false)->nullOr()->isTrue();
    }
}
