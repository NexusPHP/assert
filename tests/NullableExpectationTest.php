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
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(NullableExpectation::class)]
#[Group('unit')]
final class NullableExpectationTest extends TestCase
{
    private ExporterInterface $exporter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exporter = new Exporter();
    }

    public function testHasMethod(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->hasMethod('nonExistentMethod'));

        $nullableExpectation = Assert::that(new \Exception('Test'))->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->hasMethod('__toString'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "stdClass" is expected to be null or to have method "__toString".');
        Assert::that(new \stdClass())->nullOr()->hasMethod('__toString');
    }

    public function testHasProperty(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->hasProperty('nonExistentProperty'));

        $obj = new \stdClass();
        $obj->existingProperty = 'value';
        $nullableExpectation = Assert::that($obj)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->hasProperty('existingProperty'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "Exception" is expected to be null or to have property "codes".');
        Assert::that(new \Exception('Test'))->nullOr()->hasProperty('codes');
    }

    public function testIsArray(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isArray());

        $nullableExpectation = Assert::that([])->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isArray());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or an array but got int instead.');
        Assert::that(42)->nullOr()->isArray();
    }

    public function testIsBool(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isBool());

        $nullableExpectation = Assert::that(true)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isBool());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or a bool but got int instead.');
        Assert::that(42)->nullOr()->isBool();
    }

    public function testIsCallable(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isCallable());

        $nullableExpectation = Assert::that(static function (): void {})->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isCallable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or callable but got int instead.');
        Assert::that(42)->nullOr()->isCallable();
    }

    public function testIsCountable(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isCountable());

        $nullableExpectation = Assert::that([])->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isCountable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or countable but got int instead.');
        Assert::that(42)->nullOr()->isCountable();
    }

    public function testIsFalse(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isFalse());

        $nullableExpectation = Assert::that(false)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isFalse());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is expected to be null or false but got bool instead.');
        Assert::that(true)->nullOr()->isFalse();
    }

    public function testIsFloat(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isFloat());

        $nullableExpectation = Assert::that(3.14)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isFloat());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or a float but got int instead.');
        Assert::that(42)->nullOr()->isFloat();
    }

    public function testIsInstanceOf(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isInstanceOf(\stdClass::class));

        $nullableExpectation = Assert::that(new \stdClass())->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isInstanceOf(\stdClass::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is expected to be null or an instance of \'Generator\' but got stdClass instead.');
        Assert::that(new \stdClass())->nullOr()->isInstanceOf(\Generator::class);
    }

    public function testIsInt(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isInt());

        $nullableExpectation = Assert::that(42)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is expected to be null or an int but got float instead.');
        Assert::that(3.14)->nullOr()->isInt();
    }

    public function testIsIterable(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isIterable());

        $nullableExpectation = Assert::that([1])->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isIterable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or iterable but got int instead.');
        Assert::that(42)->nullOr()->isIterable();
    }

    public function testIsList(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isList());

        $nullableExpectation = Assert::that([0, 1, 2])->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isList());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[\'a\' => 1, \'b\' => 2]" is expected to be null or a list but got array instead.');
        Assert::that(['a' => 1, 'b' => 2])->nullOr()->isList();
    }

    public function testIsMap(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isMap());

        $nullableExpectation = Assert::that(['a' => 1, 'b' => 2])->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isMap());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[0, 1, 2]" is expected to be null or a map but got array instead.');
        Assert::that([0, 1, 2])->nullOr()->isMap();
    }

    public function testIsNegativeInt(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isNegativeInt());

        $nullableExpectation = Assert::that(-5)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isNegativeInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3" is expected to be null or a negative int but got int instead.');
        Assert::that(3)->nullOr()->isNegativeInt();
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
        $this->expectExceptionMessage('Value "true" is expected to be null or numeric but got bool instead.');
        Assert::that(true)->nullOr()->isNumeric();
    }

    public function testIsObject(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isObject());

        $nullableExpectation = Assert::that(new \stdClass())->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or an object but got int instead.');
        Assert::that(42)->nullOr()->isObject();
    }

    public function testIsPositiveInt(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isPositiveInt());

        $nullableExpectation = Assert::that(5)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isPositiveInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "-3" is expected to be null or a positive int but got int instead.');
        Assert::that(-3)->nullOr()->isPositiveInt();
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
        $this->expectExceptionMessage('Value "42" is expected to be null or a resource but got int instead.');
        Assert::that(42)->nullOr()->isResource();
    }

    #[DataProvider('provideIsSameAsCases')]
    public function testIsSameAs(mixed $value, mixed $other): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isSameAs($other));

        $nullableExpectation = Assert::that($value)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isSameAs($other));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(\sprintf(
            'Value "%s" is expected to be null or the same as \'different\' but they differ.',
            $this->exporter->exportValue($value),
        ));
        Assert::that($value)->nullOr()->isSameAs('different');
    }

    public static function provideIsSameAsCases(): iterable
    {
        $object = new \stdClass();

        yield 'object' => [$object, $object];

        yield 'int' => [42, 42];

        yield 'float' => [3.14, 3.14];

        yield 'string' => ['hello', 'hello'];

        yield 'array' => [[], []];
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
        $this->expectExceptionMessage('Value "[]" is expected to be null or a scalar but got array instead.');
        Assert::that([])->nullOr()->isScalar();
    }

    public function testIsString(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isString());

        $nullableExpectation = Assert::that('hello')->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is expected to be null or a string but got int instead.');
        Assert::that(42)->nullOr()->isString();
    }

    public function testIsTrue(): void
    {
        $nullableExpectation = Assert::that(null)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isTrue());

        $nullableExpectation = Assert::that(true)->nullOr();
        self::assertSame($nullableExpectation, $nullableExpectation->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "false" is expected to be null or true but got bool instead.');
        Assert::that(false)->nullOr()->isTrue();
    }
}
