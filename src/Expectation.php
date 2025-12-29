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
 *
 * @implements Expectable<TValue>
 */
final readonly class Expectation implements Expectable
{
    /**
     * @param TValue $value
     */
    public function __construct(
        public mixed $value,
        public ExporterInterface $exporter = new Exporter(),
    ) {}

    /**
     * @return NegatedExpectation<TValue>
     */
    public function not(): NegatedExpectation
    {
        return new NegatedExpectation($this);
    }

    /**
     * @return NullableExpectation<TValue>
     */
    public function nullOr(): NullableExpectation
    {
        return new NullableExpectation($this);
    }

    /**
     * @return self<TValue>
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
     * @return self<TValue>
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
     * @return self<TValue>
     */
    public function isCallable(?string $message = null): self
    {
        if (! \is_callable($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be callable but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isCountable(?string $message = null): self
    {
        if (! is_countable($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be countable but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<TValue>
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
     * @return self<TValue>
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
     * @return self<TValue>
     */
    public function isInstanceOf(string $expectedClass, ?string $message = null): self
    {
        if (! $this->value instanceof $expectedClass) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be an instance of {expectedClass} but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'expectedClass' => $expectedClass,
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<TValue>
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
     * @return self<TValue>
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
     * @return self<TValue>
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
     * @return self<TValue>
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
     * @return self<TValue>
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
     * @return self<TValue>
     */
    public function isResource(?string $message = null): self
    {
        if (! \is_resource($this->value)) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be a resource but got {type} instead.',
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<TValue>
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
     * @return self<TValue>
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
     * @return self<TValue>
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
