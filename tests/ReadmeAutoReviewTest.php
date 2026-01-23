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

use Nexus\Assert\Tools\ReadmeGenerator;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversNothing]
#[Group('auto-review')]
final class ReadmeAutoReviewTest extends TestCase
{
    public function testReadmeIsUpdated(): void
    {
        $existingReadme = file_get_contents(__DIR__.'/../README.md');
        self::assertIsString($existingReadme);

        $generatedReadme = (new ReadmeGenerator())->generate();
        self::assertSame($generatedReadme, $existingReadme, 'The README.md file is not up to date. Please run "bin/generate-readme" to update it.');
    }
}
