<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'rawMessage' => 'Doing instanceof PHPStan\\Type\\Generic\\GenericObjectType is error-prone and deprecated.',
	'identifier' => 'phpstanApi.instanceofType',
	'count' => 1,
	'path' => __DIR__ . '/src/Type/ExpectationDynamicMethodReturnTypeExtension.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Static property Nexus\\Assert\\Type\\ExpectationMethodResolver::$resolvers (array{hasMethod: Closure(PHPStan\\Analyser\\Scope, PhpParser\\Node\\Arg, PhpParser\\Node\\Arg): PhpParser\\Node\\Expr, isArray: Closure(PHPStan\\Analyser\\Scope, PhpParser\\Node\\Arg): PhpParser\\Node\\Expr, isBool: Closure(PHPStan\\Analyser\\Scope, PhpParser\\Node\\Arg): PhpParser\\Node\\Expr, isCallable: Closure(PHPStan\\Analyser\\Scope, PhpParser\\Node\\Arg): PhpParser\\Node\\Expr, isCountable: Closure(PHPStan\\Analyser\\Scope, PhpParser\\Node\\Arg): PhpParser\\Node\\Expr, isFalse: Closure(PHPStan\\Analyser\\Scope, PhpParser\\Node\\Arg): PhpParser\\Node\\Expr, isFloat: Closure(PHPStan\\Analyser\\Scope, PhpParser\\Node\\Arg): PhpParser\\Node\\Expr, isInstanceOf: Closure(PHPStan\\Analyser\\Scope, PhpParser\\Node\\Arg, PhpParser\\Node\\Arg): PhpParser\\Node\\Expr, ...}) does not accept default value of type array{}.',
	'identifier' => 'property.defaultValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Type/ExpectationMethodResolver.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Doing instanceof PHPStan\\Type\\Generic\\GenericObjectType is error-prone and deprecated.',
	'identifier' => 'phpstanApi.instanceofType',
	'count' => 1,
	'path' => __DIR__ . '/src/Type/ExpectationMethodTypeSpecifyingExtension.php',
];
$ignoreErrors[] = [
	'rawMessage' => 'Parameter #1 $className of class Nexus\\Assert\\Type\\ExpectationObjectType constructor expects class-string, string given.',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Type/ExpectationMethodTypeSpecifyingExtension.php',
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
	'rawMessage' => 'Property Nexus\\Assert\\Tools\\ExpectationVariantsGenerator::$options (array{all?: false, negated?: false, nullable?: false, help?: false}) does not accept array<string, list<mixed>|string|false>.',
	'identifier' => 'assign.propertyType',
	'count' => 1,
	'path' => __DIR__ . '/tools/src/ExpectationVariantsGenerator.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
