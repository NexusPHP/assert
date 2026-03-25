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

namespace Nexus\Assert\Tests;

use Nexus\PHPUnit\Tachycardia\Attribute\TimeLimit;
use PHPStan\Rules\Comparison\ImpossibleCheckTypeMethodCallRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;

/**
 * @extends RuleTestCase<ImpossibleCheckTypeMethodCallRule>
 *
 * @internal
 */
#[CoversNothing]
#[Group('static-analysis')]
final class ImpossibleCheckTypeMethodCallRuleTest extends RuleTestCase
{
    #[TimeLimit(2.0)]
    public function testRule(): void
    {
        $tipBuilder = static function (?string $possiblyImpureFunction): string {
            if (null === $possiblyImpureFunction) {
                return 'Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.';
            }

            return implode("\n", [
                '• Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.',
                \sprintf('• If %s is impure, add <fg=cyan>@phpstan-impure</> PHPDoc tag above its declaration. Learn more: <fg=cyan>https://phpstan.org/blog/remembering-and-forgetting-returned-values</>', $possiblyImpureFunction),
            ]);
        };

        $this->analyse([__DIR__.'/data/impossible-check/impossible-check-type-method-call.php'], [
            [
                'Call to method Nexus\\Assert\\Expectation<array<string, mixed>>::isArray() will always evaluate to true.',
                23,
                $tipBuilder(null),
            ],
            [
                'Call to method Nexus\\Assert\\Expectation<stdClass>::isInstanceOf() with \'stdClass\' will always evaluate to true.',
                28,
                $tipBuilder(null),
            ],
            [
                'Call to method Nexus\\Assert\\Expectation<stdClass>::isInstanceOf() with stdClass will always evaluate to true.',
                29,
                $tipBuilder(null),
            ],
            [
                'Call to method Nexus\\Assert\\Expectation<string>::matchesRegularExpression() with \'/^test-/\' will always evaluate to true.',
                35,
                $tipBuilder(null),
            ],
            [
                'Call to method Nexus\\Assert\\Expectation<string>::contains() with \'needle\' will always evaluate to true.',
                38,
                $tipBuilder('Nexus\\Assert\\Expectation<string>::contains()'),
            ],
            [
                'Call to method Nexus\\Assert\\Expectation<string>::endsWith() with \'world\' will always evaluate to true.',
                41,
                $tipBuilder('Nexus\\Assert\\Expectation<string>::endsWith()'),
            ],
            [
                'Call to method Nexus\\Assert\\Expectation<string>::startsWith() with \'hello\' will always evaluate to true.',
                44,
                $tipBuilder(null),
            ],
        ]);
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__.'/../extension.neon', ...parent::getAdditionalConfigFiles()];
    }

    protected function getRule(): Rule
    {
        // @phpstan-ignore phpstanApi.classConstant
        return self::getContainer()->getByType(ImpossibleCheckTypeMethodCallRule::class);
    }
}
