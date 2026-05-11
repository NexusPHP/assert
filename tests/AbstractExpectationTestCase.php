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
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
abstract class AbstractExpectationTestCase extends TestCase
{
    /**
     * @param \Closure(): mixed $callback
     */
    protected static function assertNoErrorsThrown(\Closure $callback): void
    {
        try {
            $callback();
        } catch (ExpectationFailedException) {
            self::fail('Expected no exception to be thrown.');
        }
    }

    /**
     * @param \Closure(): mixed $callback
     */
    protected static function assertExpectationFails(\Closure $callback, string $message): void
    {
        try {
            $callback();
            self::fail('Expected ExpectationFailedException to be thrown.');
        } catch (ExpectationFailedException $e) {
            self::assertSame($message, $e->getMessage());
        }
    }
}
