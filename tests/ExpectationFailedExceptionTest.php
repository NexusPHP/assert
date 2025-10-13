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

use Nexus\Assert\ExpectationFailedException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(ExpectationFailedException::class)]
#[Group('unit')]
final class ExpectationFailedExceptionTest extends TestCase
{
    public function testCanProvideInterpolatedMessage(): void
    {
        $exception = new ExpectationFailedException('Value "{value}" is not valid.', ['value' => '42']);

        self::assertSame('Value "42" is not valid.', $exception->getMessage());
        self::assertSame('Value "{value}" is not valid.', $exception->getTemplate());
        self::assertSame(['value' => '42'], $exception->getContext());
    }

    public function testCanProvideNonInterpolatedMessage(): void
    {
        $exception = new ExpectationFailedException('An error occurred.');

        self::assertSame('An error occurred.', $exception->getMessage());
        self::assertSame('An error occurred.', $exception->getTemplate());
        self::assertSame([], $exception->getContext());
    }
}
