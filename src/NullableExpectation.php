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
    private const MESSAGE_CONTAINS = 'Value "{value}" is expected to be null or to contain "{needle}".';
    private const MESSAGE_ENDS_WITH = 'Value "{value}" is expected to be null or to end with "{needle}".';
    private const MESSAGE_HAS_MAX_LENGTH = 'Value "{value}" is expected to be null or to have a maximum length of {max}.';
    private const MESSAGE_HAS_METHOD = 'Object of class "{value}" is expected to be null or to have method "{method}".';
    private const MESSAGE_HAS_MIN_LENGTH = 'Value "{value}" is expected to be null or to have a minimum length of {min}.';
    private const MESSAGE_HAS_OFFSET = 'Array "{value}" is expected to be null or to have offset "{key}".';
    private const MESSAGE_HAS_PROPERTY = 'Object of class "{value}" is expected to be null or to have property "{property}".';
    private const MESSAGE_IMPLEMENTS_INTERFACE = 'Value "{value}" is expected to be null or a class string implementing {interface} but got {type} instead.';
    private const MESSAGE_IS_ARRAY = 'Value "{value}" is expected to be null or an array but got {type} instead.';
    private const MESSAGE_IS_ARRAY_KEY = 'Value "{value}" is expected to be null or an array key but got {type} instead.';
    private const MESSAGE_IS_BETWEEN = 'Value "{value}" is expected to be null or a number between {min} and {max}.';
    private const MESSAGE_IS_BOOL = 'Value "{value}" is expected to be null or a bool but got {type} instead.';
    private const MESSAGE_IS_CALLABLE = 'Value "{value}" is expected to be null or callable but got {type} instead.';
    private const MESSAGE_IS_COUNTABLE = 'Value "{value}" is expected to be null or countable but got {type} instead.';
    private const MESSAGE_IS_FALSE = 'Value "{value}" is expected to be null or false but got {type} instead.';
    private const MESSAGE_IS_FLOAT = 'Value "{value}" is expected to be null or a float but got {type} instead.';
    private const MESSAGE_IS_IDENTICAL = 'Value "{value}" is expected to be null or identical to "{other}".';
    private const MESSAGE_IS_INSTANCE_OF = 'Value "{value}" is expected to be null or an instance of {class} but got {type} instead.';
    private const MESSAGE_IS_INT = 'Value "{value}" is expected to be null or an int but got {type} instead.';
    private const MESSAGE_IS_INT_OR_NON_EMPTY_STRING = 'Value "{value}" is expected to be null or an int or non-empty string but got {type} instead.';
    private const MESSAGE_IS_ITERABLE = 'Value "{value}" is expected to be null or iterable but got {type} instead.';
    private const MESSAGE_IS_LIST = 'Value "{value}" is expected to be null or a list but got {type} instead.';
    private const MESSAGE_IS_LOWERCASE_STRING = 'Value "{value}" is expected to be null or a lowercase string but got {type} instead.';
    private const MESSAGE_IS_MAP = 'Value "{value}" is expected to be null or a map but got {type} instead.';
    private const MESSAGE_IS_NATURAL_INT = 'Value "{value}" is expected to be null or a natural int but got {type} instead.';
    private const MESSAGE_IS_NEGATIVE_INT = 'Value "{value}" is expected to be null or a negative int but got {type} instead.';
    private const MESSAGE_IS_NON_EMPTY_LIST = 'Value "{value}" is expected to be null or a non-empty list but got {type} instead.';
    private const MESSAGE_IS_NON_EMPTY_STRING = 'Value "{value}" is expected to be null or a non-empty string but got {type} instead.';
    private const MESSAGE_IS_NUMERIC = 'Value "{value}" is expected to be null or numeric but got {type} instead.';
    private const MESSAGE_IS_OBJECT = 'Value "{value}" is expected to be null or an object but got {type} instead.';
    private const MESSAGE_IS_ONE_OF = 'Value "{value}" is expected to be null or one of {choices}.';
    private const MESSAGE_IS_POSITIVE_INT = 'Value "{value}" is expected to be null or a positive int but got {type} instead.';
    private const MESSAGE_IS_RESOURCE = 'Value "{value}" is expected to be null or a resource but got {type} instead.';
    private const MESSAGE_IS_SAME_OR_SUBCLASS_OF = 'Value "{value}" is expected to be null or {class} or a subclass of it but got {type} instead.';
    private const MESSAGE_IS_SCALAR = 'Value "{value}" is expected to be null or a scalar but got {type} instead.';
    private const MESSAGE_IS_STRING = 'Value "{value}" is expected to be null or a string but got {type} instead.';
    private const MESSAGE_IS_SUBCLASS_OF = 'Value "{value}" is expected to be null or a subclass of {class} but got {type} instead.';
    private const MESSAGE_IS_TRUE = 'Value "{value}" is expected to be null or true but got {type} instead.';
    private const MESSAGE_IS_UPPERCASE_STRING = 'Value "{value}" is expected to be null or an uppercase string but got {type} instead.';
    private const MESSAGE_IS_URL = 'Value "{value}" is expected to be null or a URL.';
    private const MESSAGE_MATCHES_REGULAR_EXPRESSION = 'Value "{value}" is expected to be null or to match the PCRE pattern \'{pattern}\'.';
    private const MESSAGE_STARTS_WITH = 'Value "{value}" is expected to be null or to start with "{needle}".';

    /**
     * @var TValue
     */
    public mixed $value;

    /**
     * @param Expectation<TValue> $expectation
     */
    public function __construct(public Expectation $expectation)
    {
        $this->value = $expectation->value;
    }

    /**
     * @return self<null|TValue>
     */
    public function contains(string $needle, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->contains($needle, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_CONTAINS,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'needle' => $this->expectation->exporter->exportValue($needle),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function endsWith(string $needle, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->endsWith($needle, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_ENDS_WITH,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'needle' => $this->expectation->exporter->exportValue($needle),
                ],
            );
        }

        return $this;
    }

    /**
     * @param int<1, max> $max
     *
     * @return self<null|TValue>
     */
    public function hasMaxLength(int $max, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->hasMaxLength($max, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_HAS_MAX_LENGTH,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'max' => $this->expectation->exporter->exportValue($max),
                ],
            );
        }

        return $this;
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
     * @param int<1, max> $min
     *
     * @return self<null|TValue>
     */
    public function hasMinLength(int $min, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->hasMinLength($min, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_HAS_MIN_LENGTH,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'min' => $this->expectation->exporter->exportValue($min),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function hasOffset(int|string $key, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->hasOffset($key, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_HAS_OFFSET,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'key' => $key,
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
    public function implementsInterface(string $interface, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->implementsInterface($interface, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IMPLEMENTS_INTERFACE,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'interface' => $this->expectation->exporter->exportValue($interface),
                    'type' => $this->expectation->exporter->exportType($this->value),
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
    public function isArrayKey(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isArrayKey($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_ARRAY_KEY,
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
    public function isBetween(float|int $min, float|int $max, bool $inclusive = true, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isBetween($min, $max, $inclusive, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_BETWEEN,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'min' => $this->expectation->exporter->exportValue($min),
                    'max' => $this->expectation->exporter->exportValue($max),
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
    public function isIdentical(mixed $other, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isIdentical($other, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_IDENTICAL,
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
    public function isIntOrNonEmptyString(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isIntOrNonEmptyString($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_INT_OR_NON_EMPTY_STRING,
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
    public function isLowercaseString(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isLowercaseString($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_LOWERCASE_STRING,
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
     * @return self<null|TValue>
     */
    public function isNaturalInt(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isNaturalInt($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_NATURAL_INT,
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
    public function isNegativeInt(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isNegativeInt($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_NEGATIVE_INT,
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
    public function isNonEmptyList(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isNonEmptyList($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_NON_EMPTY_LIST,
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
    public function isNonEmptyString(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isNonEmptyString($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_NON_EMPTY_STRING,
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
     * @param non-empty-list<mixed> $choices
     *
     * @return self<null|TValue>
     */
    public function isOneOf(array $choices, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isOneOf($choices, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_ONE_OF,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'choices' => $this->expectation->exporter->exportValue($choices),
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function isPositiveInt(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isPositiveInt($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_POSITIVE_INT,
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
    public function isSameOrSubclassOf(object|string $class, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isSameOrSubclassOf($class, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_SAME_OR_SUBCLASS_OF,
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
    public function isSubclassOf(object|string $class, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isSubclassOf($class, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_SUBCLASS_OF,
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

    /**
     * @return self<null|TValue>
     */
    public function isUppercaseString(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isUppercaseString($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_UPPERCASE_STRING,
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
    public function isUrl(?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->isUrl($message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_IS_URL,
                ['value' => $this->expectation->exporter->exportValue($this->value)],
            );
        }

        return $this;
    }

    /**
     * @param non-empty-string      $pattern
     * @param null|non-empty-string $message
     *
     * @return self<null|TValue>
     */
    public function matchesRegularExpression(string $pattern, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->matchesRegularExpression($pattern, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_MATCHES_REGULAR_EXPRESSION,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'pattern' => $pattern,
                ],
            );
        }

        return $this;
    }

    /**
     * @return self<null|TValue>
     */
    public function startsWith(string $needle, ?string $message = null): self
    {
        if (null === $this->value) {
            return $this;
        }

        try {
            $this->expectation->startsWith($needle, $message);
        } catch (ExpectationFailedException) {
            throw new ExpectationFailedException(
                $message ?? self::MESSAGE_STARTS_WITH,
                [
                    'value' => $this->expectation->exporter->exportValue($this->value),
                    'needle' => $this->expectation->exporter->exportValue($needle),
                ],
            );
        }

        return $this;
    }
}
