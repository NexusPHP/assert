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

    public function testHasMethod(): void
    {
        $negatedExpectation = Assert::that(new \stdClass())->not();
        self::assertSame($negatedExpectation, $negatedExpectation->hasMethod('nonExistentMethod'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "Exception" is not expected to have method "__toString".');
        Assert::that(new \Exception('Test'))->not()->hasMethod('__toString');
    }

    public function testHasProperty(): void
    {
        $negatedExpectation = Assert::that(new \stdClass())->not();
        self::assertSame($negatedExpectation, $negatedExpectation->hasProperty('nonExistentProperty'));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Object of class "stdClass" is not expected to have property "existingProperty".');
        $obj = new \stdClass();
        $obj->existingProperty = 'value';
        Assert::that($obj)->not()->hasProperty('existingProperty');
    }

    public function testIsArray(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isArray());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is not expected to be an array.');
        Assert::that([])->not()->isArray();
    }

    public function testIsBool(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isBool());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is not expected to be a bool.');
        Assert::that(true)->not()->isBool();
    }

    public function testIsCallable(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isCallable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(Closure)" is not expected to be callable.');
        Assert::that(static function (): void {})->not()->isCallable();
    }

    public function testIsCountable(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isCountable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[]" is not expected to be countable.');
        Assert::that([])->not()->isCountable();
    }

    public function testIsFalse(): void
    {
        $negatedExpectation = Assert::that(true)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isFalse());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "false" is not expected to be false.');
        Assert::that(false)->not()->isFalse();
    }

    public function testIsFloat(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isFloat());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "3.14" is not expected to be a float.');
        Assert::that(3.14)->not()->isFloat();
    }

    public function testIsInstanceOf(): void
    {
        $negatedExpectation = Assert::that(new \stdClass())->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isInstanceOf(\Generator::class));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is not expected to be an instance of \'stdClass\'.');
        Assert::that(new \stdClass())->not()->isInstanceOf(\stdClass::class);
    }

    public function testIsInt(): void
    {
        $negatedExpectation = Assert::that(3.14)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isInt());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to be an int.');
        Assert::that(42)->not()->isInt();
    }

    public function testIsIterable(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isIterable());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[1]" is not expected to be iterable.');
        Assert::that([1])->not()->isIterable();
    }

    public function testIsList(): void
    {
        $negatedExpectation = Assert::that(['a' => 1, 'b' => 2])->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isList());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[0, 1, 2]" is not expected to be a list.');
        Assert::that([0, 1, 2])->not()->isList();
    }

    public function testIsMap(): void
    {
        $negatedExpectation = Assert::that([0, 1, 2])->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isMap());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "[\'a\' => 1, \'b\' => 2]" is not expected to be a map.');
        Assert::that(['a' => 1, 'b' => 2])->not()->isMap();
    }

    public function testIsNull(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isNull());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "null" is not expected to be null.');
        Assert::that(null)->not()->isNull();
    }

    public function testIsNumeric(): void
    {
        $negatedExpectation = Assert::that('foo')->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isNumeric());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to be numeric.');
        Assert::that(42)->not()->isNumeric();
    }

    public function testIsObject(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isObject());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "object(stdClass)" is not expected to be an object.');
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
            $this->expectExceptionMessage('Value "resource (stream)" is not expected to be a resource.');
            Assert::that($resource)->not()->isResource();
        } finally {
            fclose($resource);
        }
    }

    #[DataProvider('provideIsSameAsCases')]
    public function testIsSameAs(mixed $value, mixed $other): void
    {
        $negatedExpectation = Assert::that($value)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isSameAs($other));

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(\sprintf(
            'Value "%1$s" is not expected to be the same as %1$s but they are.',
            $this->exporter->exportValue($value),
        ));
        Assert::that($value)->not()->isSameAs($value);
    }

    public static function provideIsSameAsCases(): iterable
    {
        yield 'int vs string' => [42, '42'];

        yield 'float vs int' => [3.14, 3];

        yield 'string vs bool' => ['true', true];

        yield 'array vs object' => [[], new \stdClass()];
    }

    public function testIsScalar(): void
    {
        $negatedExpectation = Assert::that([])->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isScalar());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "42" is not expected to be a scalar.');
        Assert::that(42)->not()->isScalar();
    }

    public function testIsString(): void
    {
        $negatedExpectation = Assert::that(42)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isString());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "\'hello\'" is not expected to be a string.');
        Assert::that('hello')->not()->isString();
    }

    public function testIsTrue(): void
    {
        $negatedExpectation = Assert::that(false)->not();
        self::assertSame($negatedExpectation, $negatedExpectation->isTrue());

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage('Value "true" is not expected to be true.');
        Assert::that(true)->not()->isTrue();
    }
}
