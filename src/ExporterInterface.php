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

/**
 * Interface for an exporter.
 */
interface ExporterInterface
{
    /**
     * Exports a value to string.
     */
    public function exportValue(mixed $value): string;

    /**
     * Exports the type of a value to string.
     */
    public function exportType(mixed $value): string;
}
