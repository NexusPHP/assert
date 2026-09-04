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
    private const MESSAGE_CONTAINS = 'Value "{value}" is not expected to contain "{needle}".';
    private const MESSAGE_ENDS_WITH = 'Value "{value}" is not expected to end with "{needle}".';
    private const MESSAGE_HAS_COUNT = 'Value "{value}" is not expected to have a count of {count}.';
    private const MESSAGE_HAS_LENGTH = 'Value "{value}" is not expected to have a length of {length}.';
    private const MESSAGE_HAS_MAX_COUNT = 'Value "{value}" is not expected to have a maximum count of {max}.';
    private const MESSAGE_HAS_MAX_LENGTH = 'Value "{value}" is not expected to have a maximum length of {max}.';
    private const MESSAGE_HAS_METHOD = 'Object of class "{value}" is not expected to have method "{method}".';
    private const MESSAGE_HAS_MIN_COUNT = 'Value "{value}" is not expected to have a minimum count of {min}.';
    private const MESSAGE_HAS_MIN_LENGTH = 'Value "{value}" is not expected to have a minimum length of {min}.';
    private const MESSAGE_HAS_OFFSET = 'Array "{value}" is not expected to have offset "{key}".';
    private const MESSAGE_HAS_PROPERTY = 'Object of class "{value}" is not expected to have property "{property}".';
    private const MESSAGE_IMPLEMENTS_INTERFACE = 'Value "{value}" is not expected to be a class string implementing {interface}.';
    private const MESSAGE_IS_ARRAY = 'Value "{value}" is not expected to be an array.';
    private const MESSAGE_IS_ARRAY_KEY = 'Value "{value}" is not expected to be an array key.';
    private const MESSAGE_IS_BETWEEN = 'Value "{value}" is not expected to be a number between {min} and {max}.';
    private const MESSAGE_IS_BOOL = 'Value "{value}" is not expected to be a bool.';
    private const MESSAGE_IS_CALLABLE = 'Value "{value}" is not expected to be callable.';
    private const MESSAGE_IS_CLASS_STRING = 'Value "{value}" is not expected to be a class string.';
    private const MESSAGE_IS_COUNTABLE = 'Value "{value}" is not expected to be countable.';
    private const MESSAGE_IS_FALSE = 'Value "{value}" is not expected to be false.';
    private const MESSAGE_IS_FLOAT = 'Value "{value}" is not expected to be a float.';
    private const MESSAGE_IS_GREATER_THAN = 'Value "{value}" is not expected to be a number greater than {limit}.';
    private const MESSAGE_IS_GREATER_THAN_OR_EQUAL = 'Value "{value}" is not expected to be a number greater than or equal to {limit}.';
    private const MESSAGE_IS_IDENTICAL = 'Value "{value}" is not expected to be identical to "{other}".';
    private const MESSAGE_IS_INSTANCE_OF = 'Value "{value}" is not expected to be an instance of {class}.';
    private const MESSAGE_IS_INT = 'Value "{value}" is not expected to be an int.';
    private const MESSAGE_IS_INT_OR_NON_EMPTY_STRING = 'Value "{value}" is not expected to be an int or non-empty string.';
    private const MESSAGE_IS_INSTANCE_OF_ANY = 'Value "{value}" is not expected to be an instance of any of {classes}.';
    private const MESSAGE_IS_ITERABLE = 'Value "{value}" is not expected to be iterable.';
    private const MESSAGE_IS_LESS_THAN = 'Value "{value}" is not expected to be a number less than {limit}.';
    private const MESSAGE_IS_LESS_THAN_OR_EQUAL = 'Value "{value}" is not expected to be a number less than or equal to {limit}.';
    private const MESSAGE_IS_LIST = 'Value "{value}" is not expected to be a list.';
    private const MESSAGE_IS_LOWERCASE_STRING = 'Value "{value}" is not expected to be a lowercase string.';
    private const MESSAGE_IS_MAP = 'Value "{value}" is not expected to be a map.';
    private const MESSAGE_IS_NATURAL_INT = 'Value "{value}" is not expected to be a natural int.';
    private const MESSAGE_IS_NEGATIVE_INT = 'Value "{value}" is not expected to be a negative int.';
    private const MESSAGE_IS_NON_EMPTY_LIST = 'Value "{value}" is not expected to be a non-empty list.';
    private const MESSAGE_IS_NON_EMPTY_MAP = 'Value "{value}" is not expected to be a non-empty map.';
    private const MESSAGE_IS_NON_EMPTY_STRING = 'Value "{value}" is not expected to be a non-empty string.';
    private const MESSAGE_IS_NULL = 'Value "{value}" is not expected to be null.';
    private const MESSAGE_IS_NUMERIC = 'Value "{value}" is not expected to be numeric.';
    private const MESSAGE_IS_NUMERIC_STRING = 'Value "{value}" is not expected to be a numeric string.';
    private const MESSAGE_IS_OBJECT = 'Value "{value}" is not expected to be an object.';
    private const MESSAGE_IS_ONE_OF = 'Value "{value}" is not expected to be one of {choices}.';
    private const MESSAGE_IS_POSITIVE_INT = 'Value "{value}" is not expected to be a positive int.';
    private const MESSAGE_IS_RESOURCE = 'Value "{value}" is not expected to be a resource.';
    private const MESSAGE_IS_SAME_OR_SUBCLASS_OF = 'Value "{value}" is not expected to be {class} or a subclass of it.';
    private const MESSAGE_IS_SCALAR = 'Value "{value}" is not expected to be a scalar.';
    private const MESSAGE_IS_STRING = 'Value "{value}" is not expected to be a string.';
    private const MESSAGE_IS_SUBCLASS_OF = 'Value "{value}" is not expected to be a subclass of {class}.';
    private const MESSAGE_IS_TRUE = 'Value "{value}" is not expected to be true.';
    private const MESSAGE_IS_UPPERCASE_STRING = 'Value "{value}" is not expected to be an uppercase string.';
    private const MESSAGE_IS_URL = 'Value "{value}" is not expected to be a URL.';
    private const MESSAGE_MATCHES_REGULAR_EXPRESSION = 'Value "{value}" is not expected to match the PCRE pattern \'{pattern}\'.';
    private const MESSAGE_STARTS_WITH = 'Value "{value}" is not expected to start with "{needle}".';

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
     * @return self<TValue>
     */
    public function contains(string $needle, ?string $message = null): self
    {
        try {
            $this->expectation->contains($needle, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_CONTAINS,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'needle' => $this->expectation->exporter->exportValue($needle),
            ],
        );
    }

    /**
     * @return self<TValue>
     */
    public function endsWith(string $needle, ?string $message = null): self
    {
        try {
            $this->expectation->endsWith($needle, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_ENDS_WITH,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'needle' => $this->expectation->exporter->exportValue($needle),
            ],
        );
    }

    /**
     * @param int<0, max> $count
     *
     * @return self<TValue>
     */
    public function hasCount(int $count, ?string $message = null): self
    {
        try {
            $this->expectation->hasCount($count, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_HAS_COUNT,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'count' => $this->expectation->exporter->exportValue($count),
            ],
        );
    }

    /**
     * @param int<1, max> $length
     *
     * @return self<TValue>
     */
    public function hasLength(int $length, ?string $message = null): self
    {
        try {
            $this->expectation->hasLength($length, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_HAS_LENGTH,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'length' => $this->expectation->exporter->exportValue($length),
                'actual' => \is_string($this->value) ? \strlen($this->value) : $this->expectation->exporter->exportType($this->value),
            ],
        );
    }

    /**
     * @param int<0, max> $max
     *
     * @return self<TValue>
     */
    public function hasMaxCount(int $max, ?string $message = null): self
    {
        try {
            $this->expectation->hasMaxCount($max, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_HAS_MAX_COUNT,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'max' => $this->expectation->exporter->exportValue($max),
            ],
        );
    }

    /**
     * @param int<1, max> $max
     *
     * @return self<TValue>
     */
    public function hasMaxLength(int $max, ?string $message = null): self
    {
        try {
            $this->expectation->hasMaxLength($max, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_HAS_MAX_LENGTH,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'max' => $this->expectation->exporter->exportValue($max),
            ],
        );
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
     * @param int<0, max> $min
     *
     * @return self<TValue>
     */
    public function hasMinCount(int $min, ?string $message = null): self
    {
        try {
            $this->expectation->hasMinCount($min, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_HAS_MIN_COUNT,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'min' => $this->expectation->exporter->exportValue($min),
            ],
        );
    }

    /**
     * @param int<1, max> $min
     *
     * @return self<TValue>
     */
    public function hasMinLength(int $min, ?string $message = null): self
    {
        try {
            $this->expectation->hasMinLength($min, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_HAS_MIN_LENGTH,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'min' => $this->expectation->exporter->exportValue($min),
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
    public function implementsInterface(string $interface, ?string $message = null): self
    {
        try {
            $this->expectation->implementsInterface($interface, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IMPLEMENTS_INTERFACE,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'interface' => $this->expectation->exporter->exportValue($interface),
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
    public function isArrayKey(?string $message = null): self
    {
        try {
            $this->expectation->isArrayKey($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_ARRAY_KEY,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isBetween(float|int $min, float|int $max, bool $inclusive = true, ?string $message = null): self
    {
        try {
            $this->expectation->isBetween($min, $max, $inclusive, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_BETWEEN,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'min' => $this->expectation->exporter->exportValue($min),
                'max' => $this->expectation->exporter->exportValue($max),
            ],
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
    public function isClassString(?string $message = null): self
    {
        try {
            $this->expectation->isClassString($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_CLASS_STRING,
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
    public function isGreaterThan(float|int $limit, ?string $message = null): self
    {
        try {
            $this->expectation->isGreaterThan($limit, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_GREATER_THAN,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'limit' => $this->expectation->exporter->exportValue($limit),
            ],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isGreaterThanOrEqual(float|int $limit, ?string $message = null): self
    {
        try {
            $this->expectation->isGreaterThanOrEqual($limit, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_GREATER_THAN_OR_EQUAL,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'limit' => $this->expectation->exporter->exportValue($limit),
            ],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isIdentical(mixed $other, ?string $message = null): self
    {
        try {
            $this->expectation->isIdentical($other, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_IDENTICAL,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'other' => $this->expectation->exporter->exportValue($other),
            ],
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
    public function isInstanceOfAny(array $classes, ?string $message = null): self
    {
        try {
            $this->expectation->isInstanceOfAny($classes, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_INSTANCE_OF_ANY,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'classes' => $this->expectation->exporter->exportValue($classes),
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
    public function isIntOrNonEmptyString(?string $message = null): self
    {
        try {
            $this->expectation->isIntOrNonEmptyString($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_INT_OR_NON_EMPTY_STRING,
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
    public function isLessThan(float|int $limit, ?string $message = null): self
    {
        try {
            $this->expectation->isLessThan($limit, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_LESS_THAN,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'limit' => $this->expectation->exporter->exportValue($limit),
            ],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isLessThanOrEqual(float|int $limit, ?string $message = null): self
    {
        try {
            $this->expectation->isLessThanOrEqual($limit, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_LESS_THAN_OR_EQUAL,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'limit' => $this->expectation->exporter->exportValue($limit),
            ],
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
    public function isLowercaseString(?string $message = null): self
    {
        try {
            $this->expectation->isLowercaseString($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_LOWERCASE_STRING,
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
    public function isNonEmptyList(?string $message = null): self
    {
        try {
            $this->expectation->isNonEmptyList($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_NON_EMPTY_LIST,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isNonEmptyMap(?string $message = null): self
    {
        try {
            $this->expectation->isNonEmptyMap($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_NON_EMPTY_MAP,
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
    public function isNumericString(?string $message = null): self
    {
        try {
            $this->expectation->isNumericString($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_NUMERIC_STRING,
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
     * @param non-empty-list<mixed> $choices
     *
     * @return self<TValue>
     */
    public function isOneOf(array $choices, ?string $message = null): self
    {
        try {
            $this->expectation->isOneOf($choices, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_ONE_OF,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'choices' => $this->expectation->exporter->exportValue($choices),
            ],
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
    public function isSameOrSubclassOf(object|string $class, ?string $message = null): self
    {
        try {
            $this->expectation->isSameOrSubclassOf($class, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_SAME_OR_SUBCLASS_OF,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'class' => $this->expectation->exporter->exportValue($class),
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
    public function isSubclassOf(object|string $class, ?string $message = null): self
    {
        try {
            $this->expectation->isSubclassOf($class, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_SUBCLASS_OF,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'class' => $this->expectation->exporter->exportValue($class),
            ],
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

    /**
     * @return self<TValue>
     */
    public function isUppercaseString(?string $message = null): self
    {
        try {
            $this->expectation->isUppercaseString($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_UPPERCASE_STRING,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @return self<TValue>
     */
    public function isUrl(?string $message = null): self
    {
        try {
            $this->expectation->isUrl($message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_IS_URL,
            ['value' => $this->expectation->exporter->exportValue($this->value)],
        );
    }

    /**
     * @param non-empty-string      $pattern
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     */
    public function matchesRegularExpression(string $pattern, ?string $message = null): self
    {
        try {
            $this->expectation->matchesRegularExpression($pattern, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_MATCHES_REGULAR_EXPRESSION,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'pattern' => $pattern,
            ],
        );
    }

    /**
     * @return self<TValue>
     */
    public function startsWith(string $needle, ?string $message = null): self
    {
        try {
            $this->expectation->startsWith($needle, $message);
        } catch (ExpectationFailedException) {
            return $this;
        }

        throw new ExpectationFailedException(
            $message ?? self::MESSAGE_STARTS_WITH,
            [
                'value' => $this->expectation->exporter->exportValue($this->value),
                'needle' => $this->expectation->exporter->exportValue($needle),
            ],
        );
    }
}
