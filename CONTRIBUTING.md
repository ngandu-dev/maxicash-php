# Contributing

Thank you for contributing to Ngandu projects.

## Before starting

1. Search existing issues and pull requests.
2. Open an issue before beginning a large or breaking change.
3. Keep each pull request focused on one concern.

## Development

Use the runtime and package-manager versions declared by the repository. Install dependencies from the lockfile and do not commit generated build artifacts unless the repository explicitly tracks them.

TypeScript projects use the same commands:

```shell
bun install --frozen-lockfile
bun run format
bun run quality
```

PHP projects use the same commands:

```shell
composer install
composer format
composer quality
```

`format` changes files. Run it before `quality`, which performs the non-modifying checks used by continuous integration.

## Changes and tests

- Add or update tests for observable behavior changes.
- Update documentation and examples when the public API changes.
- TypeScript package changes require a Changeset.
- PHP package changes require an entry under `Unreleased` in `CHANGELOG.md`.
- Breaking changes must include migration instructions.

## Commits

Use Conventional Commits, such as `feat:`, `fix:`, `docs:`, `test:`, `refactor:`, `build:`, and `chore:`. Add `!` or a `BREAKING CHANGE:` footer when appropriate.

## Pull requests

Complete the pull request template, ensure every required check passes, and respond to review feedback with focused commits.

By participating, you agree to follow the [Code of Conduct](CODE_OF_CONDUCT.md).
