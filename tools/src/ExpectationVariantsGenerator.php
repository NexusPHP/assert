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
        'contains' => ['value', 'needle'],
        'endsWith' => ['value', 'needle'],
        'hasMaxLength' => ['value', 'max'],
        'hasMethod' => ['value+', 'method='],
        'hasMinLength' => ['value', 'min'],
        'hasOffset' => ['value', 'key='],
        'hasProperty' => ['value+', 'property='],
        'isBetween' => ['value', 'min', 'max'],
        'isIdentical' => ['value', 'other', 'type'],
        'isInstanceOf' => ['value', 'class', 'type'],
        'isOneOf' => ['value', 'choices'],
        'matchesRegularExpression' => ['value', 'pattern='],
        'startsWith' => ['value', 'needle'],
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
    private const ITERATING_EXPECTATION_CLASS_TEMPLATE = <<<'PHP'
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
             * @var iterable<mixed>
             */
            public iterable $value;
            {{ CLASS_ADDITIONAL_PROPERTIES }}

            /**
             * @param Expectation<TValue> $expectation
             */
            public function __construct(public Expectation $expectation)
            {
                {{ CLASS_CONSTRUCTOR_BODY }}
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
        'generateKeysIteratingExpectation' => [
            'name' => 'KeysIteratingExpectation',
            'description' => 'An expectation that iterates over the keys of an iterable value.',
            'additional_properties' => 'private bool $isArray;',
            'constructor_body' => <<<'PHP'
                Assert::that($this->expectation->value)->isIterable();

                $this->isArray = \is_array($this->expectation->value);
                $this->value = $this->expectation->value;
                PHP,
        ],
        'generateValuesIteratingExpectation' => [
            'name' => 'ValuesIteratingExpectation',
            'description' => 'An expectation that iterates over the values of an iterable value.',
            'constructor_body' => <<<'PHP'
                Assert::that($this->expectation->value)->isIterable();

                $this->value = $this->expectation->value;
                PHP,
        ],
    ];
    private const KEYS_UNREACHABLE_FOR_ARRAYS = [
        'hasMethod',
        'hasOffset',
        'hasProperty',
        'isArray',
        'isBool',
        'isCountable',
        'isFalse',
        'isFloat',
        'isInstanceOf',
        'isIterable',
        'isList',
        'isMap',
        'isNull',
        'isObject',
        'isResource',
        'isTrue',
    ];
    private const EXPECTATION_REPLACEMENTS = [
        'negated' => [
            'is expected to' => 'is not expected to',
            ' but got {type} instead.' => '.',
        ],
        'nullable' => [
            'is expected to be' => 'is expected to be null or',
            'is expected to' => 'is expected to be null or to',
        ],
        'keys' => [
            'Value "{value}" is' => 'Key "{value}" in iterable is',
            'Object of class "{value}" is' => 'Key of class "{value}" in iterable is',
            'Array "{value}" is' => 'Key "{value}" in iterable is',
        ],
        'values' => [
            'Value "{value}" is' => 'Value "{value}" in iterable is',
            'Object of class "{value}" is' => 'Value of class "{value}" in iterable is',
            'Array "{value}" is' => 'Value "{value}" in iterable is',
        ],
    ];
    private const UNSUPPORTED_METHODS = [
        'not',
        'nullOr',
        'keys',
        'values',
    ];
    private const SRC_PATH = __DIR__.'/../../src/';

    /**
     * @var array{
     *   all?: false,
     *   negated?: false,
     *   nullable?: false,
     *   keys?: false,
     *   values?: false,
     *   help?: false,
     * }
     */
    private array $options;

    public function __construct()
    {
        $options = getopt('', ['all', 'negated', 'nullable', 'keys', 'values', 'help']);
        \assert(\is_array($options));

        $this->options = $options;

        if (isset($this->options['help']) || [] === $this->options) {
            echo "Usage: \033[32mbin/generate\033[0m [--all|--negated|--nullable|--keys|--values|--help]\n\n";
            echo "\033[33mOptions:\033[0m\n";
            echo "  --all       Generate all expectation variants.\n";
            echo "  --negated   Generate only the NegatedExpectation variant.\n";
            echo "  --nullable  Generate only the NullableExpectation variant.\n";
            echo "  --keys      Generate only the KeysIteratingExpectation variant.\n";
            echo "  --values    Generate only the ValuesIteratingExpectation variant.\n";
            echo "  --help      Display this help message.\n";

            exit(0);
        }
    }

    public function generate(): void
    {
        $options = [
            'negated' => isset($this->options['all']) || isset($this->options['negated']),
            'nullable' => isset($this->options['all']) || isset($this->options['nullable']),
            'keys' => isset($this->options['all']) || isset($this->options['keys']),
            'values' => isset($this->options['all']) || isset($this->options['values']),
        ];

        /** @var \ReflectionClass<Expectation<mixed>> $expectation */
        $expectation = new \ReflectionClass(Expectation::class);

        if ($options['negated']) {
            self::generateExpectation(
                $expectation,
                'generateNegatedConstantCode',
                'generateNegatedMethodCode',
                self::EXPECTATION_CLASS_TEMPLATE,
                self::EXPECTATION_VARIANTS['generateNegatedExpectation']['name'],
                self::EXPECTATION_VARIANTS['generateNegatedExpectation']['description'],
            );
        }

        if ($options['nullable']) {
            self::generateExpectation(
                $expectation,
                'generateNullableConstantCode',
                'generateNullableMethodCode',
                self::EXPECTATION_CLASS_TEMPLATE,
                self::EXPECTATION_VARIANTS['generateNullableExpectation']['name'],
                self::EXPECTATION_VARIANTS['generateNullableExpectation']['description'],
            );
        }

        if ($options['keys']) {
            self::generateExpectation(
                $expectation,
                'generateKeysIteratingConstantCode',
                'generateKeysIteratingMethodCode',
                self::ITERATING_EXPECTATION_CLASS_TEMPLATE,
                self::EXPECTATION_VARIANTS['generateKeysIteratingExpectation']['name'],
                self::EXPECTATION_VARIANTS['generateKeysIteratingExpectation']['description'],
                self::EXPECTATION_VARIANTS['generateKeysIteratingExpectation']['additional_properties'],
                self::EXPECTATION_VARIANTS['generateKeysIteratingExpectation']['constructor_body'],
            );
        }

        if ($options['values']) {
            self::generateExpectation(
                $expectation,
                'generateValuesIteratingConstantCode',
                'generateValuesIteratingMethodCode',
                self::ITERATING_EXPECTATION_CLASS_TEMPLATE,
                self::EXPECTATION_VARIANTS['generateValuesIteratingExpectation']['name'],
                self::EXPECTATION_VARIANTS['generateValuesIteratingExpectation']['description'],
                '',
                self::EXPECTATION_VARIANTS['generateValuesIteratingExpectation']['constructor_body'],
            );
        }
    }

    /**
     * @param \ReflectionClass<Expectation<mixed>> $expectation
     */
    private static function generateExpectation(
        \ReflectionClass $expectation,
        string $constantGenerationCode,
        string $methodGenerationCode,
        string $template,
        string $name,
        string $description,
        string $additionalProperties = '',
        string $constructorBody = '',
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

        $classCode = strtr($template, [
            '{{ CLASS_NAME }}' => $name,
            '{{ CLASS_DESCRIPTION }}' => $description,
            '{{ CLASS_CONSTANTS }}' => rtrim($constantsCode),
            '{{ CLASS_ADDITIONAL_PROPERTIES }}' => $additionalProperties,
            '{{ CLASS_CONSTRUCTOR_BODY }}' => $constructorBody,
            '{{ CLASS_METHODS }}' => rtrim($methodsCode),
        ]);

        file_put_contents(self::SRC_PATH.$name.'.php', $classCode);
    }

    private static function generateNegatedConstantCode(\ReflectionClassConstant $constant): string
    {
        return self::generateConstantCode($constant, 'negated');
    }

    private static function generateNullableConstantCode(\ReflectionClassConstant $constant): string
    {
        return self::generateConstantCode($constant, 'nullable', ['MESSAGE_IS_NULL']);
    }

    private static function generateKeysIteratingConstantCode(\ReflectionClassConstant $constant): string
    {
        return self::generateConstantCode($constant, 'keys');
    }

    private static function generateValuesIteratingConstantCode(\ReflectionClassConstant $constant): string
    {
        return self::generateConstantCode($constant, 'values');
    }

    /**
     * @param list<string> $skipConstants
     */
    private static function generateConstantCode(
        \ReflectionClassConstant $constant,
        string $replacementType,
        array $skipConstants = [],
    ): string {
        if (\in_array($constant->getName(), $skipConstants, true)) {
            return '';
        }

        $value = $constant->getValue();
        \assert(\is_string($value));

        $value = strtr($value, self::EXPECTATION_REPLACEMENTS[$replacementType]);

        return \sprintf(
            '    private const %s = %s;',
            $constant->getName(),
            var_export($value, true),
        );
    }

    private static function generateContext(string $methodName, bool $isNegated, string $valueExpression = '$this->value'): string
    {
        $contextVariables = self::NON_DEFAULT_CONTEXT[$methodName] ?? ['value', 'type'];
        $contextCodeLines = [];

        foreach ($contextVariables as $variable) {
            $isValueExported = ! str_ends_with($variable, '=');
            $isTypeExported = str_ends_with($variable, '+');
            $variableName = rtrim($variable, '=+');

            if ('type' === $variableName) {
                $exportCode = '$this->expectation->exporter->exportType('.$valueExpression.')';
            } elseif ('value' === $variableName && $isTypeExported) {
                $exportCode = '$this->expectation->exporter->exportType('.$valueExpression.')';
            } elseif ('value' === $variableName) {
                $exportCode = '$this->expectation->exporter->exportValue('.$valueExpression.')';
            } elseif ($isTypeExported) {
                $exportCode = '$this->expectation->exporter->exportType($'.$variableName.')';
            } elseif ($isValueExported) {
                $exportCode = '$this->expectation->exporter->exportValue($'.$variableName.')';
            } else {
                $exportCode = '$'.$variableName;
            }

            $contextCodeLines[$variableName] = \sprintf('\'%s\' => %s,', $variableName, $exportCode);
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

    private static function generateParamDocs(\ReflectionMethod $method): string
    {
        $docComment = $method->getDocComment();

        if (false === $docComment) {
            return '';
        }

        preg_match_all('/^\s*\*\s*(@param\s.+)$/m', $docComment, $matches);

        if ([] === $matches[1]) {
            return '';
        }

        return "\n * ".implode("\n * ", $matches[1])."\n *";
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
                 * %6$s
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
            self::generateParamDocs($method),
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
                     * %4$s
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
                self::generateParamDocs($method),
            );
        }

        return \sprintf(
            <<<'PHP'
                /**
                 * %6$s
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
            self::generateParamDocs($method),
        );
    }

    private static function generateKeysIteratingMethodCode(\ReflectionMethod $method): string
    {
        return self::generateIteratingMethodCode(
            $method,
            'as $offsetKey => $_',
            '$offsetKey',
            \in_array($method->getName(), self::KEYS_UNREACHABLE_FOR_ARRAYS, true),
        );
    }

    private static function generateValuesIteratingMethodCode(\ReflectionMethod $method): string
    {
        return self::generateIteratingMethodCode(
            $method,
            'as $offsetValue',
            '$offsetValue',
            false,
        );
    }

    private static function generateIteratingMethodCode(
        \ReflectionMethod $method,
        string $loopHead,
        string $loopVariable,
        bool $unreachableOnArray,
    ): string {
        $methodName = $method->getName();
        $constantName = 'self::MESSAGE_'.strtoupper(preg_replace('/(?<!^)[A-Z]/', '_$0', $methodName) ?? $methodName);
        [$parametersCode, $parameterCallsCode] = self::generateMethodParametersAndArguments($method);
        $contextCode = self::generateContext($methodName, false, $loopVariable);

        $guardCode = $unreachableOnArray
            ? \sprintf(
                "    if (\$this->isArray) {\n        throw new \\LogicException('Method %s() cannot be called on keys of an array; array keys are constrained to int|string.');\n    }\n\n",
                $methodName,
            )
            : '';

        return \sprintf(
            <<<'PHP'
                /**
                 * %9$s
                 * @return self<TValue>
                 */
                public function %1$s(%2$s): self
                {
                %8$s    foreach ($this->value %6$s) {
                        try {
                            Assert::that(%7$s)->%1$s(%3$s);
                        } catch (ExpectationFailedException) {
                            throw new ExpectationFailedException(
                                $message ?? %4$s,
                                %5$s,
                            );
                        }
                    }

                    return $this;
                }
                PHP,
            $methodName,
            $parametersCode,
            $parameterCallsCode,
            $constantName,
            $contextCode,
            $loopHead,
            $loopVariable,
            $guardCode,
            self::generateParamDocs($method),
        );
    }
}
