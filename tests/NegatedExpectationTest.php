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

/**
 * @internal
 */
#[CoversClass(NegatedExpectation::class)]
#[Group('unit')]
final class NegatedExpectationTest extends AbstractExpectationTestCase
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

    public function testEndsWith(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('hello world')->not()->endsWith('planet'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello world\'" is not expected to end with "\'world\'".');
        Assert::that('hello world')->not()->endsWith('world');
    }

    public function testHasLength(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('abcdef')->not()->hasLength(5));
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->hasLength(5));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'abcde\'" is not expected to have a length of 5.');
        Assert::that('abcde')->not()->hasLength(5);
    }

    public function testHasMaxLength(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('abcdef')->not()->hasMaxLength(5));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'abc\'" is not expected to have a maximum length of 5.');
        Assert::that('abc')->not()->hasMaxLength(5);
    }

    public function testHasMethod(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(new \stdClass())->not()->hasMethod('nonExistentMethod'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "Exception" is not expected to have method "__toString".');
        Assert::that(new \Exception('Test'))->not()->hasMethod('__toString');
    }

    public function testHasMinLength(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('ab')->not()->hasMinLength(3));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'abc\'" is not expected to have a minimum length of 3.');
        Assert::that('abc')->not()->hasMinLength(3);
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

    public function testImplementsInterface(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(\stdClass::class)->not()->implementsInterface(\DateTimeInterface::class));
        self::assertNoErrorsThrown(static fn() => Assert::that(new \DateTimeImmutable())->not()->implementsInterface(\DateTimeInterface::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'DateTimeImmutable\'" is not expected to be a class string implementing \'DateTimeInterface\'.');
        Assert::that(\DateTimeImmutable::class)->not()->implementsInterface(\DateTimeInterface::class);
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

    public function testIsBetween(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(15)->not()->isBetween(0, 10));
        self::assertNoErrorsThrown(static fn() => Assert::that('5')->not()->isBetween(0, 10));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "5" is not expected to be a number between 0 and 10.');
        Assert::that(5)->not()->isBetween(0, 10);
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

    public function testIsClassString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('NoSuchClass')->not()->isClassString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'DateTimeInterface\'" is not expected to be a class string.');
        Assert::that(\DateTimeInterface::class)->not()->isClassString();
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

    public function testIsInstanceOfAny(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(new \stdClass())->not()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(ArrayObject)" is not expected to be an instance of any of [\'Countable\', \'DateTimeInterface\'].');
        Assert::that(new \ArrayObject())->not()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]);
    }

    public function testIsInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(3.14)->not()->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to be an int.');
        Assert::that(42)->not()->isInt();
    }

    public function testIsIntOrNonEmptyString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('')->not()->isIntOrNonEmptyString());
        self::assertNoErrorsThrown(static fn() => Assert::that(3.14)->not()->isIntOrNonEmptyString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to be an int or non-empty string.');
        Assert::that(42)->not()->isIntOrNonEmptyString();
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

    public function testIsLowercaseString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('Hello')->not()->isLowercaseString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello\'" is not expected to be a lowercase string.');
        Assert::that('hello')->not()->isLowercaseString();
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

    public function testIsNonEmptyList(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([])->not()->isNonEmptyList());
        self::assertNoErrorsThrown(static fn() => Assert::that(['a' => 1])->not()->isNonEmptyList());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[0, 1, 2]" is not expected to be a non-empty list.');
        Assert::that([0, 1, 2])->not()->isNonEmptyList();
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

    public function testIsNumericString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('abc')->not()->isNumericString());
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isNumericString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'42\'" is not expected to be a numeric string.');
        Assert::that('42')->not()->isNumericString();
    }

    public function testIsObject(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->not()->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is not expected to be an object.');
        Assert::that(new \stdClass())->not()->isObject();
    }

    public function testIsOneOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('blue')->not()->isOneOf(['light', 'dark']));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'light\'" is not expected to be one of [\'light\', \'dark\'].');
        Assert::that('light')->not()->isOneOf(['light', 'dark']);
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

    public function testIsSameOrSubclassOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(new \stdClass())->not()->isSameOrSubclassOf(\DateTimeInterface::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'DateTimeImmutable\'" is not expected to be \'DateTimeImmutable\' or a subclass of it.');
        Assert::that(\DateTimeImmutable::class)->not()->isSameOrSubclassOf(\DateTimeImmutable::class);
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

    public function testIsSubclassOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(new \stdClass())->not()->isSubclassOf(\DateTimeInterface::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'DateTimeImmutable\'" is not expected to be a subclass of \'DateTimeInterface\'.');
        Assert::that(\DateTimeImmutable::class)->not()->isSubclassOf(\DateTimeInterface::class);
    }

    public function testIsTrue(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(false)->not()->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is not expected to be true.');
        Assert::that(true)->not()->isTrue();
    }

    public function testIsUppercaseString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('Hello')->not()->isUppercaseString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'HELLO\'" is not expected to be an uppercase string.');
        Assert::that('HELLO')->not()->isUppercaseString();
    }

    public function testIsUrl(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('not a url')->not()->isUrl());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'https://example.com\'" is not expected to be a URL.');
        Assert::that('https://example.com')->not()->isUrl();
    }

    public function testMatchesRegularExpression(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('test')->not()->matchesRegularExpression('/^hello\d+$/'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello123\'" is not expected to match the PCRE pattern \'/^hello\\d+$/\'.');
        Assert::that('hello123')->not()->matchesRegularExpression('/^hello\d+$/');
    }

    public function testStartsWith(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that('hello world')->not()->startsWith('planet'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello world\'" is not expected to start with "\'hello\'".');
        Assert::that('hello world')->not()->startsWith('hello');
    }
}
