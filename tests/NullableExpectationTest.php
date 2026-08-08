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
use Nexus\Assert\NullableExpectation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;

/**
 * @internal
 */
#[CoversClass(NullableExpectation::class)]
#[Group('unit')]
final class NullableExpectationTest extends AbstractExpectationTestCase
{
    private ExporterInterface $exporter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exporter = new Exporter();
    }

    public function testContains(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->contains('world'));
        self::assertNoErrorsThrown(static fn() => Assert::that('hello world')->nullOr()->contains('world'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello world\'" is expected to be null or to contain "\'planet\'".');
        Assert::that('hello world')->nullOr()->contains('planet');
    }

    public function testEndsWith(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->endsWith('world'));
        self::assertNoErrorsThrown(static fn() => Assert::that('hello world')->nullOr()->endsWith('world'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello world\'" is expected to be null or to end with "\'planet\'".');
        Assert::that('hello world')->nullOr()->endsWith('planet');
    }

    public function testHasMaxLength(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->hasMaxLength(5));
        self::assertNoErrorsThrown(static fn() => Assert::that('abc')->nullOr()->hasMaxLength(5));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'abcdef\'" is expected to be null or to have a maximum length of 5.');
        Assert::that('abcdef')->nullOr()->hasMaxLength(5);
    }

    public function testHasMethod(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->hasMethod('__toString'));
        self::assertNoErrorsThrown(static fn() => Assert::that(new \Exception('Test'))->nullOr()->hasMethod('__toString'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "stdClass" is expected to be null or to have method "__toString".');
        Assert::that(new \stdClass())->nullOr()->hasMethod('__toString');
    }

    public function testHasMinLength(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->hasMinLength(3));
        self::assertNoErrorsThrown(static fn() => Assert::that('hello')->nullOr()->hasMinLength(3));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'ab\'" is expected to be null or to have a minimum length of 3.');
        Assert::that('ab')->nullOr()->hasMinLength(3);
    }

    public function testHasOffset(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->hasOffset('nonExistentKey'));
        self::assertNoErrorsThrown(static fn() => Assert::that(['existingKey' => 'value'])->nullOr()->hasOffset('existingKey'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Array "[\'existingKey\' => \'value\']" is expected to be null or to have offset "nonExistentKey".');
        Assert::that(['existingKey' => 'value'])->nullOr()->hasOffset('nonExistentKey');
    }

    public function testHasProperty(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->hasProperty('nonExistentProperty'));

        $obj = new \stdClass();
        $obj->existingProperty = 'value';
        self::assertNoErrorsThrown(static fn() => Assert::that($obj)->nullOr()->hasProperty('existingProperty'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "Exception" is expected to be null or to have property "codes".');
        Assert::that(new \Exception('Test'))->nullOr()->hasProperty('codes');
    }

    public function testImplementsInterface(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->implementsInterface(\DateTimeInterface::class));
        self::assertNoErrorsThrown(static fn() => Assert::that(\DateTimeImmutable::class)->nullOr()->implementsInterface(\DateTimeInterface::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'stdClass\'" is expected to be null or a class string implementing \'DateTimeInterface\' but got string instead.');
        Assert::that(\stdClass::class)->nullOr()->implementsInterface(\DateTimeInterface::class);
    }

    public function testIsArray(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isArray());
        self::assertNoErrorsThrown(static fn() => Assert::that([])->nullOr()->isArray());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or an array but got int instead.');
        Assert::that(42)->nullOr()->isArray();
    }

    public function testIsArrayKey(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isArrayKey());
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->nullOr()->isArrayKey());
        self::assertNoErrorsThrown(static fn() => Assert::that('key')->nullOr()->isArrayKey());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is expected to be null or an array key but got float instead.');
        Assert::that(3.14)->nullOr()->isArrayKey();
    }

    public function testIsBetween(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isBetween(0, 10));
        self::assertNoErrorsThrown(static fn() => Assert::that(5)->nullOr()->isBetween(0, 10));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "15" is expected to be null or a number between 0 and 10.');
        Assert::that(15)->nullOr()->isBetween(0, 10);
    }

    public function testIsBool(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isBool());
        self::assertNoErrorsThrown(static fn() => Assert::that(true)->nullOr()->isBool());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or a bool but got int instead.');
        Assert::that(42)->nullOr()->isBool();
    }

    public function testIsCallable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isCallable());
        self::assertNoErrorsThrown(static fn() => Assert::that(static function (): void {})->nullOr()->isCallable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or callable but got int instead.');
        Assert::that(42)->nullOr()->isCallable();
    }

    public function testIsClassString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isClassString());
        self::assertNoErrorsThrown(static fn() => Assert::that(\DateTimeInterface::class)->nullOr()->isClassString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'NoSuchClass\'" is expected to be null or a class string but got string instead.');
        Assert::that('NoSuchClass')->nullOr()->isClassString();
    }

    public function testIsCountable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isCountable());
        self::assertNoErrorsThrown(static fn() => Assert::that([])->nullOr()->isCountable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or countable but got int instead.');
        Assert::that(42)->nullOr()->isCountable();
    }

    public function testIsFalse(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isFalse());
        self::assertNoErrorsThrown(static fn() => Assert::that(false)->nullOr()->isFalse());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is expected to be null or false but got bool instead.');
        Assert::that(true)->nullOr()->isFalse();
    }

    public function testIsFloat(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isFloat());
        self::assertNoErrorsThrown(static fn() => Assert::that(3.14)->nullOr()->isFloat());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or a float but got int instead.');
        Assert::that(42)->nullOr()->isFloat();
    }

    #[DataProvider('provideIsIdenticalCases')]
    public function testIsIdentical(mixed $value, mixed $other): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isIdentical($other));
        self::assertNoErrorsThrown(static fn() => Assert::that($other)->nullOr()->isIdentical($other));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(\sprintf(
            'Value "%s" is expected to be null or identical to "\'different\'".',
            $this->exporter->exportValue($value),
        ));
        Assert::that($value)->nullOr()->isIdentical('different');
    }

    public static function provideIsIdenticalCases(): iterable
    {
        $object = new \stdClass();

        yield 'object' => [$object, $object];

        yield 'int' => [42, 42];

        yield 'float' => [3.14, 3.14];

        yield 'string' => ['hello', 'hello'];

        yield 'array' => [[], []];
    }

    public function testIsInstanceOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isInstanceOf(\stdClass::class));
        self::assertNoErrorsThrown(static fn() => Assert::that(new \stdClass())->nullOr()->isInstanceOf(\stdClass::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is expected to be null or an instance of \'Generator\' but got stdClass instead.');
        Assert::that(new \stdClass())->nullOr()->isInstanceOf(\Generator::class);
    }

    public function testIsInstanceOfAny(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]));
        self::assertNoErrorsThrown(static fn() => Assert::that(new \ArrayObject())->nullOr()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is expected to be null or an instance of any of [\'Countable\', \'DateTimeInterface\'] but got stdClass instead.');
        Assert::that(new \stdClass())->nullOr()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]);
    }

    public function testIsInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isInt());
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->nullOr()->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is expected to be null or an int but got float instead.');
        Assert::that(3.14)->nullOr()->isInt();
    }

    public function testIsIntOrNonEmptyString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isIntOrNonEmptyString());
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->nullOr()->isIntOrNonEmptyString());
        self::assertNoErrorsThrown(static fn() => Assert::that('id')->nullOr()->isIntOrNonEmptyString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'\'" is expected to be null or an int or non-empty string but got string instead.');
        Assert::that('')->nullOr()->isIntOrNonEmptyString();
    }

    public function testIsIterable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isIterable());
        self::assertNoErrorsThrown(static fn() => Assert::that([1])->nullOr()->isIterable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or iterable but got int instead.');
        Assert::that(42)->nullOr()->isIterable();
    }

    public function testIsList(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isList());
        self::assertNoErrorsThrown(static fn() => Assert::that([0, 1, 2])->nullOr()->isList());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[\'a\' => 1, \'b\' => 2]" is expected to be null or a list but got array instead.');
        Assert::that(['a' => 1, 'b' => 2])->nullOr()->isList();
    }

    public function testIsLowercaseString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isLowercaseString());
        self::assertNoErrorsThrown(static fn() => Assert::that('hello')->nullOr()->isLowercaseString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'Hello\'" is expected to be null or a lowercase string but got string instead.');
        Assert::that('Hello')->nullOr()->isLowercaseString();
    }

    public function testIsMap(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isMap());
        self::assertNoErrorsThrown(static fn() => Assert::that(['a' => 1, 'b' => 2])->nullOr()->isMap());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[0, 1, 2]" is expected to be null or a map but got array instead.');
        Assert::that([0, 1, 2])->nullOr()->isMap();
    }

    public function testIsNaturalInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isNaturalInt());
        self::assertNoErrorsThrown(static fn() => Assert::that(5)->nullOr()->isNaturalInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "-3" is expected to be null or a natural int but got int instead.');
        Assert::that(-3)->nullOr()->isNaturalInt();
    }

    public function testIsNegativeInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isNegativeInt());
        self::assertNoErrorsThrown(static fn() => Assert::that(-5)->nullOr()->isNegativeInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3" is expected to be null or a negative int but got int instead.');
        Assert::that(3)->nullOr()->isNegativeInt();
    }

    public function testIsNonEmptyList(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isNonEmptyList());
        self::assertNoErrorsThrown(static fn() => Assert::that([0, 1, 2])->nullOr()->isNonEmptyList());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is expected to be null or a non-empty list but got array instead.');
        Assert::that([])->nullOr()->isNonEmptyList();
    }

    public function testIsNonEmptyString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isNonEmptyString());
        self::assertNoErrorsThrown(static fn() => Assert::that('hello')->nullOr()->isNonEmptyString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'\'" is expected to be null or a non-empty string but got string instead.');
        Assert::that('')->nullOr()->isNonEmptyString();
    }

    public function testIsNull(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isNull());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null but got int instead.');
        Assert::that(42)->nullOr()->isNull();
    }

    public function testIsNumeric(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isNumeric());
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->nullOr()->isNumeric());
        self::assertNoErrorsThrown(static fn() => Assert::that(3.14)->nullOr()->isNumeric());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is expected to be null or numeric but got bool instead.');
        Assert::that(true)->nullOr()->isNumeric();
    }

    public function testIsObject(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isObject());
        self::assertNoErrorsThrown(static fn() => Assert::that(new \stdClass())->nullOr()->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or an object but got int instead.');
        Assert::that(42)->nullOr()->isObject();
    }

    public function testIsOneOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isOneOf(['light', 'dark']));
        self::assertNoErrorsThrown(static fn() => Assert::that('dark')->nullOr()->isOneOf(['light', 'dark']));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'blue\'" is expected to be null or one of [\'light\', \'dark\'].');
        Assert::that('blue')->nullOr()->isOneOf(['light', 'dark']);
    }

    public function testIsPositiveInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isPositiveInt());
        self::assertNoErrorsThrown(static fn() => Assert::that(5)->nullOr()->isPositiveInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "-3" is expected to be null or a positive int but got int instead.');
        Assert::that(-3)->nullOr()->isPositiveInt();
    }

    public function testIsResource(): void
    {
        $resource = fopen('php://temp', 'rb');
        self::assertNotFalse($resource);

        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isResource());
        self::assertNoErrorsThrown(static fn() => Assert::that($resource)->nullOr()->isResource());

        fclose($resource);

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or a resource but got int instead.');
        Assert::that(42)->nullOr()->isResource();
    }

    public function testIsSameOrSubclassOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isSameOrSubclassOf(\DateTimeInterface::class));
        self::assertNoErrorsThrown(static fn() => Assert::that(\DateTimeImmutable::class)->nullOr()->isSameOrSubclassOf(\DateTimeImmutable::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is expected to be null or \'DateTimeInterface\' or a subclass of it but got stdClass instead.');
        Assert::that(new \stdClass())->nullOr()->isSameOrSubclassOf(\DateTimeInterface::class);
    }

    public function testIsScalar(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isScalar());
        self::assertNoErrorsThrown(static fn() => Assert::that(42)->nullOr()->isScalar());
        self::assertNoErrorsThrown(static fn() => Assert::that(3.14)->nullOr()->isScalar());
        self::assertNoErrorsThrown(static fn() => Assert::that('hello')->nullOr()->isScalar());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is expected to be null or a scalar but got array instead.');
        Assert::that([])->nullOr()->isScalar();
    }

    public function testIsString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isString());
        self::assertNoErrorsThrown(static fn() => Assert::that('hello')->nullOr()->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or a string but got int instead.');
        Assert::that(42)->nullOr()->isString();
    }

    public function testIsSubclassOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isSubclassOf(\DateTimeInterface::class));
        self::assertNoErrorsThrown(static fn() => Assert::that(\DateTimeImmutable::class)->nullOr()->isSubclassOf(\DateTimeInterface::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is expected to be null or a subclass of \'DateTimeInterface\' but got stdClass instead.');
        Assert::that(new \stdClass())->nullOr()->isSubclassOf(\DateTimeInterface::class);
    }

    public function testIsTrue(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isTrue());
        self::assertNoErrorsThrown(static fn() => Assert::that(true)->nullOr()->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "false" is expected to be null or true but got bool instead.');
        Assert::that(false)->nullOr()->isTrue();
    }

    public function testIsUppercaseString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isUppercaseString());
        self::assertNoErrorsThrown(static fn() => Assert::that('HELLO')->nullOr()->isUppercaseString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'Hello\'" is expected to be null or an uppercase string but got string instead.');
        Assert::that('Hello')->nullOr()->isUppercaseString();
    }

    public function testIsUrl(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->isUrl());
        self::assertNoErrorsThrown(static fn() => Assert::that('https://example.com')->nullOr()->isUrl());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'not a url\'" is expected to be null or a URL.');
        Assert::that('not a url')->nullOr()->isUrl();
    }

    public function testMatchesRegularExpression(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->matchesRegularExpression('/^hello\d+$/'));
        self::assertNoErrorsThrown(static fn() => Assert::that('hello123')->nullOr()->matchesRegularExpression('/^hello\d+$/'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'test\'" is expected to be null or to match the PCRE pattern \'/^hello\\d+$/\'.');
        Assert::that('test')->nullOr()->matchesRegularExpression('/^hello\d+$/');
    }

    public function testStartsWith(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(null)->nullOr()->startsWith('hello'));
        self::assertNoErrorsThrown(static fn() => Assert::that('hello world')->nullOr()->startsWith('hello'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello world\'" is expected to be null or to start with "\'planet\'".');
        Assert::that('hello world')->nullOr()->startsWith('planet');
    }
}
