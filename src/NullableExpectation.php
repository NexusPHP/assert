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
    private const MESSAGE_HAS_METHOD = 'Object of class "{value}" is expected to be null or to have method "{method}".';
    private const MESSAGE_HAS_PROPERTY = 'Object of class "{value}" is expected to be null or to have property "{property}".';
    private const MESSAGE_IS_ARRAY = 'Value "{value}" is expected to be null or an array but got {type} instead.';
    private const MESSAGE_IS_BOOL = 'Value "{value}" is expected to be null or a bool but got {type} instead.';
    private const MESSAGE_IS_CALLABLE = 'Value "{value}" is expected to be null or callable but got {type} instead.';
    private const MESSAGE_IS_COUNTABLE = 'Value "{value}" is expected to be null or countable but got {type} instead.';
    private const MESSAGE_IS_FALSE = 'Value "{value}" is expected to be null or false but got {type} instead.';
    private const MESSAGE_IS_FLOAT = 'Value "{value}" is expected to be null or a float but got {type} instead.';
    private const MESSAGE_IS_INSTANCE_OF = 'Value "{value}" is expected to be null or an instance of {class} but got {type} instead.';
    private const MESSAGE_IS_INT = 'Value "{value}" is expected to be null or an int but got {type} instead.';
    private const MESSAGE_IS_ITERABLE = 'Value "{value}" is expected to be null or iterable but got {type} instead.';
    private const MESSAGE_IS_LIST = 'Value "{value}" is expected to be null or a list but got {type} instead.';
    private const MESSAGE_IS_MAP = 'Value "{value}" is expected to be null or a map but got {type} instead.';
    private const MESSAGE_IS_NUMERIC = 'Value "{value}" is expected to be null or numeric but got {type} instead.';
    private const MESSAGE_IS_OBJECT = 'Value "{value}" is expected to be null or an object but got {type} instead.';
    private const MESSAGE_IS_RESOURCE = 'Value "{value}" is expected to be null or a resource but got {type} instead.';
    private const MESSAGE_IS_SAME_AS = 'Value "{value}" is expected to be null or the same as {other} but they differ.';
    private const MESSAGE_IS_SCALAR = 'Value "{value}" is expected to be null or a scalar but got {type} instead.';
    private const MESSAGE_IS_STRING = 'Value "{value}" is expected to be null or a string but got {type} instead.';
    private const MESSAGE_IS_TRUE = 'Value "{value}" is expected to be null or true but got {type} instead.';

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
    public function hasMethod(string $method, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->hasMethod($method, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_HAS_METHOD,
                [
                    'value' => $this->expectation->exporter->exportType($this->value),
                    'method' => $method,
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function hasProperty(string $property, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->hasProperty($property, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_HAS_PROPERTY,
                [
                    'value' => $this->expectation->exporter->exportType($this->value),
                    'property' => $property,
                ],
            );
        }

        return $this;
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
                $message ?? self::MESSAGE_IS_ARRAY,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_BOOL,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_CALLABLE,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_COUNTABLE,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_FALSE,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_FLOAT,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isInstanceOf(object|string $class, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isInstanceOf($class, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_INSTANCE_OF,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'class' => $this->expectation->exporter->exportValue($class),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_INT,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_ITERABLE,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isList(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isList($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_LIST,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isMap(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isMap($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_MAP,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_NUMERIC,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_OBJECT,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_RESOURCE,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isSameAs(mixed $other, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isSameAs($other, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_SAME_AS,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'other' => $this->expectation->exporter->exportValue($other),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_SCALAR,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_STRING,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
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
                $message ?? self::MESSAGE_IS_TRUE,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'type' => $this->expectation->exporter->exportType($this->value),
                ],
            );
        }

        return $this;
    }
}
