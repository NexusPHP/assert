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
use Nexus\Assert\ExporterInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

/**
 * @internal
 */
#[CoversClass(Assert::class)]
#[CoversClass(Expectation::class)]
#[Group('unit')]
final class ExpectationTest extends AbstractExpectationTestCase
{
    public function testCanSetDifferentExporter(): void
    {
        $exporter = self::createStub(ExporterInterface::class);
        Assert::setExporter($exporter);

        $expectation = Assert::that(42);
        self::assertSame($exporter, $expectation->exporter);

        Assert::setExporter(null);
        self::assertNotSame($exporter, Assert::that(42)->exporter);
    }

    public function testExpectationVariantReturns(): void
    {
        $expectation = Assert::that(42);
        self::assertSame($expectation, $expectation->isInt());

        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isString());

        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isArray());

        $keysExpectation = Assert::that(['a' => 1, 'b' => 2])->keys();
        self::assertSame($keysExpectation, $keysExpectation->isString());

        $valuesExpectation = Assert::that([1, 2, 3])->values();
        self::assertSame($valuesExpectation, $valuesExpectation->isInt());
    }

    public function testContains(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('hello world')->contains('world'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello world\'" is expected to contain "\'planet\'".');
        Assert::that('hello world')->contains('planet');
    }

    public function testEndsWith(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('hello world')->endsWith('world'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello world\'" is expected to end with "\'planet\'".');
        Assert::that('hello world')->endsWith('planet');
    }

    public function testHasMethod(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(new \Exception('Test'))->hasMethod('__toString'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "stdClass" is expected to have method "nonExistentMethod".');
        Assert::that(new \stdClass())->hasMethod('nonExistentMethod');
    }

    public function testHasOffset(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['a' => 1, 'b' => 2])->hasOffset('a'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Array "[\'a\' => 1, \'b\' => 2]" is expected to have offset "c".');
        Assert::that(['a' => 1, 'b' => 2])->hasOffset('c');
    }

    public function testHasProperty(): void
    {
        $expectation = Assert::that(new class {
            public int $value = 42;
        });
        self::assertNoErrorsThrown(static fn() => $expectation->hasProperty('value'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "stdClass" is expected to have property "nonExistentProperty".');
        Assert::that(new \stdClass())->hasProperty('nonExistentProperty');
    }

    public function testIsArray(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([])->isArray());
        self::assertNoErrorsThrown(static fn() => Assert::that([1, 2, 3])->isArray());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be an array but got int instead.');
        Assert::that(42)->isArray();
    }

    public function testIsArrayKey(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->isArrayKey());
        self::assertNoErrorsThrown(static fn() => Assert::that('key')->isArrayKey());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is expected to be an array key but got float instead.');
        Assert::that(3.14)->isArrayKey();
    }

    public function testIsBetween(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(5)->isBetween(0, 10));
        self::assertNoErrorsThrown(static fn() => Assert::that(0)->isBetween(0, 10));
        self::assertNoErrorsThrown(static fn() => Assert::that(10)->isBetween(0, 10));
        self::assertNoErrorsThrown(static fn() => Assert::that(0.5)->isBetween(0.0, 1.0));
        self::assertNoErrorsThrown(static fn() => Assert::that(5)->isBetween(1, 10, false));

        self::assertExpectationFails(
            static fn() => Assert::that(11)->isBetween(0, 10),
            'Value "11" is expected to be a number between 0 and 10.',
        );
        self::assertExpectationFails(
            static fn() => Assert::that(0)->isBetween(0, 10, false),
            'Value "0" is expected to be a number between 0 and 10.',
        );
        self::assertExpectationFails(
            static fn() => Assert::that('5')->isBetween(0, 10),
            'Value "\'5\'" is expected to be a number between 0 and 10.',
        );
    }

    public function testIsBool(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(true)->isBool());
        self::assertNoErrorsThrown(static fn() => Assert::that(false)->isBool());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "1" is expected to be a bool but got int instead.');
        Assert::that(1)->isBool();
    }

    public function testIsCallable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(static fn(): bool => true)->isCallable());
        self::assertNoErrorsThrown(static fn() => Assert::that('trim')->isCallable());
        self::assertNoErrorsThrown(static fn() => Assert::that([new \Exception('Hi'), '__toString'])->isCallable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be callable but got int instead.');
        Assert::that(42)->isCallable();
    }

    public function testIsCountable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([])->isCountable());
        self::assertNoErrorsThrown(static fn() => Assert::that(new \ArrayObject([1, 2, 3]))->isCountable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be countable but got int instead.');
        Assert::that(42)->isCountable();
    }

    public function testIsFalse(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(false)->isFalse());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'\'" is expected to be false but got string instead.');
        Assert::that('')->isFalse();
    }

    public function testIsFloat(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(3.14)->isFloat());
        self::assertNoErrorsThrown(static fn() => Assert::that(0.0)->isFloat());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello\'" is expected to be a float but got string instead.');
        Assert::that('hello')->isFloat();
    }

    #[DataProvider('provideIsIdenticalCases')]
    public function testIsIdentical(mixed $value, mixed $other): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that($value)->isIdentical($other));

        $this->expectException(ExpectationFailedException::class);
        Assert::that($value)->isIdentical('different');
    }

    public static function provideIsIdenticalCases(): iterable
    {
        $object = new \stdClass();

        yield 'int' => [42, 42];

        yield 'float' => [3.14, 3.14];

        yield 'string' => ['hello', 'hello'];

        yield 'null' => [null, null];

        yield 'array' => [[1, 2, 3], [1, 2, 3]];

        yield 'object' => [$object, $object];
    }

    public function testIsInstanceOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(new \DateTimeImmutable())->isInstanceOf(\DateTimeInterface::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is expected to be an instance of \'DateTimeInterface\' but got stdClass instead.');
        Assert::that(new \stdClass())->isInstanceOf(\DateTimeInterface::class);
    }

    public function testIsInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(1)->isInt());
        self::assertNoErrorsThrown(static fn() => Assert::that(0)->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is expected to be an int but got bool instead.');
        Assert::that(true)->isInt();
    }

    public function testIsIterable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([])->isIterable());
        self::assertNoErrorsThrown(static fn() => Assert::that(new \ArrayIterator([1, 2, 3]))->isIterable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be iterable but got int instead.');
        Assert::that(42)->isIterable();
    }

    public function testIsList(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([1, 2, 3])->isList());
        self::assertNoErrorsThrown(static fn() => Assert::that([])->isList());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[\'a\' => 1, \'b\' => 2]" is expected to be a list but got array instead.');
        Assert::that(['a' => 1, 'b' => 2])->isList();
    }

    public function testIsLowercaseString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('hello')->isLowercaseString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'Hello\'" is expected to be a lowercase string but got string instead.');
        Assert::that('Hello')->isLowercaseString();
    }

    public function testIsMap(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['a' => 1, 'b' => 2])->isMap());
        self::assertNoErrorsThrown(static fn() => Assert::that([])->isMap());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[1, 2]" is expected to be a map but got array instead.');
        Assert::that([1, 2])->isMap();
    }

    public function testIsNaturalInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(0)->isNaturalInt());
        self::assertNoErrorsThrown(static fn() => Assert::that(5)->isNaturalInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "-3" is expected to be a natural int but got int instead.');
        Assert::that(-3)->isNaturalInt();
    }

    public function testIsNegativeInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(-5)->isNegativeInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3" is expected to be a negative int but got int instead.');
        Assert::that(3)->isNegativeInt();
    }

    public function testIsNonEmptyString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('hello')->isNonEmptyString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'\'" is expected to be a non-empty string but got string instead.');
        Assert::that('')->isNonEmptyString();
    }

    public function testIsNull(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->isNull());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "0" is expected to be null but got int instead.');
        Assert::that(0)->isNull();
    }

    public function testIsNumeric(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->isNumeric());
        self::assertNoErrorsThrown(static fn() => Assert::that(3.14)->isNumeric());
        self::assertNoErrorsThrown(static fn() => Assert::that('42')->isNumeric());
        self::assertNoErrorsThrown(static fn() => Assert::that('3.14')->isNumeric());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is expected to be numeric but got bool instead.');
        Assert::that(true)->isNumeric();
    }

    public function testIsObject(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(new \stdClass())->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be an object but got int instead.');
        Assert::that(42)->isObject();
    }

    public function testIsOneOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('light')->isOneOf(['light', 'dark']));
        self::assertNoErrorsThrown(static fn() => Assert::that(2)->isOneOf([1, 2, 3]));

        self::assertExpectationFails(
            static fn() => Assert::that('blue')->isOneOf(['light', 'dark']),
            'Value "\'blue\'" is expected to be one of [\'light\', \'dark\'].',
        );
        self::assertExpectationFails(
            static fn() => Assert::that(0)->isOneOf([1, 2, 3]),
            'Value "0" is expected to be one of [1, 2, 3].',
        );
    }

    public function testIsPositiveInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(5)->isPositiveInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "-3" is expected to be a positive int but got int instead.');
        Assert::that(-3)->isPositiveInt();
    }

    public function testIsResource(): void
    {
        $resource = fopen('php://temp', 'rb');
        self::assertNotFalse($resource);

        self::assertNoErrorsThrown(static fn() => Assert::that($resource)->isResource());
        fclose($resource);

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be a resource but got int instead.');
        Assert::that(42)->isResource();
    }

    public function testIsScalar(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->isScalar());
        self::assertNoErrorsThrown(static fn() => Assert::that(3.14)->isScalar());
        self::assertNoErrorsThrown(static fn() => Assert::that('hello')->isScalar());
        self::assertNoErrorsThrown(static fn() => Assert::that(true)->isScalar());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is expected to be a scalar but got array instead.');
        Assert::that([])->isScalar();
    }

    public function testIsString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('hello')->isString());
        self::assertNoErrorsThrown(static fn() => Assert::that('')->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is expected to be a string but got float instead.');
        Assert::that(3.14)->isString();
    }

    public function testIsTrue(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(true)->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "12" is expected to be true but got int instead.');
        Assert::that(12)->isTrue();
    }

    public function testIsUppercaseString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('HELLO')->isUppercaseString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'Hello\'" is expected to be an uppercase string but got string instead.');
        Assert::that('Hello')->isUppercaseString();
    }

    public function testMatchesRegularExpression(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('hello123')->matchesRegularExpression('/^hello\d+$/'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'test\'" is expected to match the PCRE pattern \'/^hello\d+$/\'.');
        Assert::that('test')->matchesRegularExpression('/^hello\d+$/');
    }

    public function testStartsWith(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('hello world')->startsWith('hello'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello world\'" is expected to start with "\'planet\'".');
        Assert::that('hello world')->startsWith('planet');
    }
}
