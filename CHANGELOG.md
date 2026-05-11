# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v1.1.1](https://github.com/NexusPHP/assert/compare/v1.1.0...v1.1.1) - 2026-05-11

### Fixed
- Preserved `list<>`, `non-empty-list<>`, and `non-empty-array<>` shapes when narrowing through `keys()` / `values()`; previously the rebuilt iterable lost its accessory wrappers (e.g. `list<mixed>` downgraded to `array<int<0, max>, mixed>`)

## [v1.1.0](https://github.com/NexusPHP/assert/compare/v1.0.0...v1.1.0) - 2026-05-11

### Added
- `keys()` and `values()` iterating expectations to apply assertions across an iterable's keys or values
- `isBetween(float|int $min, float|int $max, bool $inclusive = true)` expectation for numeric range checks
- `isOneOf(non-empty-list<mixed> $choices)` expectation, with PHPStan narrowing to the union of literal allowed values when the list is constant
- `hasMinLength(int<1, max> $min)` and `hasMaxLength(int<1, max> $max)` expectations for bounded-string checks
- `isUrl()` expectation, backed by `filter_var($value, FILTER_VALIDATE_URL)`

### Fixed
- Improved failure-message wording for iterating expectations (`keys()`, `values()`) to clearly indicate which key or value triggered the failure

## [v1.0.0](https://github.com/NexusPHP/assert/releases/tag/v1.0.0) - 2026-03-15

### Added
- Initial release of Nexus Assert library
- Chainable type-safety assertions API
- Dynamic method return type extensions for PHPStan support
- Type inference for fluent assertions
- Support for PHP 8.2+
