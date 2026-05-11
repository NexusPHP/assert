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
use Nexus\Assert\ValuesIteratingExpectation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;

/**
 * @internal
 */
#[CoversClass(ValuesIteratingExpectation::class)]
#[Group('unit')]
final class ValuesIteratingExpectationTest extends AbstractExpectationTestCase
{
    public function testConstructor(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be iterable but got int instead.');
        new ValuesIteratingExpectation(Assert::that(42));
    }

    public function testContains(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['hello world', 'hello there'])->values()->contains('hello'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello\'" in iterable is expected to contain "\'world\'".');
        Assert::that(['hello'])->values()->contains('world');
    }

    public function testEndsWith(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['index.php', 'home.php'])->values()->endsWith('.php'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'index.html\'" in iterable is expected to end with "\'.php\'".');
        Assert::that(['index.html'])->values()->endsWith('.php');
    }

    public function testHasMethod(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([new \Exception('a'), new \Exception('b')])->values()->hasMethod('__toString'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object value of class "stdClass" in iterable is expected to have method "__toString".');
        Assert::that([new \stdClass()])->values()->hasMethod('__toString');
    }

    public function testHasOffset(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([['a' => 1], ['a' => 2]])->values()->hasOffset('a'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Array value "[\'a\' => 1]" in iterable is expected to have offset "b".');
        Assert::that([['a' => 1]])->values()->hasOffset('b');
    }

    public function testHasProperty(): void
    {
        $obj = new \stdClass();
        $obj->existing = 'value';

        self::assertNoErrorsThrown(static fn() => Assert::that([$obj, $obj])->values()->hasProperty('existing'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object value of class "stdClass" in iterable is expected to have property "missing".');
        Assert::that([new \stdClass()])->values()->hasProperty('missing');
    }

    public function testIsArray(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([[], [1, 2]])->values()->isArray());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" in iterable is expected to be an array but got int instead.');
        Assert::that([42])->values()->isArray();
    }

    public function testIsArrayKey(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([1, 'a'])->values()->isArrayKey());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" in iterable is expected to be an array key but got float instead.');
        Assert::that([3.14])->values()->isArrayKey();
    }

    public function testIsBool(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([true, false])->values()->isBool());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" in iterable is expected to be a bool but got int instead.');
        Assert::that([42])->values()->isBool();
    }

    public function testIsCallable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['strlen', 'is_string'])->values()->isCallable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" in iterable is expected to be callable but got int instead.');
        Assert::that([42])->values()->isCallable();
    }

    public function testIsCountable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([[], [1, 2]])->values()->isCountable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" in iterable is expected to be countable but got int instead.');
        Assert::that([42])->values()->isCountable();
    }

    public function testIsFalse(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([false, false])->values()->isFalse());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" in iterable is expected to be false but got bool instead.');
        Assert::that([true])->values()->isFalse();
    }

    public function testIsFloat(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([3.14, 2.71])->values()->isFloat());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" in iterable is expected to be a float but got int instead.');
        Assert::that([42])->values()->isFloat();
    }

    public function testIsIdentical(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['x', 'x'])->values()->isIdentical('x'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'y\'" in iterable is expected to be identical to "\'x\'".');
        Assert::that(['x', 'y'])->values()->isIdentical('x');
    }

    public function testIsInstanceOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([new \Exception('a'), new \Exception('b')])->values()->isInstanceOf(\Exception::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" in iterable is expected to be an instance of \'Exception\' but got stdClass instead.');
        Assert::that([new \stdClass()])->values()->isInstanceOf(\Exception::class);
    }

    public function testIsInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([1, 2, 3])->values()->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'a\'" in iterable is expected to be an int but got string instead.');
        Assert::that(['a'])->values()->isInt();
    }

    public function testIsIterable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([[], [1]])->values()->isIterable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" in iterable is expected to be iterable but got int instead.');
        Assert::that([42])->values()->isIterable();
    }

    public function testIsList(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([[1, 2, 3], [4, 5, 6]])->values()->isList());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[\'a\' => 1]" in iterable is expected to be a list but got array instead.');
        Assert::that([['a' => 1]])->values()->isList();
    }

    public function testIsLowercaseString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['hello', 'world'])->values()->isLowercaseString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'Hello\'" in iterable is expected to be a lowercase string but got string instead.');
        Assert::that(['Hello'])->values()->isLowercaseString();
    }

    public function testIsMap(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([['a' => 1], ['b' => 2]])->values()->isMap());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[0, 1, 2]" in iterable is expected to be a map but got array instead.');
        Assert::that([[0, 1, 2]])->values()->isMap();
    }

    public function testIsNaturalInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([0, 1, 2])->values()->isNaturalInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "-1" in iterable is expected to be a natural int but got int instead.');
        Assert::that([-1])->values()->isNaturalInt();
    }

    public function testIsNegativeInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([-1, -2])->values()->isNegativeInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "1" in iterable is expected to be a negative int but got int instead.');
        Assert::that([1])->values()->isNegativeInt();
    }

    public function testIsNonEmptyString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['a', 'b'])->values()->isNonEmptyString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'\'" in iterable is expected to be a non-empty string but got string instead.');
        Assert::that([''])->values()->isNonEmptyString();
    }

    public function testIsNull(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([null, null])->values()->isNull());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" in iterable is expected to be null but got int instead.');
        Assert::that([42])->values()->isNull();
    }

    public function testIsNumeric(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([1, 2.0, '3'])->values()->isNumeric());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'abc\'" in iterable is expected to be numeric but got string instead.');
        Assert::that(['abc'])->values()->isNumeric();
    }

    public function testIsObject(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([new \stdClass(), new \Exception('a')])->values()->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" in iterable is expected to be an object but got int instead.');
        Assert::that([42])->values()->isObject();
    }

    public function testIsPositiveInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([1, 2, 3])->values()->isPositiveInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "-1" in iterable is expected to be a positive int but got int instead.');
        Assert::that([-1])->values()->isPositiveInt();
    }

    public function testIsResource(): void
    {
        $resource = fopen('php://temp', 'rb');
        self::assertNotFalse($resource);

        try {
            self::assertNoErrorsThrown(static fn() => Assert::that([$resource])->values()->isResource());

            $this->expectException(ExpectationFailedException::class);
            $this->expectExceptionMessage('Value "42" in iterable is expected to be a resource but got int instead.');
            Assert::that([42])->values()->isResource();
        } finally {
            fclose($resource);
        }
    }

    public function testIsScalar(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([1, 'a', true, 1.5])->values()->isScalar());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" in iterable is expected to be a scalar but got array instead.');
        Assert::that([[]])->values()->isScalar();
    }

    public function testIsString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['a', 'b'])->values()->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" in iterable is expected to be a string but got int instead.');
        Assert::that([42])->values()->isString();
    }

    public function testIsTrue(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([true, true])->values()->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "false" in iterable is expected to be true but got bool instead.');
        Assert::that([false])->values()->isTrue();
    }

    public function testIsUppercaseString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['HELLO', 'WORLD'])->values()->isUppercaseString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'Hello\'" in iterable is expected to be an uppercase string but got string instead.');
        Assert::that(['Hello'])->values()->isUppercaseString();
    }

    public function testMatchesRegularExpression(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['abc123', 'abc456'])->values()->matchesRegularExpression('/^abc\d+$/'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'xyz\'" in iterable is expected to match the PCRE pattern \'/^abc\\d+$/\'.');
        Assert::that(['xyz'])->values()->matchesRegularExpression('/^abc\d+$/');
    }

    public function testStartsWith(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['hello world', 'hello there'])->values()->startsWith('hello'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'goodbye\'" in iterable is expected to start with "\'hello\'".');
        Assert::that(['goodbye'])->values()->startsWith('hello');
    }
}
