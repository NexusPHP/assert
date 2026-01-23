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

namespace Nexus\Assert\Tools;

use Nexus\Assert\Expectation;

/**
 * This class is used to generate all possible variants of the `Expectation` class.
 *
 * @internal
 */
final class ExpectationVariantsGenerator
{
    /**
     * Methods which message requires more than the default ['value', 'type'] context.
     *
     * NOTES:
     * - Append '=' to parameter names to mean they are not value-exported.
     * - Append '+' to parameter names to mean they are type-exported.
     */
    public const NON_DEFAULT_CONTEXT = [
        'hasMethod' => ['value+', 'method='],
        'hasOffset' => ['value', 'key='],
        'hasProperty' => ['value+', 'property='],
        'isInstanceOf' => ['value', 'class', 'type'],
        'isSameAs' => ['value', 'other', 'type'],
    ];

    private const EXPECTATION_CLASS_TEMPLATE = <<<'PHP'
        <?php

        declare(strict_types=1);

        namespace Nexus\Assert;

        /**
         * {{ CLASS_DESCRIPTION }}
         *
         * @template TValue
         *
         * @implements Expectable<TValue>
         *
         * @auto-generated
         */
        final readonly class {{ CLASS_NAME }} implements Expectable
        {
            {{ CLASS_CONSTANTS }}

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

            {{ CLASS_METHODS }}
        }

        PHP;
    private const EXPECTATION_VARIANTS = [
        'generateNegatedExpectation' => [
            'name' => 'NegatedExpectation',
            'description' => 'An expectation that negates the original expectation.',
        ],
        'generateNullableExpectation' => [
            'name' => 'NullableExpectation',
            'description' => 'An expectation that allows null values in addition to the original expectation.',
        ],
    ];
    private const NEGATED_EXPECTATION_REPLACEMENTS = [
        'is expected to' => 'is not expected to',
        ' but got {type} instead.' => '.',
        ' but they differ.' => ' but they are.',
    ];
    private const NULLABLE_EXPECTATION_REPLACEMENTS = [
        'is expected to be' => 'is expected to be null or',
        'is expected to have' => 'is expected to be null or to have',
    ];
    private const UNSUPPORTED_METHODS = [
        'not',
        'nullOr',
    ];
    private const SRC_PATH = __DIR__.'/../../src/';

    /**
     * @var array{
     *   all?: false,
     *   negated?: false,
     *   nullable?: false,
     *   help?: false,
     * }
     */
    private array $options;

    public function __construct()
    {
        $options = getopt('', ['all', 'negated', 'nullable', 'help']);
        \assert(\is_array($options));

        $this->options = $options;

        if (isset($this->options['help']) || [] === $this->options) {
            echo "Usage: \033[32mbin/generate\033[0m [--all|--negated|--nullable|--help]\n\n";
            echo "\033[33mOptions:\033[0m\n";
            echo "  --all       Generate all expectation variants.\n";
            echo "  --negated   Generate only the NegatedExpectation variant.\n";
            echo "  --nullable  Generate only the NullableExpectation variant.\n";
            echo "  --help      Display this help message.\n";

            exit(0);
        }
    }

    public function generate(): void
    {
        $options = [
            'negated' => isset($this->options['all']) || isset($this->options['negated']),
            'nullable' => isset($this->options['all']) || isset($this->options['nullable']),
        ];

        /** @var \ReflectionClass<Expectation<mixed>> $expectation */
        $expectation = new \ReflectionClass(Expectation::class);

        if ($options['negated']) {
            self::generateExpectation(
                $expectation,
                self::EXPECTATION_VARIANTS['generateNegatedExpectation']['name'],
                self::EXPECTATION_VARIANTS['generateNegatedExpectation']['description'],
                'generateNegatedConstantCode',
                'generateNegatedMethodCode',
            );
        }

        if ($options['nullable']) {
            self::generateExpectation(
                $expectation,
                self::EXPECTATION_VARIANTS['generateNullableExpectation']['name'],
                self::EXPECTATION_VARIANTS['generateNullableExpectation']['description'],
                'generateNullableConstantCode',
                'generateNullableMethodCode',
            );
        }
    }

    /**
     * @param \ReflectionClass<Expectation<mixed>> $expectation
     */
    private static function generateExpectation(
        \ReflectionClass $expectation,
        string $name,
        string $description,
        string $constantGenerationCode,
        string $methodGenerationCode,
    ): void {
        $constantsCode = '';

        foreach ($expectation->getReflectionConstants(\ReflectionClassConstant::IS_PRIVATE) as $constant) {
            $constantCode = self::$constantGenerationCode($constant); // @phpstan-ignore staticMethod.dynamicName
            \assert(\is_string($constantCode));
            $constantsCode .= $constantCode."\n";
        }

        $methodsCode = '';

        foreach ($expectation->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->isConstructor() || \in_array($method->getName(), self::UNSUPPORTED_METHODS, true)) {
                continue;
            }

            $methodCode = self::$methodGenerationCode($method); // @phpstan-ignore staticMethod.dynamicName
            \assert(\is_string($methodCode));
            $methodsCode .= $methodCode."\n\n";
        }

        $classCode = str_replace(
            ['{{ CLASS_NAME }}', '{{ CLASS_DESCRIPTION }}', '{{ CLASS_CONSTANTS }}', '{{ CLASS_METHODS }}'],
            [$name, $description, rtrim($constantsCode), rtrim($methodsCode)],
            self::EXPECTATION_CLASS_TEMPLATE,
        );

        file_put_contents(self::SRC_PATH.$name.'.php', $classCode);
    }

    private static function generateNegatedConstantCode(\ReflectionClassConstant $constant): string
    {
        $value = $constant->getValue();
        \assert(\is_string($value));

        $value = strtr($value, self::NEGATED_EXPECTATION_REPLACEMENTS);

        return \sprintf(
            '    private const %s = %s;',
            $constant->getName(),
            var_export($value, true),
        );
    }

    private static function generateNullableConstantCode(\ReflectionClassConstant $constant): string
    {
        if ($constant->getName() === 'MESSAGE_IS_NULL') {
            return '';
        }

        $value = $constant->getValue();
        \assert(\is_string($value));

        $value = strtr($value, self::NULLABLE_EXPECTATION_REPLACEMENTS);

        return \sprintf(
            '    private const %s = %s;',
            $constant->getName(),
            var_export($value, true),
        );
    }

    private static function generateContext(string $methodName, bool $isNegated): string
    {
        $contextVariables = self::NON_DEFAULT_CONTEXT[$methodName] ?? ['value', 'type'];
        $contextCodeLines = [];

        foreach ($contextVariables as $variable) {
            $isValueExported = ! str_ends_with($variable, '=');
            $isTypeExported = str_ends_with($variable, '+');
            $variableName = rtrim($variable, '=+');

            if ('type' === $variableName) {
                $exportCode = '$this->expectation->exporter->exportType($this->value)';
            } elseif ('value' === $variableName && $isTypeExported) {
                $exportCode = '$this->expectation->exporter->exportType($this->value)';
            } elseif ('value' === $variableName) {
                $exportCode = '$this->expectation->exporter->exportValue($this->value)';
            } elseif ($isTypeExported) {
                $exportCode = '$this->expectation->exporter->exportType($'.$variableName.')';
            } elseif ($isValueExported) {
                $exportCode = '$this->expectation->exporter->exportValue($'.$variableName.')';
            } else {
                $exportCode = '$'.$variableName;
            }

            $contextCodeLines[$variableName] = \sprintf("'%s' => %s,", $variableName, $exportCode);
        }

        if ($isNegated) {
            unset($contextCodeLines['type']);
        }

        if (\count($contextCodeLines) === 1) {
            return \sprintf('[%s]', implode('', $contextCodeLines));
        }

        return \sprintf(
            "[\n        %s\n    ]",
            implode("\n        ", $contextCodeLines),
        );
    }

    /**
     * @return array{string, string}
     */
    private static function generateMethodParametersAndArguments(\ReflectionMethod $method): array
    {
        $parameters = [];
        $parameterCalls = [];

        foreach ($method->getParameters() as $parameter) {
            $defaultValue = '';

            if ($parameter->isDefaultValueAvailable()) {
                $defaultValue = $parameter->getDefaultValue();

                if (null === $defaultValue) {
                    $defaultValue = 'null';
                } else {
                    $defaultValue = var_export($defaultValue, true);
                }
            }

            $param = \sprintf(
                '%s%s$%s%s',
                $parameter->hasType() ? $parameter->getType().' ' : '',
                $parameter->isPassedByReference() ? '&' : '',
                $parameter->getName(),
                '' !== $defaultValue ? ' = '.$defaultValue : '',
            );

            $parameters[] = $param;
            $parameterCalls[] = '$'.$parameter->getName();
        }

        return [implode(', ', $parameters), implode(', ', $parameterCalls)];
    }

    private static function generateNegatedMethodCode(\ReflectionMethod $method): string
    {
        $methodName = $method->getName();
        $constantName = 'self::MESSAGE_'.strtoupper(preg_replace('/(?<!^)[A-Z]/', '_$0', $methodName) ?? $methodName);
        [$parametersCode, $parameterCallsCode] = self::generateMethodParametersAndArguments($method);

        return \sprintf(
            <<<'PHP'
                /**
                 * @return self<TValue>
                 */
                public function %1$s(%2$s): self
                {
                    try {
                        $this->expectation->%1$s(%3$s);
                    } catch (ExpectationFailedException) {
                        return $this;
                    }

                    throw new ExpectationFailedException(
                        $message ?? %4$s,
                        %5$s,
                    );
                }
                PHP,
            $methodName,
            $parametersCode,
            $parameterCallsCode,
            $constantName,
            self::generateContext($methodName, true),
        );
    }

    private static function generateNullableMethodCode(\ReflectionMethod $method): string
    {
        $methodName = $method->getName();
        $constantName = 'self::MESSAGE_'.strtoupper(preg_replace('/(?<!^)[A-Z]/', '_$0', $methodName) ?? $methodName);
        [$parametersCode, $parameterCallsCode] = self::generateMethodParametersAndArguments($method);

        if ('isNull' === $methodName) {
            return \sprintf(
                <<<'PHP'
                    /**
                     * @return self<null>
                     */
                    public function %1$s(%2$s): self
                    {
                        $this->expectation->%1$s(%3$s);

                        return $this;
                    }
                    PHP,
                $methodName,
                $parametersCode,
                $parameterCallsCode,
            );
        }

        return \sprintf(
            <<<'PHP'
                /**
                 * @return self<null|TValue>
                 */
                public function %1$s(%2$s): self
                {
                    if (null === $this->value) {
                        return $this;
                    }

                    try {
                        $this->expectation->%1$s(%3$s);
                    } catch (ExpectationFailedException) {
                        throw new ExpectationFailedException(
                            $message ?? %4$s,
                            %5$s,
                        );
                    }

                    return $this;
                }
                PHP,
            $methodName,
            $parametersCode,
            $parameterCallsCode,
            $constantName,
            self::generateContext($methodName, false),
        );
    }
}
