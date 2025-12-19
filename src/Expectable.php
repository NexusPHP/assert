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
 * Interface for an expectation.
 *
 * The actual result can vary whether the expectation is positive, negative, or
 * covers an iterable set.
 *
 * @template TValue
 */
interface Expectable
{
    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isArray(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isBool(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isFalse(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isFloat(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isInt(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isIterable(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNull(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNumeric(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isObject(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isScalar(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isString(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isTrue(?string $message = null): self;
}
