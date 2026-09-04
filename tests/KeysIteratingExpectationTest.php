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
use Nexus\Assert\KeysIteratingExpectation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;

/**
 * @internal
 */
#[CoversClass(KeysIteratingExpectation::class)]
#[Group('unit')]
final class KeysIteratingExpectationTest extends AbstractExpectationTestCase
{
    public function testConstructor(): void
    {
        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be iterable but got int instead.');
        new KeysIteratingExpectation(Assert::that(42));
    }

    public function testContains(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['hello' => 1, 'help' => 2])->keys()->contains('hel'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'hello\'" in iterable is expected to contain "\'world\'".');
        Assert::that(['hello' => 1, 'help' => 2])->keys()->contains('world');
    }

    public function testEndsWith(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['index.php' => 1, 'home.php' => 2])->keys()->endsWith('.php'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'index.php\'" in iterable is expected to end with "\'.html\'".');
        Assert::that(['index.php' => 1])->keys()->endsWith('.html');
    }

    public function testHasLength(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['abcde' => 1, 'fghij' => 2])->keys()->hasLength(5));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'abcdef\'" in iterable is expected to have a length of 5.');
        Assert::that(['abcdef' => 1])->keys()->hasLength(5);
    }

    public function testHasMaxLength(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['abc' => 1, 'de' => 2])->keys()->hasMaxLength(5));

        self::assertExpectationFails(
            static fn() => Assert::that(['abcdef' => 1])->keys()->hasMaxLength(5),
            'Key "\'abcdef\'" in iterable is expected to have a maximum length of 5.',
        );
    }

    public function testHasMethod(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([new \Exception(), 1]))->keys()->hasMethod('__toString'));
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator(['oops', 1]))->keys()->hasMethod('__toString'),
            'Key of class "string" in iterable is expected to have method "__toString".',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method hasMethod() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->hasMethod('__toString');
    }

    public function testHasMinLength(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['hello' => 1, 'world' => 2])->keys()->hasMinLength(3));

        self::assertExpectationFails(
            static fn() => Assert::that(['ab' => 1])->keys()->hasMinLength(3),
            'Key "\'ab\'" in iterable is expected to have a minimum length of 3.',
        );
    }

    public function testHasOffset(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([['id' => 'x'], 1]))->keys()->hasOffset('id'));
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([['other' => 'x'], 1]))->keys()->hasOffset('id'),
            'Key "[\'other\' => \'x\']" in iterable is expected to have offset "id".',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method hasOffset() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->hasOffset('a');
    }

    public function testHasProperty(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([(object) ['foo' => 'x'], 1]))->keys()->hasProperty('foo'));
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([new \stdClass(), 1]))->keys()->hasProperty('foo'),
            'Key of class "stdClass" in iterable is expected to have property "foo".',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method hasProperty() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->hasProperty('foo');
    }

    public function testImplementsInterface(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([\DateTimeImmutable::class => 1])->keys()->implementsInterface(\DateTimeInterface::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'stdClass\'" in iterable is expected to be a class string implementing \'DateTimeInterface\' but got string instead.');
        Assert::that([\stdClass::class => 1])->keys()->implementsInterface(\DateTimeInterface::class);
    }

    public function testIsArray(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([[], 1]))->keys()->isArray());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator(['oops', 1]))->keys()->isArray(),
            'Key "\'oops\'" in iterable is expected to be an array but got string instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isArray() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isArray();
    }

    public function testIsArrayKey(): void
    {
        $stringKeysExpectation = Assert::that(['a' => 1, 'b' => 2])->keys();
        self::assertSame($stringKeysExpectation, $stringKeysExpectation->isArrayKey());

        $intKeysExpectation = Assert::that([1, 2, 3])->keys();
        self::assertSame($intKeysExpectation, $intKeysExpectation->isArrayKey());

        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([null, 1]))->keys()->isArrayKey(),
            'Key "null" in iterable is expected to be an array key but got null instead.',
        );
    }

    public function testIsBetween(): void
    {
        $expectation = Assert::that([0 => 'a', 5 => 'b', 10 => 'c'])->keys();
        self::assertSame($expectation, $expectation->isBetween(0, 10));

        self::assertExpectationFails(
            static fn() => Assert::that([15 => 'a'])->keys()->isBetween(0, 10),
            'Key "15" in iterable is expected to be a number between 0 and 10.',
        );
        self::assertExpectationFails(
            static fn() => Assert::that(['a' => 1])->keys()->isBetween(0, 10),
            'Key "\'a\'" in iterable is expected to be a number between 0 and 10.',
        );
    }

    public function testIsBool(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([true, 1], [false, 2]))->keys()->isBool());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([true, 1], ['oops', 2]))->keys()->isBool(),
            'Key "\'oops\'" in iterable is expected to be a bool but got string instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isBool() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isBool();
    }

    public function testIsCallable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['strlen' => 1, 'is_string' => 2])->keys()->isCallable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'notACallable\'" in iterable is expected to be callable but got string instead.');
        Assert::that(['notACallable' => 1])->keys()->isCallable();
    }

    public function testIsClassString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([\DateTimeImmutable::class => 1, \DateTimeInterface::class => 2])->keys()->isClassString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'NoSuchClass\'" in iterable is expected to be a class string but got string instead.');
        Assert::that(['NoSuchClass' => 1])->keys()->isClassString();
    }

    public function testIsCountable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([[], 1]))->keys()->isCountable());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator(['oops', 1]))->keys()->isCountable(),
            'Key "\'oops\'" in iterable is expected to be countable but got string instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isCountable() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isCountable();
    }

    public function testIsFalse(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([false, 1]))->keys()->isFalse());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([true, 1]))->keys()->isFalse(),
            'Key "true" in iterable is expected to be false but got bool instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isFalse() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isFalse();
    }

    public function testIsFloat(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([1.5, 'x'], [2.5, 'y']))->keys()->isFloat());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([1.5, 'x'], ['oops', 'y']))->keys()->isFloat(),
            'Key "\'oops\'" in iterable is expected to be a float but got string instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isFloat() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isFloat();
    }

    public function testIsIdentical(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['foo' => 1])->keys()->isIdentical('foo'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'foo\'" in iterable is expected to be identical to "\'bar\'".');
        Assert::that(['foo' => 1])->keys()->isIdentical('bar');
    }

    public function testIsInstanceOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([new \stdClass(), 1]))->keys()->isInstanceOf(\stdClass::class));
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator(['oops', 1]))->keys()->isInstanceOf(\stdClass::class),
            'Key "\'oops\'" in iterable is expected to be an instance of \'stdClass\' but got string instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isInstanceOf() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isInstanceOf(\stdClass::class);
    }

    public function testIsInstanceOfAny(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([new \ArrayObject(), 1]))->keys()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]));
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator(['oops', 1]))->keys()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]),
            'Key "\'oops\'" in iterable is expected to be an instance of any of [\'Countable\', \'DateTimeInterface\'] but got string instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isInstanceOfAny() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isInstanceOfAny([\Countable::class, \DateTimeInterface::class]);
    }

    public function testIsInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([1, 2, 3])->keys()->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'a\'" in iterable is expected to be an int but got string instead.');
        Assert::that(['a' => 1])->keys()->isInt();
    }

    public function testIsIntOrNonEmptyString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([1, 'a' => 2])->keys()->isIntOrNonEmptyString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'\'" in iterable is expected to be an int or non-empty string but got string instead.');
        Assert::that(['' => 1])->keys()->isIntOrNonEmptyString();
    }

    public function testIsIterable(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([[], 1]))->keys()->isIterable());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator(['oops', 1]))->keys()->isIterable(),
            'Key "\'oops\'" in iterable is expected to be iterable but got string instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isIterable() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isIterable();
    }

    public function testIsList(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([[1, 2, 3], 'x']))->keys()->isList());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([['a' => 1], 'x']))->keys()->isList(),
            'Key "[\'a\' => 1]" in iterable is expected to be a list but got array instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isList() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isList();
    }

    public function testIsLowercaseString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['hello' => 1, 'world' => 2])->keys()->isLowercaseString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'Hello\'" in iterable is expected to be a lowercase string but got string instead.');
        Assert::that(['Hello' => 1])->keys()->isLowercaseString();
    }

    public function testIsMap(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([['a' => 1], 'x']))->keys()->isMap());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([[1, 2, 3], 'x']))->keys()->isMap(),
            'Key "[1, 2, 3]" in iterable is expected to be a map but got array instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isMap() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isMap();
    }

    public function testIsNaturalInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([0 => 'a', 1 => 'b'])->keys()->isNaturalInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "-1" in iterable is expected to be a natural int but got int instead.');
        Assert::that([-1 => 'a'])->keys()->isNaturalInt();
    }

    public function testIsNegativeInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([-1 => 'a', -2 => 'b'])->keys()->isNegativeInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "1" in iterable is expected to be a negative int but got int instead.');
        Assert::that([1 => 'a'])->keys()->isNegativeInt();
    }

    public function testIsNonEmptyList(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([[1, 2, 3], 'x']))->keys()->isNonEmptyList());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([[], 'x']))->keys()->isNonEmptyList(),
            'Key "[]" in iterable is expected to be a non-empty list but got array instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isNonEmptyList() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isNonEmptyList();
    }

    public function testIsNonEmptyMap(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([['a' => 1], 'x']))->keys()->isNonEmptyMap());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([[], 'x']))->keys()->isNonEmptyMap(),
            'Key "[]" in iterable is expected to be a non-empty map but got array instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isNonEmptyMap() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isNonEmptyMap();
    }

    public function testIsNonEmptyString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['a' => 1, 'b' => 2])->keys()->isNonEmptyString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'\'" in iterable is expected to be a non-empty string but got string instead.');
        Assert::that(['' => 1])->keys()->isNonEmptyString();
    }

    public function testIsNull(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([null, 1]))->keys()->isNull());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator(['oops', 1]))->keys()->isNull(),
            'Key "\'oops\'" in iterable is expected to be null but got string instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isNull() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isNull();
    }

    public function testIsNumeric(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([1, 2, 3])->keys()->isNumeric());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'abc\'" in iterable is expected to be numeric but got string instead.');
        Assert::that(['abc' => 1])->keys()->isNumeric();
    }

    public function testIsNumericString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['3.14' => 1, '1e3' => 2])->keys()->isNumericString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'abc\'" in iterable is expected to be a numeric string but got string instead.');
        Assert::that(['abc' => 1])->keys()->isNumericString();
    }

    public function testIsObject(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([new \stdClass(), 1]))->keys()->isObject());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator(['oops', 1]))->keys()->isObject(),
            'Key "\'oops\'" in iterable is expected to be an object but got string instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isObject() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isObject();
    }

    public function testIsOneOf(): void
    {
        $expectation = Assert::that(['light' => 1, 'dark' => 2])->keys();
        self::assertSame($expectation, $expectation->isOneOf(['light', 'dark']));

        self::assertExpectationFails(
            static fn() => Assert::that(['blue' => 1])->keys()->isOneOf(['light', 'dark']),
            'Key "\'blue\'" in iterable is expected to be one of [\'light\', \'dark\'].',
        );
    }

    public function testIsPositiveInt(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([1 => 'a', 2 => 'b'])->keys()->isPositiveInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "0" in iterable is expected to be a positive int but got int instead.');
        Assert::that([0 => 'a'])->keys()->isPositiveInt();
    }

    public function testIsResource(): void
    {
        $resource = fopen('php://memory', 'rb');
        self::assertIsResource($resource);

        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([$resource, 1]))->keys()->isResource());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator(['oops', 1]))->keys()->isResource(),
            'Key "\'oops\'" in iterable is expected to be a resource but got string instead.',
        );

        fclose($resource);

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isResource() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isResource();
    }

    public function testIsSameOrSubclassOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([\DateTimeImmutable::class => 1])->keys()->isSameOrSubclassOf(\DateTimeImmutable::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'stdClass\'" in iterable is expected to be \'DateTimeInterface\' or a subclass of it but got string instead.');
        Assert::that([\stdClass::class => 1])->keys()->isSameOrSubclassOf(\DateTimeInterface::class);
    }

    public function testIsScalar(): void
    {
        $stringKeysExpectation = Assert::that(['a' => 1, 'b' => 2])->keys();
        self::assertSame($stringKeysExpectation, $stringKeysExpectation->isScalar());

        $intKeysExpectation = Assert::that([1, 2, 3])->keys();
        self::assertSame($intKeysExpectation, $intKeysExpectation->isScalar());

        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([[], 1]))->keys()->isScalar(),
            'Key "[]" in iterable is expected to be a scalar but got array instead.',
        );
    }

    public function testIsString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['a' => 1, 'b' => 2])->keys()->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "0" in iterable is expected to be a string but got int instead.');
        Assert::that([1, 2, 3])->keys()->isString();
    }

    public function testIsSubclassOf(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that([\DateTimeImmutable::class => 1])->keys()->isSubclassOf(\DateTimeInterface::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'stdClass\'" in iterable is expected to be a subclass of \'DateTimeInterface\' but got string instead.');
        Assert::that([\stdClass::class => 1])->keys()->isSubclassOf(\DateTimeInterface::class);
    }

    public function testIsTrue(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(self::asGenerator([true, 1]))->keys()->isTrue());
        self::assertExpectationFails(
            static fn() => Assert::that(self::asGenerator([false, 1]))->keys()->isTrue(),
            'Key "false" in iterable is expected to be true but got bool instead.',
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Method isTrue() cannot be called on keys of an array; array keys are constrained to int|string.');
        Assert::that(['a' => 1])->keys()->isTrue();
    }

    public function testIsUppercaseString(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['HELLO' => 1, 'WORLD' => 2])->keys()->isUppercaseString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'Hello\'" in iterable is expected to be an uppercase string but got string instead.');
        Assert::that(['Hello' => 1])->keys()->isUppercaseString();
    }

    public function testIsUrl(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['https://example.com' => 1, 'http://foo.bar' => 2])->keys()->isUrl());

        self::assertExpectationFails(
            static fn() => Assert::that(['not a url' => 1])->keys()->isUrl(),
            'Key "\'not a url\'" in iterable is expected to be a URL.',
        );
    }

    public function testMatchesRegularExpression(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['abc123' => 1, 'abc456' => 2])->keys()->matchesRegularExpression('/^abc\d+$/'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'xyz\'" in iterable is expected to match the PCRE pattern \'/^abc\\d+$/\'.');
        Assert::that(['xyz' => 1])->keys()->matchesRegularExpression('/^abc\d+$/');
    }

    public function testStartsWith(): void
    {
        self::assertNoErrorsThrown(static fn() => Assert::that(['hello' => 1, 'help' => 2])->keys()->startsWith('he'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Key "\'hello\'" in iterable is expected to start with "\'world\'".');
        Assert::that(['hello' => 1])->keys()->startsWith('world');
    }

    /**
     * @param array{mixed, mixed} ...$pairs
     *
     * @return \Generator<mixed, mixed>
     */
    private static function asGenerator(array ...$pairs): \Generator
    {
        foreach ($pairs as [$key, $value]) {
            yield $key => $value;
        }
    }
}
