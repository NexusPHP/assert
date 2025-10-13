<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'rawMessage' => 'Doing instanceof PHPStan\\Type\\Generic\\GenericObjectType is error-prone and deprecated.',
	'identifier' => 'phpstanApi.instanceofType',
	'count' => 1,
	'path' => __DIR__ . '/src/Type/ExpectationDynamicMethodReturnTypeExtension.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Doing instanceof PHPStan\\Type\\Generic\\GenericObjectType is error-prone and deprecated.',
	'identifier' => 'phpstanApi.instanceofType',
	'count' => 1,
	'path' => __DIR__ . '/src/Type/ExpectationMethodTypeSpecifyingExtension.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
