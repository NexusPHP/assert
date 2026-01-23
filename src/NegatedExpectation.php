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
    private const MESSAGE_HAS_METHOD = 'Object of class "{value}" is not expected to have method "{method}".';
    private const MESSAGE_HAS_OFFSET = 'Array "{value}" is not expected to have offset "{key}".';
    private const MESSAGE_HAS_PROPERTY = 'Object of class "{value}" is not expected to have property "{property}".';
    private const MESSAGE_IS_ARRAY = 'Value "{value}" is not expected to be an array.';
    private const MESSAGE_IS_BOOL = 'Value "{value}" is not expected to be a bool.';
    private const MESSAGE_IS_CALLABLE = 'Value "{value}" is not expected to be callable.';
    private const MESSAGE_IS_COUNTABLE = 'Value "{value}" is not expected to be countable.';
    private const MESSAGE_IS_FALSE = 'Value "{value}" is not expected to be false.';
    private const MESSAGE_IS_FLOAT = 'Value "{value}" is not expected to be a float.';
    private const MESSAGE_IS_INSTANCE_OF = 'Value "{value}" is not expected to be an instance of {class}.';
    private const MESSAGE_IS_INT = 'Value "{value}" is not expected to be an int.';
    private const MESSAGE_IS_ITERABLE = 'Value "{value}" is not expected to be iterable.';
    private const MESSAGE_IS_LIST = 'Value "{value}" is not expected to be a list.';
    private const MESSAGE_IS_MAP = 'Value "{value}" is not expected to be a map.';
    private const MESSAGE_IS_NATURAL_INT = 'Value "{value}" is not expected to be a natural int.';
    private const MESSAGE_IS_NEGATIVE_INT = 'Value "{value}" is not expected to be a negative int.';
    private const MESSAGE_IS_NON_EMPTY_STRING = 'Value "{value}" is not expected to be a non-empty string.';
    private const MESSAGE_IS_NULL = 'Value "{value}" is not expected to be null.';
    private const MESSAGE_IS_NUMERIC = 'Value "{value}" is not expected to be numeric.';
    private const MESSAGE_IS_OBJECT = 'Value "{value}" is not expected to be an object.';
    private const MESSAGE_IS_POSITIVE_INT = 'Value "{value}" is not expected to be a positive int.';
    private const MESSAGE_IS_RESOURCE = 'Value "{value}" is not expected to be a resource.';
    private const MESSAGE_IS_SAME_AS = 'Value "{value}" is not expected to be the same as {other} but they are.';
    private const MESSAGE_IS_SCALAR = 'Value "{value}" is not expected to be a scalar.';
    private const MESSAGE_IS_STRING = 'Value "{value}" is not expected to be a string.';
    private const MESSAGE_IS_TRUE = 'Value "{value}" is not expected to be true.';

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
    public function hasMethod(string $method, ?string $message = null): self
    {
        try {
            $this->expectation->hasMethod($method, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_HAS_METHOD,
            [
                'value' => $this->expectation->exporter->exportType($this->value),
                'method' => $method,
            ],
        );
    }

    /**
     * @return self<TValue>
     */
    public function hasOffset(int|string $key, ?string $message = null): self
    {
        try {
            $this->expectation->hasOffset($key, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_HAS_OFFSET,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'key' => $key,
            ],
        );
    }

    /**
     * @return self<TValue>
     */
    public function hasProperty(string $property, ?string $message = null): self
    {
        try {
            $this->expectation->hasProperty($property, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_HAS_PROPERTY,
            [
                'value' => $this->expectation->exporter->exportType($this->value),
                'property' => $property,
            ],
        );
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
            $message ?? self::MESSAGE_IS_ARRAY,
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
            $message ?? self::MESSAGE_IS_BOOL,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isCallable(?string $message = null): self
    {
        try {
            $this->expectation->isCallable($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_CALLABLE,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isCountable(?string $message = null): self
    {
        try {
            $this->expectation->isCountable($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_COUNTABLE,
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
            $message ?? self::MESSAGE_IS_FALSE,
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
            $message ?? self::MESSAGE_IS_FLOAT,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isInstanceOf(object|string $class, ?string $message = null): self
    {
        try {
            $this->expectation->isInstanceOf($class, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_INSTANCE_OF,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'class' => $this->expectation->exporter->exportValue($class),
            ],
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
            $message ?? self::MESSAGE_IS_INT,
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
            $message ?? self::MESSAGE_IS_ITERABLE,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isList(?string $message = null): self
    {
        try {
            $this->expectation->isList($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_LIST,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isMap(?string $message = null): self
    {
        try {
            $this->expectation->isMap($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_MAP,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isNaturalInt(?string $message = null): self
    {
        try {
            $this->expectation->isNaturalInt($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_NATURAL_INT,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isNegativeInt(?string $message = null): self
    {
        try {
            $this->expectation->isNegativeInt($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_NEGATIVE_INT,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isNonEmptyString(?string $message = null): self
    {
        try {
            $this->expectation->isNonEmptyString($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_NON_EMPTY_STRING,
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
            $message ?? self::MESSAGE_IS_NULL,
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
            $message ?? self::MESSAGE_IS_NUMERIC,
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
            $message ?? self::MESSAGE_IS_OBJECT,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isPositiveInt(?string $message = null): self
    {
        try {
            $this->expectation->isPositiveInt($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_POSITIVE_INT,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isResource(?string $message = null): self
    {
        try {
            $this->expectation->isResource($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_RESOURCE,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isSameAs(mixed $other, ?string $message = null): self
    {
        try {
            $this->expectation->isSameAs($other, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_SAME_AS,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'other' => $this->expectation->exporter->exportValue($other),
            ],
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
            $message ?? self::MESSAGE_IS_SCALAR,
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
            $message ?? self::MESSAGE_IS_STRING,
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
            $message ?? self::MESSAGE_IS_TRUE,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }
}
