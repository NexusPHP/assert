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

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Accessory\AccessoryNumericStringType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\CallableType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\ResourceType;
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
     * @var array<string, \Closure(Scope, Node\Arg, Node\Arg): Type>
     */
    private static array $resolvers = [];

    public static function create(): self
    {
        if ([] === self::$resolvers) {
            self::$resolvers = [
                'isArray' => static fn(Scope $scope, Node\Arg $arg): Type => new ArrayType(new MixedType(), new MixedType()),
                'isBool' => static fn(Scope $scope, Node\Arg $arg): Type => new BooleanType(),
                'isCallable' => static fn(Scope $scope, Node\Arg $arg): Type => new CallableType(),
                'isFalse' => static fn(Scope $scope, Node\Arg $arg): Type => new ConstantBooleanType(false),
                'isFloat' => static fn(Scope $scope, Node\Arg $arg): Type => new FloatType(),
                'isInstanceOf' => static fn(Scope $scope, Node\Arg $arg, Node\Arg $class): Type => $scope->getType($class->value)->getClassStringObjectType(),
                'isInt' => static fn(Scope $scope, Node\Arg $arg): Type => new IntegerType(),
                'isIterable' => static fn(Scope $scope, Node\Arg $arg): Type => new IterableType(new MixedType(), new MixedType()),
                'isNull' => static fn(Scope $scope, Node\Arg $arg): Type => new NullType(),
                'isNumeric' => static fn(Scope $scope, Node\Arg $arg): Type => TypeCombinator::union(
                    new IntegerType(),
                    new FloatType(),
                    TypeCombinator::intersect(
                        new StringType(),
                        new AccessoryNumericStringType(),
                    ),
                ),
                'isObject' => static fn(Scope $scope, Node\Arg $arg): Type => new ObjectWithoutClassType(),
                'isResource' => static fn(Scope $scope, Node\Arg $arg): Type => new ResourceType(),
                'isScalar' => static fn(Scope $scope, Node\Arg $arg): Type => TypeCombinator::union(
                    new BooleanType(),
                    new IntegerType(),
                    new FloatType(),
                    new StringType(),
                ),
                'isString' => static fn(Scope $scope, Node\Arg $arg): Type => new StringType(),
                'isTrue' => static fn(Scope $scope, Node\Arg $arg): Type => new ConstantBooleanType(true),
            ];
        }

        return new self();
    }

    public function resolve(string $methodName, Scope $scope, Node\Arg $arg, Node\Arg ...$args): ?Type
    {
        $resolvers = self::$resolvers;

        if (\in_array($methodName, self::UNSUPPORTED_EXPECTATION_METHODS, true)) {
            return null;
        }

        if (! isset($resolvers[$methodName])) {
            throw new \LogicException(\sprintf('No type resolver found for method %s()', $methodName));
        }

        return $resolvers[$methodName]($scope, $arg, ...$args);
    }
}
