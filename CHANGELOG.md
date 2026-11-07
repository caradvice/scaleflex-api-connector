# Changelog

All notable changes to this package are documented here. The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the package uses [Semantic Versioning](https://semver.org/).

## [2.2.0] - Unreleased

### Added

- Optional HTTP timeouts: `scaleflex.connect_timeout` (default 5s, `SCALEFLEX_CONNECT_TIMEOUT`) and `scaleflex.timeout` (default 30s, `SCALEFLEX_TIMEOUT`). Set either to `0` to disable it. Apps that published `config/scaleflex.php` before this release get the defaults without republishing.

### Changed

- Allow `guzzlehttp/guzzle` ^8 and `guzzlehttp/psr7` ^3 alongside ^7.8.1 and ^2.6, so the package no longer forces Laravel 13 apps back to Guzzle 7 and Symfony HttpFoundation 7.4.
- `FileDetails` and `SearchResultFileDetails` are now plain PHP and implement `Illuminate\Contracts\Support\Arrayable`. Property names, nullability, the `$map` key mapping (e.g. `file.url.public` to `publicUrl`), `new`, `make()`, `fromArray()`, `fromJson()`, `fromObject()`, `get()`, `set()`, `merge()`, `toArray()` and `toJson()` behave as before. Values the old base class rejected with a `TypeError` because of a scalar type mismatch (e.g. `"300"` for `width`) are now coerced.
- Dev tooling: PHPStan 2, and Pest 4/5 and pest-plugin-laravel 4/5 allowed alongside the existing ranges. The lock file now resolves stable releases only.

### Removed

- `dragon-code/simple-dto` dependency (abandoned upstream), and with it `dragon-code/contracts` and `dragon-code/support`. `FileDetails::fromRequest()` and the `DragonCode\Contracts\DataTransferObject\DataTransferObject` interface went with it.

### Fixed

- PHP 8.4+ deprecation for implicitly nullable parameters in `ApiClientContract::fileUpload()`, `fileUploadAsync()`, `ApiClient` and the `FileSearchOptions` constructor. Signatures, order and defaults are unchanged.
- Facade `@method` docblocks referenced a non-existent `FileUploadResponse` class.
