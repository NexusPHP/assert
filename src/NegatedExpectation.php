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
 * An expectation that negates the original expectation.
 *
 * @template TValue
 *
 * @implements Expectable<TValue>
 *
 * @auto-generated
 */
final readonly class NegatedExpectation implements Expectable
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
     * @return self<TValue>
     */
    public function isArray(?string $message = null): self
    {
        try {
            $this->expectation->isArray($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isArray".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isBool(?string $message = null): self
    {
        try {
            $this->expectation->isBool($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isBool".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isFalse(?string $message = null): self
    {
        try {
            $this->expectation->isFalse($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isFalse".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isFloat(?string $message = null): self
    {
        try {
            $this->expectation->isFloat($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isFloat".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isInt(?string $message = null): self
    {
        try {
            $this->expectation->isInt($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isInt".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isIterable(?string $message = null): self
    {
        try {
            $this->expectation->isIterable($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isIterable".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isNull(?string $message = null): self
    {
        try {
            $this->expectation->isNull($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isNull".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isNumeric(?string $message = null): self
    {
        try {
            $this->expectation->isNumeric($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isNumeric".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isObject(?string $message = null): self
    {
        try {
            $this->expectation->isObject($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isObject".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isScalar(?string $message = null): self
    {
        try {
            $this->expectation->isScalar($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isScalar".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isString(?string $message = null): self
    {
        try {
            $this->expectation->isString($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isString".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isTrue(?string $message = null): self
    {
        try {
            $this->expectation->isTrue($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "isTrue".',
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }
}
