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
 * @template TValue
 */
final class Expectation
{
    private readonly Exporter $exporter;

    /**
     * @param TValue $value
     */
    public function __construct(
        private mixed $value,
    ) {
        $this->exporter = new Exporter();
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<array&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isArray(?string $message = null): self
    {
        if (! \is_array($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be an array but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<bool&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isBool(?string $message = null): self
    {
        if (! \is_bool($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be a bool but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<false&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isFalse(?string $message = null): self
    {
        if (false !== $this->value) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be false but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<float&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isFloat(?string $message = null): self
    {
        if (! \is_float($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be a float but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<int&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isInt(?string $message = null): self
    {
        if (! \is_int($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be an int but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<iterable&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isIterable(?string $message = null): self
    {
        if (! is_iterable($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be iterable but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<null&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNull(?string $message = null): self
    {
        if (null !== $this->value) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<(float|int|numeric-string)&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNumeric(?string $message = null): self
    {
        if (! is_numeric($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be numeric but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<object&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isObject(?string $message = null): self
    {
        if (! \is_object($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be an object but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<scalar&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isScalar(?string $message = null): self
    {
        if (! \is_scalar($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be a scalar but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<string&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isString(?string $message = null): self
    {
        if (! \is_string($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be a string but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param null|non-empty-string $message
     *
     * @return self<true&TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isTrue(?string $message = null): self
    {
        if (true !== $this->value) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be true but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }
}
