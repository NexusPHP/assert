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
 * Interface for an expectation.
 *
 * The actual result can vary whether the expectation is positive, negative, or
 * covers an iterable set.
 *
 * @template TValue
 */
interface Expectable
{
    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function contains(string $needle, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function endsWith(string $needle, ?string $message = null): self;

    /**
     * @param int<0, max>           $count
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function hasCount(int $count, ?string $message = null): self;

    /**
     * @param int<1, max>           $length
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function hasLength(int $length, ?string $message = null): self;

    /**
     * @param int<0, max>           $max
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function hasMaxCount(int $max, ?string $message = null): self;

    /**
     * @param int<1, max>           $max
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function hasMaxLength(int $max, ?string $message = null): self;

    /**
     * @param non-empty-string      $method
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function hasMethod(string $method, ?string $message = null): self;

    /**
     * @param int<0, max>           $min
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function hasMinCount(int $min, ?string $message = null): self;

    /**
     * @param int<1, max>           $min
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function hasMinLength(int $min, ?string $message = null): self;

    /**
     * @param array-key             $key
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function hasOffset(int|string $key, ?string $message = null): self;

    /**
     * @param non-empty-string      $property
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function hasProperty(string $property, ?string $message = null): self;

    /**
     * @template T of object
     *
     * @param class-string<T>       $interface
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function implementsInterface(string $interface, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isArray(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isArrayAccessible(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isArrayKey(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isBetween(float|int $min, float|int $max, bool $inclusive = true, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isBool(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isCallable(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isClassString(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isCountable(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isFalse(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isFloat(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isGreaterThan(float|int $limit, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isGreaterThanOrEqual(float|int $limit, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isIdentical(mixed $other, ?string $message = null): self;

    /**
     * @template T of object
     *
     * @param class-string<T>|T     $class
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isInstanceOf(object|string $class, ?string $message = null): self;

    /**
     * @param non-empty-list<class-string> $classes
     * @param null|non-empty-string        $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isInstanceOfAny(array $classes, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isInt(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isIntOrNonEmptyString(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isIterable(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isLessThan(float|int $limit, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isLessThanOrEqual(float|int $limit, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isList(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isLowercaseString(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isMap(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNaturalInt(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNegativeInt(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNonEmptyList(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNonEmptyMap(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNonEmptyString(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNull(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNumeric(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isNumericString(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isObject(?string $message = null): self;

    /**
     * @param non-empty-list<mixed> $choices
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isOneOf(array $choices, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isPositiveInt(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isResource(?string $message = null): self;

    /**
     * @template T of object
     *
     * @param class-string<T>|T     $class
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isSameOrSubclassOf(object|string $class, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isScalar(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isString(?string $message = null): self;

    /**
     * @template T of object
     *
     * @param class-string<T>|T     $class
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isSubclassOf(object|string $class, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isTrue(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isUppercaseString(?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function isUrl(?string $message = null): self;

    /**
     * @param non-empty-string      $pattern
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function matchesRegularExpression(string $pattern, ?string $message = null): self;

    /**
     * @param null|non-empty-string $message
     *
     * @return self<TValue>
     *
     * @throws ExpectationFailedException
     */
    public function startsWith(string $needle, ?string $message = null): self;
}
