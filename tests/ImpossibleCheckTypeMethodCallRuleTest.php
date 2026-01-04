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
        $tip = 'Because the type is coming from a PHPDoc, you can turn off this check by setting <fg=cyan>treatPhpDocTypesAsCertain: false</> in your <fg=cyan>%configurationFile%</>.';

        $this->analyse([__DIR__.'/data/impossible-check/impossible-check-type-method-call.php'], [
            [
                'Call to method Nexus\\Assert\\Expectation<array<string, mixed>>::isArray() will always evaluate to true.',
                23,
                $tip,
            ],
            [
                'Call to method Nexus\\Assert\\Expectation<stdClass>::isInstanceOf() with \'stdClass\' will always evaluate to true.',
                28,
                $tip,
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
