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

namespace Nexus\Assert;

final class Assert
{
    private static ?ExporterInterface $exporter = null;

    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Explicitly prevent instantiation.
    }

    public static function setExporter(?ExporterInterface $exporter): void
    {
        self::$exporter = $exporter;
    }

    /**
     * Starts an expectation on a given `$value`.
     *
     * @template T
     *
     * @param T $value
     *
     * @return Expectation<T>
     */
    public static function that(mixed $value): Expectation
    {
        self::$exporter ??= new Exporter();

        return new Expectation($value, self::$exporter);
    }
}
