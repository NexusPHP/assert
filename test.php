<?php

use Nexus\Assert\Assert;
use function PHPStan\dumpType;

/**
 * @param 'bar' $value
 * @param object $class
 *
 * @return void
 */
function test_mixed(mixed $value, mixed $class): void
{
    if (method_exists($class, $value)) {
        dumpType($class);
        dumpType($value);
    }
}
