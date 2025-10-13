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

use Nexus\Assert\Exporter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Exporter::class)]
#[Group('unit')]
final class ExporterTest extends TestCase
{
    private Exporter $exporter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->exporter = new Exporter();
    }

    #[DataProvider('provideExportValueCases')]
    public function testExportValue(mixed $value, string $expected): void
    {
        self::assertSame($expected, $this->exporter->exportValue($value));
    }

    /**
     * @return iterable<string, array{0: mixed, 1: string}>
     */
    public static function provideExportValueCases(): iterable
    {
        yield 'string' => ['hello', "'hello'"];

        yield 'int' => [42, '42'];

        yield 'float' => [3.14, '3.14'];

        yield 'bool true' => [true, 'true'];

        yield 'bool false' => [false, 'false'];

        yield 'null' => [null, 'null'];

        yield 'empty array' => [[], '[]'];

        yield 'list array' => [[1, 2, 3], '[1, 2, 3]'];

        yield 'associative array' => [['foo' => 'bar', 'baz' => 42], "['foo' => 'bar', 'baz' => 42]"];

        yield 'object' => [(object) ['foo' => 'bar'], 'object(stdClass)'];

        yield 'enum' => [TestUnitEnum::First, 'enum(Nexus\\Assert\\Tests\\TestUnitEnum::First)'];

        yield 'DateTime object' => [new \DateTimeImmutable('2024-01-01T12:00:00+00:00'), 'object(DateTimeImmutable(2024-01-01T12:00:00+00:00))'];
    }

    public function testExportResourceValues(): void
    {
        $stream = @fopen('php://memory', 'r+b');

        if (false === $stream) {
            self::fail('Failed to open memory stream.');
        }

        self::assertSame('resource (stream)', $this->exporter->exportValue($stream));

        fclose($stream);
        self::assertSame('resource (closed)', $this->exporter->exportValue($stream));
    }
}
