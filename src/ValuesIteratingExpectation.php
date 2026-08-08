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
 * An expectation that iterates over the values of an iterable value.
 *
 * @template TValue
 *
 * @implements Expectable<TValue>
 *
 * @auto-generated
 */
final readonly class ValuesIteratingExpectation implements Expectable
{
    private const MESSAGE_CONTAINS = 'Value "{value}" in iterable is expected to contain "{needle}".';
    private const MESSAGE_ENDS_WITH = 'Value "{value}" in iterable is expected to end with "{needle}".';
    private const MESSAGE_HAS_MAX_LENGTH = 'Value "{value}" in iterable is expected to have a maximum length of {max}.';
    private const MESSAGE_HAS_METHOD = 'Value of class "{value}" in iterable is expected to have method "{method}".';
    private const MESSAGE_HAS_MIN_LENGTH = 'Value "{value}" in iterable is expected to have a minimum length of {min}.';
    private const MESSAGE_HAS_OFFSET = 'Value "{value}" in iterable is expected to have offset "{key}".';
    private const MESSAGE_HAS_PROPERTY = 'Value of class "{value}" in iterable is expected to have property "{property}".';
    private const MESSAGE_IMPLEMENTS_INTERFACE = 'Value "{value}" in iterable is expected to be a class string implementing {interface} but got {type} instead.';
    private const MESSAGE_IS_ARRAY = 'Value "{value}" in iterable is expected to be an array but got {type} instead.';
    private const MESSAGE_IS_ARRAY_KEY = 'Value "{value}" in iterable is expected to be an array key but got {type} instead.';
    private const MESSAGE_IS_BETWEEN = 'Value "{value}" in iterable is expected to be a number between {min} and {max}.';
    private const MESSAGE_IS_BOOL = 'Value "{value}" in iterable is expected to be a bool but got {type} instead.';
    private const MESSAGE_IS_CALLABLE = 'Value "{value}" in iterable is expected to be callable but got {type} instead.';
    private const MESSAGE_IS_COUNTABLE = 'Value "{value}" in iterable is expected to be countable but got {type} instead.';
    private const MESSAGE_IS_FALSE = 'Value "{value}" in iterable is expected to be false but got {type} instead.';
    private const MESSAGE_IS_FLOAT = 'Value "{value}" in iterable is expected to be a float but got {type} instead.';
    private const MESSAGE_IS_IDENTICAL = 'Value "{value}" in iterable is expected to be identical to "{other}".';
    private const MESSAGE_IS_INSTANCE_OF = 'Value "{value}" in iterable is expected to be an instance of {class} but got {type} instead.';
    private const MESSAGE_IS_INT = 'Value "{value}" in iterable is expected to be an int but got {type} instead.';
    private const MESSAGE_IS_INT_OR_NON_EMPTY_STRING = 'Value "{value}" in iterable is expected to be an int or non-empty string but got {type} instead.';
    private const MESSAGE_IS_ITERABLE = 'Value "{value}" in iterable is expected to be iterable but got {type} instead.';
    private const MESSAGE_IS_LIST = 'Value "{value}" in iterable is expected to be a list but got {type} instead.';
    private const MESSAGE_IS_LOWERCASE_STRING = 'Value "{value}" in iterable is expected to be a lowercase string but got {type} instead.';
    private const MESSAGE_IS_MAP = 'Value "{value}" in iterable is expected to be a map but got {type} instead.';
    private const MESSAGE_IS_NATURAL_INT = 'Value "{value}" in iterable is expected to be a natural int but got {type} instead.';
    private const MESSAGE_IS_NEGATIVE_INT = 'Value "{value}" in iterable is expected to be a negative int but got {type} instead.';
    private const MESSAGE_IS_NON_EMPTY_LIST = 'Value "{value}" in iterable is expected to be a non-empty list but got {type} instead.';
    private const MESSAGE_IS_NON_EMPTY_STRING = 'Value "{value}" in iterable is expected to be a non-empty string but got {type} instead.';
    private const MESSAGE_IS_NULL = 'Value "{value}" in iterable is expected to be null but got {type} instead.';
    private const MESSAGE_IS_NUMERIC = 'Value "{value}" in iterable is expected to be numeric but got {type} instead.';
    private const MESSAGE_IS_OBJECT = 'Value "{value}" in iterable is expected to be an object but got {type} instead.';
    private const MESSAGE_IS_ONE_OF = 'Value "{value}" in iterable is expected to be one of {choices}.';
    private const MESSAGE_IS_POSITIVE_INT = 'Value "{value}" in iterable is expected to be a positive int but got {type} instead.';
    private const MESSAGE_IS_RESOURCE = 'Value "{value}" in iterable is expected to be a resource but got {type} instead.';
    private const MESSAGE_IS_SAME_OR_SUBCLASS_OF = 'Value "{value}" in iterable is expected to be {class} or a subclass of it but got {type} instead.';
    private const MESSAGE_IS_SCALAR = 'Value "{value}" in iterable is expected to be a scalar but got {type} instead.';
    private const MESSAGE_IS_STRING = 'Value "{value}" in iterable is expected to be a string but got {type} instead.';
    private const MESSAGE_IS_SUBCLASS_OF = 'Value "{value}" in iterable is expected to be a subclass of {class} but got {type} instead.';
    private const MESSAGE_IS_TRUE = 'Value "{value}" in iterable is expected to be true but got {type} instead.';
    private const MESSAGE_IS_UPPERCASE_STRING = 'Value "{value}" in iterable is expected to be an uppercase string but got {type} instead.';
    private const MESSAGE_IS_URL = 'Value "{value}" in iterable is expected to be a URL.';
    private const MESSAGE_MATCHES_REGULAR_EXPRESSION = 'Value "{value}" in iterable is expected to match the PCRE pattern \'{pattern}\'.';
    private const MESSAGE_STARTS_WITH = 'Value "{value}" in iterable is expected to start with "{needle}".';

    /**
     * @var iterable<mixed>
     */
    public iterable $value;

    /**
     * @param Expectation<TValue> $expectation
     */
    public function __construct(public Expectation $expectation)
    {
        Assert::that($this->expectation->value)->isIterable();

        $this->value = $this->expectation->value;
    }

    /**
     * @return self<TValue>
     */
    public function contains(string $needle, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->contains($needle, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_CONTAINS,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'needle' => $this->expectation->exporter->exportValue($needle),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function endsWith(string $needle, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->endsWith($needle, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_ENDS_WITH,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'needle' => $this->expectation->exporter->exportValue($needle),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @param int<1, max> $max
     *
     * @return self<TValue>
     */
    public function hasMaxLength(int $max, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->hasMaxLength($max, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_HAS_MAX_LENGTH,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'max' => $this->expectation->exporter->exportValue($max),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function hasMethod(string $method, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->hasMethod($method, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_HAS_METHOD,
                    [
                        'value' => $this->expectation->exporter->exportType($offsetValue),
                        'method' => $method,
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @param int<1, max> $min
     *
     * @return self<TValue>
     */
    public function hasMinLength(int $min, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->hasMinLength($min, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_HAS_MIN_LENGTH,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'min' => $this->expectation->exporter->exportValue($min),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function hasOffset(int|string $key, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->hasOffset($key, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_HAS_OFFSET,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'key' => $key,
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function hasProperty(string $property, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->hasProperty($property, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_HAS_PROPERTY,
                    [
                        'value' => $this->expectation->exporter->exportType($offsetValue),
                        'property' => $property,
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function implementsInterface(string $interface, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->implementsInterface($interface, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IMPLEMENTS_INTERFACE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'interface' => $this->expectation->exporter->exportValue($interface),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isArray(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isArray($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_ARRAY,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isArrayKey(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isArrayKey($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_ARRAY_KEY,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isBetween(float|int $min, float|int $max, bool $inclusive = true, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isBetween($min, $max, $inclusive, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_BETWEEN,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'min' => $this->expectation->exporter->exportValue($min),
                        'max' => $this->expectation->exporter->exportValue($max),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isBool(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isBool($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_BOOL,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isCallable(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isCallable($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_CALLABLE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isCountable(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isCountable($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_COUNTABLE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isFalse(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isFalse($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_FALSE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isFloat(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isFloat($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_FLOAT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isIdentical(mixed $other, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isIdentical($other, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_IDENTICAL,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'other' => $this->expectation->exporter->exportValue($other),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isInstanceOf(object|string $class, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isInstanceOf($class, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_INSTANCE_OF,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'class' => $this->expectation->exporter->exportValue($class),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isInt(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isInt($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_INT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isIntOrNonEmptyString(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isIntOrNonEmptyString($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_INT_OR_NON_EMPTY_STRING,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isIterable(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isIterable($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_ITERABLE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isList(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isList($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_LIST,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isLowercaseString(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isLowercaseString($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_LOWERCASE_STRING,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isMap(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isMap($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_MAP,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isNaturalInt(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isNaturalInt($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NATURAL_INT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isNegativeInt(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isNegativeInt($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NEGATIVE_INT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isNonEmptyList(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isNonEmptyList($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NON_EMPTY_LIST,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isNonEmptyString(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isNonEmptyString($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NON_EMPTY_STRING,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isNull(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isNull($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NULL,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isNumeric(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isNumeric($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NUMERIC,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isObject(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isObject($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_OBJECT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @param non-empty-list<mixed> $choices
     *
     * @return self<TValue>
     */
    public function isOneOf(array $choices, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isOneOf($choices, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_ONE_OF,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'choices' => $this->expectation->exporter->exportValue($choices),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isPositiveInt(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isPositiveInt($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_POSITIVE_INT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isResource(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isResource($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_RESOURCE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isSameOrSubclassOf(object|string $class, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isSameOrSubclassOf($class, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_SAME_OR_SUBCLASS_OF,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'class' => $this->expectation->exporter->exportValue($class),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isScalar(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isScalar($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_SCALAR,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isString(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isString($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_STRING,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isSubclassOf(object|string $class, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isSubclassOf($class, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_SUBCLASS_OF,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'class' => $this->expectation->exporter->exportValue($class),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isTrue(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isTrue($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_TRUE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isUppercaseString(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isUppercaseString($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_UPPERCASE_STRING,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'type' => $this->expectation->exporter->exportType($offsetValue),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function isUrl(?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->isUrl($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_URL,
                    ['value' => $this->expectation->exporter->exportValue($offsetValue)],
                );
            }
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
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->matchesRegularExpression($pattern, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_MATCHES_REGULAR_EXPRESSION,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'pattern' => $pattern,
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function startsWith(string $needle, ?string $message = null): self
    {
        foreach ($this->value as $offsetValue) {
            try {
                Assert::that($offsetValue)->startsWith($needle, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_STARTS_WITH,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetValue),
                        'needle' => $this->expectation->exporter->exportValue($needle),
                    ],
                );
            }
        }

        return $this;
    }
}
