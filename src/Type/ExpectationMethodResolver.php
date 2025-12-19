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

namespace Nexus\Assert\Type;

use PHPStan\Type\Accessory\AccessoryNumericStringType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

final class ExpectationMethodResolver
{
    private const UNSUPPORTED_EXPECTATION_METHODS = [
        'not',
        'nullOr',
    ];

    /**
     * @var array<string, Type>
     */
    private static array $resolvers = [];

    public static function create(): self
    {
        if ([] === self::$resolvers) {
            self::$resolvers = [
                'isArray' => new ArrayType(new MixedType(), new MixedType()),
                'isBool' => new BooleanType(),
                'isFalse' => new ConstantBooleanType(false),
                'isFloat' => new FloatType(),
                'isInt' => new IntegerType(),
                'isIterable' => new IterableType(new MixedType(), new MixedType()),
                'isNull' => new NullType(),
                'isNumeric' => TypeCombinator::union(
                    new IntegerType(),
                    new FloatType(),
                    TypeCombinator::intersect(
                        new StringType(),
                        new AccessoryNumericStringType(),
                    ),
                ),
                'isObject' => new ObjectWithoutClassType(),
                'isScalar' => TypeCombinator::union(
                    new BooleanType(),
                    new IntegerType(),
                    new FloatType(),
                    new StringType(),
                ),
                'isString' => new StringType(),
                'isTrue' => new ConstantBooleanType(true),
            ];
        }

        return new self();
    }

    public function resolve(string $methodName): ?Type
    {
        $resolvers = self::$resolvers;

        if (\in_array($methodName, self::UNSUPPORTED_EXPECTATION_METHODS, true)) {
            return null;
        }

        if (! isset($resolvers[$methodName])) {
            throw new \LogicException(\sprintf('No type resolver found for method %s()', $methodName));
        }

        return $resolvers[$methodName];
    }
}
