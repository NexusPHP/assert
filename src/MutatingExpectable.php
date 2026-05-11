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
 * Interface for a mutating expectation.
 *
 * Mutating expectations change the nature of the expectation itself, such as
 * negating it, allowing null values, or iterating over keys or values of an
 * iterable.
 *
 * @template T
 */
interface MutatingExpectable
{
    /**
     * @return Expectable<T>
     */
    public function not(): Expectable;

    /**
     * @return Expectable<null|T>
     */
    public function nullOr(): Expectable;

    /**
     * @return Expectable<T>
     */
    public function keys(): Expectable;

    /**
     * @return Expectable<T>
     */
    public function values(): Expectable;
}
