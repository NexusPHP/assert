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
    private const EXPECTATION_CLASS_TEMPLATE = <<<'PHP'
        <?php

        declare(strict_types=1);

        namespace Nexus\Assert;

        /**
         * {{CLASS_DESCRIPTION}}
         *
         * @template TValue
         *
         * @implements Expectable<TValue>
         *
         * @auto-generated
         */
        final readonly class {{CLASS_NAME}} implements Expectable
        {
            private Exporter $exporter;

            /**
             * @param Expectation<TValue> $expectation
             */
            public function __construct(
                public Expectation $expectation,
            ) {
                $this->exporter = new Exporter();
            }

            {{CLASS_METHODS}}
        }

        PHP;
    private const EXPECTATION_VARIANTS = [
        'generateNegatedExpectation' => [
            'name' => 'NegatedExpectation',
            'description' => 'An expectation that negates the original expectation.',
        ],
    ];
    private const UNSUPPORTED_METHODS = [
        'not',
    ];
    private const SRC_PATH = __DIR__.'/../../src/';

    /**
     * @var array{
     *   all?: false,
     *   negated?: false,
     *   help?: false,
     * }
     */
    private array $options;

    public function __construct()
    {
        $options = getopt('', ['all', 'negated', 'help']);
        \assert(\is_array($options));

        $this->options = $options;

        if (isset($this->options['help']) || [] === $this->options) {
            echo "Usage: \033[32mbin/generate\033[0m [--all|--negated|--help]\n\n";
            echo "\033[33mOptions:\033[0m\n";
            echo "  --all       Generate all expectation variants.\n";
            echo "  --negated   Generate only the NegatedExpectation variant.\n";
            echo "  --help      Display this help message.\n";

            exit(0);
        }
    }

    public function generate(): void
    {
        $options = [
            'negated' => isset($this->options['all']) || isset($this->options['negated']),
        ];

        /** @var \ReflectionClass<Expectation<mixed>> $expectation */
        $expectation = new \ReflectionClass(Expectation::class);

        if ($options['negated']) {
            self::generateNegatedExpectation(
                $expectation,
                self::EXPECTATION_VARIANTS['generateNegatedExpectation']['name'],
                self::EXPECTATION_VARIANTS['generateNegatedExpectation']['description'],
            );
        }
    }

    /**
     * @template T
     *
     * @param \ReflectionClass<Expectation<T>> $expectation
     */
    private static function generateNegatedExpectation(\ReflectionClass $expectation, string $name, string $description): void
    {
        $methodsCode = '';

        foreach ($expectation->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->isConstructor() || \in_array($method->getName(), self::UNSUPPORTED_METHODS, true)) {
                continue;
            }

            $methodCode = self::generateNegatedMethodCode($method);
            $methodsCode .= $methodCode."\n\n";
        }

        $classCode = str_replace(
            ['{{CLASS_NAME}}', '{{CLASS_DESCRIPTION}}', '{{CLASS_METHODS}}'],
            [$name, $description, rtrim($methodsCode)],
            self::EXPECTATION_CLASS_TEMPLATE,
        );

        file_put_contents(self::SRC_PATH.$name.'.php', $classCode);
    }

    private static function generateNegatedMethodCode(\ReflectionMethod $method): string
    {
        $methodName = $method->getName();
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

        $parametersCode = implode(', ', $parameters);
        $parameterCallsCode = implode(', ', $parameterCalls);

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
                        $message ?? 'Value "{value}" is not expected to pass the negated expectation for method "%1$s".',
                        ['value' => $this->exporter->exportValue($this->expectation->value)],
                    );
                }
                PHP,
            $methodName,
            $parametersCode,
            $parameterCallsCode,
        );
    }
}
