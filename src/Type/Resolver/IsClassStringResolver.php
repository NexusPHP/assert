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

namespace Nexus\Assert\Type\Resolver;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

/**
 * Narrows to `class-string`.
 */
final class IsClassStringResolver implements ResolverInterface
{
    public function __construct(
        private readonly IsStringResolver $isString,
        private readonly ReflectionProvider $reflectionProvider,
    ) {}

    #[\Override]
    public function resolve(Scope $scope, Node\Arg $arg, Node\Arg ...$args): Node\Expr
    {
        $literals = $this->resolveLiterals($scope->getType($arg->value));

        if (null !== $literals) {
            return new Node\Expr\FuncCall(
                new Node\Name\FullyQualified('in_array'),
                [
                    $arg,
                    new Node\Arg(new Node\Expr\Array_($literals)),
                    new Node\Arg(new Node\Expr\ConstFetch(new Node\Name('true'))),
                ],
            );
        }

        return new Node\Expr\BinaryOp\BooleanAnd(
            $this->isString->resolve($scope, $arg, ...$args),
            new Node\Expr\BinaryOp\BooleanOr(
                new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('class_exists'),
                    [$arg],
                ),
                new Node\Expr\FuncCall(
                    new Node\Name\FullyQualified('interface_exists'),
                    [$arg],
                ),
            ),
        );
    }

    /**
     * The known class names of a type built solely from string literals, or `null` when the type is
     * anything else. PHPStan's own `class_exists` specification leaves a lone unknown literal
     * untouched, narrowing a value the assertion in fact always rejects.
     *
     * @return null|list<Node\ArrayItem>
     */
    private function resolveLiterals(Type $type): ?array
    {
        $constantStrings = $type->getConstantStrings();

        if ([] === $constantStrings || ! TypeCombinator::union(...$constantStrings)->equals($type)) {
            return null;
        }

        $literals = [];

        foreach ($constantStrings as $constantString) {
            if ($this->reflectionProvider->hasClass($constantString->getValue())) {
                $literals[] = new Node\ArrayItem(new Node\Scalar\String_($constantString->getValue()));
            }
        }

        return $literals;
    }
}
