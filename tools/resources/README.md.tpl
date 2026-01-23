# Nexus Assert

[![Unit Tests](https://github.com/NexusPHP/assert/actions/workflows/unit-tests.yml/badge.svg?branch=1.x)](https://github.com/NexusPHP/assert/actions/workflows/unit-tests.yml)
[![Static Code Analysis](https://github.com/NexusPHP/assert/actions/workflows/static-code-analysis.yml/badge.svg?branch=1.x)](https://github.com/NexusPHP/assert/actions/workflows/static-code-analysis.yml)

This library provides efficient type assertions for input validation in a chainable, fluent,
natural language way. This also provides static analysis support ensuring [PHPStan][1]
can understand the asserted type.

## Installation

```
composer require nexusphp/assert
```

## Installing the PHPStan extension

You're all set if you are using [phpstan/extension-installer][2].

<details>
  <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include extension.neon in your project's PHPStan config:

```
includes:
    - vendor/nexusphp/assert/extension.neon
```
</details>

## Usage

Use the static `that()` method of `Nexus\Assert\Assert` to start chaining expectations.

```php
<?php

use Nexus\Assert\Assert;

function test(mixed $a, mixed $b, mixed $c): void
{
    Assert::that($a)->isString();
    // at this point, $a is now known as string

    Assert::that($b)->isString()->isNumeric();
    // $b is now known as numeric string

    Assert::that($c)->isInt()->not()->isNegativeInt();
    // $c is understood as int<0, max>
}

```

When an expectation fails, the method call will throw a `Nexus\Assert\ExpectationFailedException` object
with the message formatted depending on the available context. By default, there are two available context:

| Name    | Description                                           |
| ------- | ----------------------------------------------------- |
| `value` | The exported value of the argument passed to `that()` |
| `type`  | The exported type of the argument passed to `that()`  |

## List of Type Expectations

{{ EXPECTATION_METHODS_TABLE }}

**NOTES:**
- The `value` context is always value-exported except when appended by `+` which means it is type-exported instead.
- The `type` context is always type-exported. In negated expectations, this context is omitted.
- Other context values are value-exported except when appended by `=` which means it is integrated as-is.

## Available Expectation Classes

`Nexus\Assert\Assert::that()` returns an instance of `Nexus\Assert\Expectation` which is the base implementation
of the `Nexus\Assert\Expectable` interface.

If you want to have a negated expectation, you can invoke `not()` on the expectation to return an instance of
`Nexus\Assert\NegatedExpectation`.
```php
<?php

use Nexus\Assert\Assert;

function test(mixed $a, mixed $b, mixed $c): void
{
    Assert::that($a)->isString();
    // at this point, $a is now known as string

    Assert::that($b)->isNumeric()->not()->isString();
    // $b is now known as either int or float
}

```

If you want to have a nullable expectation, that is, proceed with the expectation only if the input is not
`null`, then you can invoke `nullOr()` on the base expectation.
```php
<?php

use Nexus\Assert\Assert;

function test(mixed $a): void
{
    Assert::that($a)->nullOr()->isString();
    // at this point, $a is now known as string or null
}

```

> [!NOTE]
> At this point, the `not()` and `nullOr()` methods can only be invoked on the base `Expectation` object.
> It is not yet available on the variant expectations. It can be considered in future versions.

## Customising the Exporter

`Nexus\Assert\Assert` utilises the default implementation of `Nexus\Assert\ExporterInterface` - `Exporter` -
to nicely export the value and type of the asserted input. If you need to do some customisations for your
use case, you can implement your own exporter and let `Assert` use that.

```php
<?php

use App\Exporter\MyExporter;
use Nexus\Assert\Assert;

Assert::setExporter(new MyExporter());

function foo(mixed $value): void
{
    Assert::that($value)->isBool();
}

```

## Formatting the Exception Message

`ExpectationFailedException` accepts a templated message and the context when it is instantiated. You can
modify the message by passing a template message as last argument to any expectation method. The context
values are wrapped in curly braces with no in-between spaces.

```php
<?php

use Nexus\Assert\Assert;

function test(mixed $a): void
{
    $message = 'Value "{value} is not of type string'.
    Assert::that($a)->isString($message);
    // if this fails, the message would be something like:
    // Value "42" is not of type string.
}
```

## Resources

* [Report issues][3]
* [Send pull requests][4]

## License

This library is licensed under [MIT](LICENSE).

[1]: https://phpstan.org
[2]: https://github.com/phpstan/extension-installer
[3]: https://github.com/NexusPHP/assert/issues
[4]: https://github.com/NexusPHP/assert/pulls
