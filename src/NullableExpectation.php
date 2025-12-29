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
 * An expectation that allows null values in addition to the original expectation.
 *
 * @template TValue
 *
 * @implements Expectable<TValue>
 *
 * @auto-generated
 */
final readonly class NullableExpectation implements Expectable
{
    /**
     * @var TValue
     */
    public mixed $value;

    /**
     * @param Expectation<TValue> $expectation
     */
    public function __construct(
        public Expectation $expectation,
    ) {
        $this->value = $expectation->value;
    }

    /**
     * @return self<null|TValue>
     */
    public function isArray(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isArray($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isArray".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isBool(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isBool($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isBool".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isCallable(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isCallable($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isCallable".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isCountable(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isCountable($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isCountable".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isFalse(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isFalse($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isFalse".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isFloat(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isFloat($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isFloat".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isInstanceOf(string $expectedClass, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isInstanceOf($expectedClass, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isInstanceOf".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isInt(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isInt($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isInt".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isIterable(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isIterable($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isIterable".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null>
     */
    public function isNull(?string $message = null): self
    {
        $this->expectation->isNull($message);

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isNumeric(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isNumeric($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isNumeric".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isObject(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isObject($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isObject".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isResource(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isResource($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isResource".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isScalar(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isScalar($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isScalar".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isString(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isString($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isString".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isTrue(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isTrue($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? 'Value "{value}" is expected to be null or pass the expectation for method "isTrue".',
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }
}
