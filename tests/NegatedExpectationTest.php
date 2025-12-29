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
use Nexus\Assert\NegatedExpectation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(NegatedExpectation::class)]
#[Group('unit')]
final class NegatedExpectationTest extends TestCase
{
    public function testIsArray(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isArray());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is not expected to pass the negated expectation for method "isArray".');
        Assert::that([])->not()->isArray();
    }

    public function testIsBool(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isBool());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is not expected to pass the negated expectation for method "isBool".');
        Assert::that(true)->not()->isBool();
    }

    public function testIsCallable(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isCallable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(Closure)" is not expected to pass the negated expectation for method "isCallable".');
        Assert::that(static function (): void {})->not()->isCallable();
    }

    public function testIsCountable(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isCountable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is not expected to pass the negated expectation for method "isCountable".');
        Assert::that([])->not()->isCountable();
    }

    public function testIsFalse(): void
    {
        $negatedExpectation = Assert::that(true)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isFalse());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "false" is not expected to pass the negated expectation for method "isFalse".');
        Assert::that(false)->not()->isFalse();
    }

    public function testIsFloat(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isFloat());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is not expected to pass the negated expectation for method "isFloat".');
        Assert::that(3.14)->not()->isFloat();
    }

    public function testIsInstanceOf(): void
    {
        $negatedExpectation = Assert::that(new \stdClass())->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isInstanceOf(\Generator::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is not expected to pass the negated expectation for method "isInstanceOf".');
        Assert::that(new \stdClass())->not()->isInstanceOf(\stdClass::class);
    }

    public function testIsInt(): void
    {
        $negatedExpectation = Assert::that(3.14)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to pass the negated expectation for method "isInt".');
        Assert::that(42)->not()->isInt();
    }

    public function testIsIterable(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isIterable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[1]" is not expected to pass the negated expectation for method "isIterable".');
        Assert::that([1])->not()->isIterable();
    }

    public function testIsNull(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isNull());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "null" is not expected to pass the negated expectation for method "isNull".');
        Assert::that(null)->not()->isNull();
    }

    public function testIsNumeric(): void
    {
        $negatedExpectation = Assert::that('foo')->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isNumeric());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to pass the negated expectation for method "isNumeric".');
        Assert::that(42)->not()->isNumeric();
    }

    public function testIsObject(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is not expected to pass the negated expectation for method "isObject".');
        Assert::that(new \stdClass())->not()->isObject();
    }

    public function testIsResource(): void
    {
        $resource = fopen('php://temp', 'rb');
        self::assertNotFalse($resource);

        try {
            $negatedExpectation = Assert::that(42)->not();
            self::assertSame($negatedExpectation, $negatedExpectation->isResource());

            $this->expectException(ExpectationFailedException::class);
            $this->expectExceptionMessage('Value "resource (stream)" is not expected to pass the negated expectation for method "isResource".');
            Assert::that($resource)->not()->isResource();
        } finally {
            fclose($resource);
        }
    }

    public function testIsScalar(): void
    {
        $negatedExpectation = Assert::that([])->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isScalar());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to pass the negated expectation for method "isScalar".');
        Assert::that(42)->not()->isScalar();
    }

    public function testIsString(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello\'" is not expected to pass the negated expectation for method "isString".');
        Assert::that('hello')->not()->isString();
    }

    public function testIsTrue(): void
    {
        $negatedExpectation = Assert::that(false)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is not expected to pass the negated expectation for method "isTrue".');
        Assert::that(true)->not()->isTrue();
    }
}
