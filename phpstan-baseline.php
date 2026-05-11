<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'rawMessage' => 'Doing instanceof PHPStan\\Type\\Generic\\GenericObjectType is error-prone and deprecated.',
	'identifier' => 'phpstanApi.instanceofType',
	'count' => 1,
	'path' => __DIR__ . '/src/Type/ExpectationDynamicMethodReturnTypeExtension.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Generator expects value type array{string, string, mixed}, array<mixed> given.',
	'identifier' => 'generator.valueType',
	'count' => 1,
	'path' => __DIR__ . '/tests/ExpectationTypeInferenceTest.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Parameter #1 $assertType of method Nexus\\Assert\\Tests\\ExpectationTypeInferenceTest::testFileAsserts() expects string, mixed given.',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/tests/ExpectationTypeInferenceTest.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Parameter #2 $file of method Nexus\\Assert\\Tests\\ExpectationTypeInferenceTest::testFileAsserts() expects string, mixed given.',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/tests/ExpectationTypeInferenceTest.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Property Nexus\\Assert\\Tools\\ExpectationVariantsGenerator::$options (array{all?: false, negated?: false, nullable?: false, keys?: false, values?: false, help?: false}) does not accept array<string, list<mixed>|string|false>.',
	'identifier' => 'assign.propertyType',
	'count' => 1,
	'path' => __DIR__ . '/tools/src/ExpectationVariantsGenerator.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
