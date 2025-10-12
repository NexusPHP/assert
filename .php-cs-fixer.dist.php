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

use Nexus\CsConfig\Factory;
use Nexus\CsConfig\Ruleset\Nexus82;
use PhpCsFixer\Finder;
use PhpCsFixerCustomFixers\Fixer;
use PhpCsFixerCustomFixers\Fixers;

$finder = Finder::create()
    ->files()
    ->in([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->append([
        __FILE__,
    ])
;

$overrides = [
    'final_public_method_for_abstract_class' => false,
];

$options = [
    'cacheFile' => 'build/.php-cs-fixer.cache',
    'finder' => $finder,
    'customFixers' => new Fixers(),
    'customRules' => [
        Fixer\FunctionParameterSeparationFixer::name() => true,
        Fixer\NoCommentedOutCodeFixer::name() => true,
        Fixer\NoTrailingCommaInSinglelineFixer::name() => true,
        Fixer\NoUselessCommentFixer::name() => true,
        Fixer\NoUselessParenthesisFixer::name() => true,
        Fixer\NoUselessWriteVisibilityFixer::name() => true,
        Fixer\PhpUnitAssertArgumentsOrderFixer::name() => true,
        Fixer\PhpUnitNoUselessReturnFixer::name() => true,
        Fixer\PhpdocNoIncorrectVarAnnotationFixer::name() => true,
        Fixer\PhpdocSelfAccessorFixer::name() => true,
        Fixer\PhpdocTypesCommaSpacesFixer::name() => true,
        Fixer\PhpdocVarAnnotationToAssertFixer::name() => true,
        Fixer\PromotedConstructorPropertyFixer::name() => ['promote_only_existing_properties' => true],
    ],
];

return Factory::create(new Nexus82(), $overrides, $options)->forLibrary(
    'the Nexus Assert library',
    'John Paul E. Balandan, CPA',
    'paulbalandan@gmail.com',
    2025,
);
