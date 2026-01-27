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
    private const MESSAGE_HAS_METHOD = 'Object of class "{value}" is expected to have method "{method}".';
    private const MESSAGE_HAS_OFFSET = 'Array "{value}" is expected to have offset "{key}".';
    private const MESSAGE_HAS_PROPERTY = 'Object of class "{value}" is expected to have property "{property}".';
    private const MESSAGE_IS_ARRAY = 'Value "{value}" is expected to be an array but got {type} instead.';
    private const MESSAGE_IS_ARRAY_KEY = 'Value "{value}" is expected to be an array key but got {type} instead.';
    private const MESSAGE_IS_BOOL = 'Value "{value}" is expected to be a bool but got {type} instead.';
    private const MESSAGE_IS_CALLABLE = 'Value "{value}" is expected to be callable but got {type} instead.';
    private const MESSAGE_IS_COUNTABLE = 'Value "{value}" is expected to be countable but got {type} instead.';
    private const MESSAGE_IS_FALSE = 'Value "{value}" is expected to be false but got {type} instead.';
    private const MESSAGE_IS_FLOAT = 'Value "{value}" is expected to be a float but got {type} instead.';
    private const MESSAGE_IS_INSTANCE_OF = 'Value "{value}" is expected to be an instance of {class} but got {type} instead.';
    private const MESSAGE_IS_INT = 'Value "{value}" is expected to be an int but got {type} instead.';
    private const MESSAGE_IS_ITERABLE = 'Value "{value}" is expected to be iterable but got {type} instead.';
    private const MESSAGE_IS_LIST = 'Value "{value}" is expected to be a list but got {type} instead.';
    private const MESSAGE_IS_MAP = 'Value "{value}" is expected to be a map but got {type} instead.';
    private const MESSAGE_IS_NATURAL_INT = 'Value "{value}" is expected to be a natural int but got {type} instead.';
    private const MESSAGE_IS_NEGATIVE_INT = 'Value "{value}" is expected to be a negative int but got {type} instead.';
    private const MESSAGE_IS_NON_EMPTY_STRING = 'Value "{value}" is expected to be a non-empty string but got {type} instead.';
    private const MESSAGE_IS_NULL = 'Value "{value}" is expected to be null but got {type} instead.';
    private const MESSAGE_IS_NUMERIC = 'Value "{value}" is expected to be numeric but got {type} instead.';
    private const MESSAGE_IS_OBJECT = 'Value "{value}" is expected to be an object but got {type} instead.';
    private const MESSAGE_IS_POSITIVE_INT = 'Value "{value}" is expected to be a positive int but got {type} instead.';
    private const MESSAGE_IS_RESOURCE = 'Value "{value}" is expected to be a resource but got {type} instead.';
    private const MESSAGE_IS_SAME_AS = 'Value "{value}" is expected to be the same as {other} but they differ.';
    private const MESSAGE_IS_SCALAR = 'Value "{value}" is expected to be a scalar but got {type} instead.';
    private const MESSAGE_IS_STRING = 'Value "{value}" is expected to be a string but got {type} instead.';
    private const MESSAGE_IS_TRUE = 'Value "{value}" is expected to be true but got {type} instead.';
    private const MESSAGE_MATCHES_REGULAR_EXPRESSION = 'Value "{value}" is expected to match the PCRE pattern "{pattern}".';

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
    public function hasMethod(string $method, ?string $message = null): self
    {
        $this->isObject($message);

        if (! method_exists($this->value, $method)) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_HAS_METHOD,
                [
                    'value' => $this->exporter->exportType($this->value),
                    'method' => $method,
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function hasOffset(int|string $key, ?string $message = null): self
    {
        $this->isArray($message);

        if (! \array_key_exists($key, $this->value)) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_HAS_OFFSET,
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'key' => $key,
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function hasProperty(string $property, ?string $message = null): self
    {
        $this->isObject($message);

        if (! property_exists($this->value, $property)) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_HAS_PROPERTY,
                [
                    'value' => $this->exporter->exportType($this->value),
                    'property' => $property,
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isArray(?string $message = null): self
    {
        if (! \is_array($this->value)) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_ARRAY,
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
    public function isArrayKey(?string $message = null): self
    {
        if (! \is_int($this->value) && ! \is_string($this->value)) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_ARRAY_KEY,
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
                $message ?? self::MESSAGE_IS_BOOL,
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
                $message ?? self::MESSAGE_IS_CALLABLE,
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
                $message ?? self::MESSAGE_IS_COUNTABLE,
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
                $message ?? self::MESSAGE_IS_FALSE,
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
                $message ?? self::MESSAGE_IS_FLOAT,
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
    public function isInstanceOf(object|string $class, ?string $message = null): self
    {
        if (! $this->value instanceof $class) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_INSTANCE_OF,
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'class' => $this->exporter->exportValue($class),
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
                $message ?? self::MESSAGE_IS_INT,
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
                $message ?? self::MESSAGE_IS_ITERABLE,
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
    public function isList(?string $message = null): self
    {
        $this->isArray($message);

        if (! array_is_list($this->value)) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_LIST,
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
    public function isMap(?string $message = null): self
    {
        $this->isArray($message);

        if (array_filter($this->value, is_string(...), ARRAY_FILTER_USE_KEY) !== $this->value) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_MAP,
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
    public function isNaturalInt(?string $message = null): self
    {
        $this->isInt($message);

        if ($this->value < 0) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_NATURAL_INT,
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
    public function isNegativeInt(?string $message = null): self
    {
        $this->isInt($message);

        if ($this->value >= 0) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_NEGATIVE_INT,
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
    public function isNonEmptyString(?string $message = null): self
    {
        $this->isString($message);

        if ('' === $this->value) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_NON_EMPTY_STRING,
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
                $message ?? self::MESSAGE_IS_NULL,
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
                $message ?? self::MESSAGE_IS_NUMERIC,
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
                $message ?? self::MESSAGE_IS_OBJECT,
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
    public function isPositiveInt(?string $message = null): self
    {
        $this->isInt($message);

        if ($this->value <= 0) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_POSITIVE_INT,
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
                $message ?? self::MESSAGE_IS_RESOURCE,
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
    public function isSameAs(mixed $other, ?string $message = null): self
    {
        if ($this->value !== $other) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_SAME_AS,
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'other' => $this->exporter->exportValue($other),
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
                $message ?? self::MESSAGE_IS_SCALAR,
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
                $message ?? self::MESSAGE_IS_STRING,
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
                $message ?? self::MESSAGE_IS_TRUE,
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'type' => $this->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @param non-empty-string      $pattern
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     */
    public function matchesRegularExpression(string $pattern, ?string $message = null): self
    {
        $this->isString($message);

        if (preg_match($pattern, $this->value) !== 1) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_MATCHES_REGULAR_EXPRESSION,
                [
                    'value' => $this->exporter->exportValue($this->value),
                    'pattern' => $pattern,
                ],
            );
        }

        return $this;
    }
}
