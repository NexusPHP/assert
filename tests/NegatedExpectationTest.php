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
use Nexus\Assert\Exporter;
use Nexus\Assert\ExporterInterface;
use Nexus\Assert\NegatedExpectation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(NegatedExpectation::class)]
#[Group('unit')]
final class NegatedExpectationTest extends TestCase
{
    private ExporterInterface $exporter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exporter = new Exporter();
    }

    public function testContains(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('hello world')->not()->contains('planet'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello world\'" is not expected to contain "\'world\'".');
        Assert::that('hello world')->not()->contains('world');
    }

    public function testHasMethod(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(new \stdClass())->not()->hasMethod('nonExistentMethod'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "Exception" is not expected to have method "__toString".');
        Assert::that(new \Exception('Test'))->not()->hasMethod('__toString');
    }

    public function testHasOffset(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['a' => 1, 'b' => 2])->not()->hasOffset('c'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Array "[\'a\' => 1, \'b\' => 2]" is not expected to have offset "a".');
        Assert::that(['a' => 1, 'b' => 2])->not()->hasOffset('a');
    }

    public function testHasProperty(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(new \stdClass())->not()->hasProperty('nonExistentProperty'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "stdClass" is not expected to have property "existingProperty".');
        $obj = new \stdClass();
        $obj->existingProperty = 'value';
        Assert::that($obj)->not()->hasProperty('existingProperty');
    }

    public function testIsArray(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isArray());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is not expected to be an array.');
        Assert::that([])->not()->isArray();
    }

    public function testIsArrayKey(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(3.14)->not()->isArrayKey());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to be an array key.');
        Assert::that(42)->not()->isArrayKey();
    }

    public function testIsBool(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isBool());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is not expected to be a bool.');
        Assert::that(true)->not()->isBool();
    }

    public function testIsCallable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isCallable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(Closure)" is not expected to be callable.');
        Assert::that(static function (): void {})->not()->isCallable();
    }

    public function testIsCountable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isCountable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is not expected to be countable.');
        Assert::that([])->not()->isCountable();
    }

    public function testIsFalse(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(true)->not()->isFalse());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "false" is not expected to be false.');
        Assert::that(false)->not()->isFalse();
    }

    public function testIsFloat(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isFloat());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is not expected to be a float.');
        Assert::that(3.14)->not()->isFloat();
    }

    #[DataProvider('provideIsIdenticalCases')]
    public function testIsIdentical(mixed $value, mixed $other): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that($value)->not()->isIdentical($other));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(\sprintf(
            'Value "%1$s" is not expected to be identical to "%1$s".',
            $this->exporter->exportValue($value),
        ));
        Assert::that($value)->not()->isIdentical($value);
    }

    public static function provideIsIdenticalCases(): iterable
    {
        yield 'int vs string' => [42, '42'];

        yield 'float vs int' => [3.14, 3];

        yield 'string vs bool' => ['true', true];

        yield 'array vs object' => [[], new \stdClass()];
    }

    public function testIsInstanceOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(new \stdClass())->not()->isInstanceOf(\Generator::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is not expected to be an instance of \'stdClass\'.');
        Assert::that(new \stdClass())->not()->isInstanceOf(\stdClass::class);
    }

    public function testIsInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(3.14)->not()->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to be an int.');
        Assert::that(42)->not()->isInt();
    }

    public function testIsIterable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isIterable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[1]" is not expected to be iterable.');
        Assert::that([1])->not()->isIterable();
    }

    public function testIsList(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['a' => 1, 'b' => 2])->not()->isList());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[0, 1, 2]" is not expected to be a list.');
        Assert::that([0, 1, 2])->not()->isList();
    }

    public function testIsMap(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([0, 1, 2])->not()->isMap());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[\'a\' => 1, \'b\' => 2]" is not expected to be a map.');
        Assert::that(['a' => 1, 'b' => 2])->not()->isMap();
    }

    public function testIsNaturalInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(-3)->not()->isNaturalInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "5" is not expected to be a natural int.');
        Assert::that(5)->not()->isNaturalInt();
    }

    public function testIsNegativeInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(3)->not()->isNegativeInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "-5" is not expected to be a negative int.');
        Assert::that(-5)->not()->isNegativeInt();
    }

    public function testIsNonEmptyString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('')->not()->isNonEmptyString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello\'" is not expected to be a non-empty string.');
        Assert::that('hello')->not()->isNonEmptyString();
    }

    public function testIsNull(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isNull());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "null" is not expected to be null.');
        Assert::that(null)->not()->isNull();
    }

    public function testIsNumeric(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('foo')->not()->isNumeric());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to be numeric.');
        Assert::that(42)->not()->isNumeric();
    }

    public function testIsObject(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is not expected to be an object.');
        Assert::that(new \stdClass())->not()->isObject();
    }

    public function testIsPositiveInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(-3)->not()->isPositiveInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "5" is not expected to be a positive int.');
        Assert::that(5)->not()->isPositiveInt();
    }

    public function testIsResource(): void
    {
        $resource = fopen('php://temp', 'rb');
        self::assertNotFalse($resource);

        try {
            self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isResource());

            $this->expectException(ExpectationFailedException::class);
            $this->expectExceptionMessage('Value "resource (stream)" is not expected to be a resource.');
            Assert::that($resource)->not()->isResource();
        } finally {
            fclose($resource);
        }
    }

    public function testIsScalar(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([])->not()->isScalar());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to be a scalar.');
        Assert::that(42)->not()->isScalar();
    }

    public function testIsString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello\'" is not expected to be a string.');
        Assert::that('hello')->not()->isString();
    }

    public function testIsTrue(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(false)->not()->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is not expected to be true.');
        Assert::that(true)->not()->isTrue();
    }

    public function testMatchesRegularExpression(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('test')->not()->matchesRegularExpression('/^hello\d+$/'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello123\'" is not expected to match the PCRE pattern "/^hello\d+$/".');
        Assert::that('hello123')->not()->matchesRegularExpression('/^hello\d+$/');
    }

    /**
     * @template T
     *
     * @param \Closure(): NegatedExpectation<T> $callback
     */
    private static function assertNoErrorsThrown(\Closure $callback): void
    {
        try {
            $callback();
        } catch (ExpectationFailedException) {
            self::fail('Expected no exception to be thrown.');
        }
    }
}
