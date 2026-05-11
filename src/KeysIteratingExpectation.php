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
 * An expectation that iterates over the keys of an iterable value.
 *
 * @template TValue
 *
 * @implements Expectable<TValue>
 *
 * @auto-generated
 */
final readonly class KeysIteratingExpectation implements Expectable
{
    private const MESSAGE_CONTAINS = 'Key "{value}" in iterable is expected to contain "{needle}".';
    private const MESSAGE_ENDS_WITH = 'Key "{value}" in iterable is expected to end with "{needle}".';
    private const MESSAGE_HAS_METHOD = 'Key of class "{value}" in iterable is expected to have method "{method}".';
    private const MESSAGE_HAS_OFFSET = 'Key "{value}" in iterable is expected to have offset "{key}".';
    private const MESSAGE_HAS_PROPERTY = 'Key of class "{value}" in iterable is expected to have property "{property}".';
    private const MESSAGE_IS_ARRAY = 'Key "{value}" in iterable is expected to be an array but got {type} instead.';
    private const MESSAGE_IS_ARRAY_KEY = 'Key "{value}" in iterable is expected to be an array key but got {type} instead.';
    private const MESSAGE_IS_BETWEEN = 'Key "{value}" in iterable is expected to be a number between {min} and {max}.';
    private const MESSAGE_IS_BOOL = 'Key "{value}" in iterable is expected to be a bool but got {type} instead.';
    private const MESSAGE_IS_CALLABLE = 'Key "{value}" in iterable is expected to be callable but got {type} instead.';
    private const MESSAGE_IS_COUNTABLE = 'Key "{value}" in iterable is expected to be countable but got {type} instead.';
    private const MESSAGE_IS_FALSE = 'Key "{value}" in iterable is expected to be false but got {type} instead.';
    private const MESSAGE_IS_FLOAT = 'Key "{value}" in iterable is expected to be a float but got {type} instead.';
    private const MESSAGE_IS_IDENTICAL = 'Key "{value}" in iterable is expected to be identical to "{other}".';
    private const MESSAGE_IS_INSTANCE_OF = 'Key "{value}" in iterable is expected to be an instance of {class} but got {type} instead.';
    private const MESSAGE_IS_INT = 'Key "{value}" in iterable is expected to be an int but got {type} instead.';
    private const MESSAGE_IS_ITERABLE = 'Key "{value}" in iterable is expected to be iterable but got {type} instead.';
    private const MESSAGE_IS_LIST = 'Key "{value}" in iterable is expected to be a list but got {type} instead.';
    private const MESSAGE_IS_LOWERCASE_STRING = 'Key "{value}" in iterable is expected to be a lowercase string but got {type} instead.';
    private const MESSAGE_IS_MAP = 'Key "{value}" in iterable is expected to be a map but got {type} instead.';
    private const MESSAGE_IS_NATURAL_INT = 'Key "{value}" in iterable is expected to be a natural int but got {type} instead.';
    private const MESSAGE_IS_NEGATIVE_INT = 'Key "{value}" in iterable is expected to be a negative int but got {type} instead.';
    private const MESSAGE_IS_NON_EMPTY_STRING = 'Key "{value}" in iterable is expected to be a non-empty string but got {type} instead.';
    private const MESSAGE_IS_NULL = 'Key "{value}" in iterable is expected to be null but got {type} instead.';
    private const MESSAGE_IS_NUMERIC = 'Key "{value}" in iterable is expected to be numeric but got {type} instead.';
    private const MESSAGE_IS_OBJECT = 'Key "{value}" in iterable is expected to be an object but got {type} instead.';
    private const MESSAGE_IS_POSITIVE_INT = 'Key "{value}" in iterable is expected to be a positive int but got {type} instead.';
    private const MESSAGE_IS_RESOURCE = 'Key "{value}" in iterable is expected to be a resource but got {type} instead.';
    private const MESSAGE_IS_SCALAR = 'Key "{value}" in iterable is expected to be a scalar but got {type} instead.';
    private const MESSAGE_IS_STRING = 'Key "{value}" in iterable is expected to be a string but got {type} instead.';
    private const MESSAGE_IS_TRUE = 'Key "{value}" in iterable is expected to be true but got {type} instead.';
    private const MESSAGE_IS_UPPERCASE_STRING = 'Key "{value}" in iterable is expected to be an uppercase string but got {type} instead.';
    private const MESSAGE_MATCHES_REGULAR_EXPRESSION = 'Key "{value}" in iterable is expected to match the PCRE pattern \'{pattern}\'.';
    private const MESSAGE_STARTS_WITH = 'Key "{value}" in iterable is expected to start with "{needle}".';

    /**
     * @var iterable<mixed>
     */
    public iterable $value;

    private bool $isArray;

    /**
     * @param Expectation<TValue> $expectation
     */
    public function __construct(public Expectation $expectation)
    {
        Assert::that($this->expectation->value)->isIterable();

        $this->isArray = \is_array($this->expectation->value);
        $this->value = $this->expectation->value;
    }

    /**
     * @return self<TValue>
     */
    public function contains(string $needle, ?string $message = null): self
    {
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->contains($needle, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_CONTAINS,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->endsWith($needle, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_ENDS_WITH,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
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
    public function hasMethod(string $method, ?string $message = null): self
    {
        if ($this->isArray) {
            throw new \LogicException('Method hasMethod() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->hasMethod($method, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_HAS_METHOD,
                    [
                        'value' => $this->expectation->exporter->exportType($offsetKey),
                        'method' => $method,
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
        if ($this->isArray) {
            throw new \LogicException('Method hasOffset() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->hasOffset($key, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_HAS_OFFSET,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method hasProperty() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->hasProperty($property, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_HAS_PROPERTY,
                    [
                        'value' => $this->expectation->exporter->exportType($offsetKey),
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
    public function isArray(?string $message = null): self
    {
        if ($this->isArray) {
            throw new \LogicException('Method isArray() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isArray($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_ARRAY,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isArrayKey($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_ARRAY_KEY,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isBetween($min, $max, $inclusive, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_BETWEEN,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isBool() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isBool($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_BOOL,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isCallable($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_CALLABLE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isCountable() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isCountable($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_COUNTABLE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isFalse() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isFalse($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_FALSE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isFloat() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isFloat($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_FLOAT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isIdentical($other, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_IDENTICAL,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'other' => $this->expectation->exporter->exportValue($other),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isInstanceOf() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isInstanceOf($class, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_INSTANCE_OF,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'class' => $this->expectation->exporter->exportValue($class),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isInt($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_INT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isIterable() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isIterable($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_ITERABLE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isList() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isList($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_LIST,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isLowercaseString($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_LOWERCASE_STRING,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isMap() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isMap($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_MAP,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isNaturalInt($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NATURAL_INT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isNegativeInt($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NEGATIVE_INT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isNonEmptyString($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NON_EMPTY_STRING,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isNull() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isNull($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NULL,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isNumeric($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_NUMERIC,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isObject() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isObject($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_OBJECT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isPositiveInt($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_POSITIVE_INT,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isResource() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isResource($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_RESOURCE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isScalar($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_SCALAR,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isString($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_STRING,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        if ($this->isArray) {
            throw new \LogicException('Method isTrue() cannot be called on keys of an array; array keys are constrained to int|string.');
        }

        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isTrue($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_TRUE,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->isUppercaseString($message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_IS_UPPERCASE_STRING,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'type' => $this->expectation->exporter->exportType($offsetKey),
                    ],
                );
            }
        }

        return $this;
    }

    /**
     * @return self<TValue>
     */
    public function matchesRegularExpression(string $pattern, ?string $message = null): self
    {
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->matchesRegularExpression($pattern, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_MATCHES_REGULAR_EXPRESSION,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
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
        foreach ($this->value as $offsetKey => $_) {
            try {
                Assert::that($offsetKey)->startsWith($needle, $message);
            } catch (ExpectationFailedException) {
                throw new ExpectationFailedException(
                    $message ?? self::MESSAGE_STARTS_WITH,
                    [
                        'value' => $this->expectation->exporter->exportValue($offsetKey),
                        'needle' => $this->expectation->exporter->exportValue($needle),
                    ],
                );
            }
        }

        return $this;
    }
}
