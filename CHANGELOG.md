# Changelog

All notable changes to this project are documented in this file. The project follows [Semantic Versioning](https://semver.org/).

## 2.0.2

### Added

- Added support for the documented `USD` and `ZAR` currencies.

### Fixed

- Corrected sandbox and live PayEntryWeb API endpoints.
- Validated payment amounts and callback URLs before building gateway requests.
- Escaped gateway payload values and encoded query-string parameters safely.
- Applied the decline URL as the default cancellation URL consistently.

## 2.0.1

### Fixed

- Published the finalized migration with immutable source and distribution references for Packagist.

## 2.0.0

### Changed

- Moved the Composer package to `ngandu-dev/maxicash`.
- Adopted the `Ngandu\\Maxicash` PHP namespace.
- Standardized project documentation, quality commands, and continuous integration.

### Migration

- Require `ngandu-dev/maxicash` and update application imports to begin with `Ngandu\\Maxicash`.
