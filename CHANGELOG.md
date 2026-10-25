# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.2.2] - 2026-10-25

### Changed

- GitHub Actions(deps): bump php-fast-forward/dev-tools/.github/workflows/wiki-direct.yml from c637e7f9d8ae6059b8655996e56f6d17f874792c to 84e154046e07cafa6ac09a9e12434b1ff5dcb5e0

  Update dependencies: `php-fast-forward/dev-tools/.github/workflows/wiki-direct.yml`.

  ([#11](https://github.com/php-fast-forward/http-client/pull/11), @dependabot[bot])

## [1.2.1] - 2026-10-25

### Changed

- Resolve Changelog contributor skills from stable `0.4.x` GitHub releases using
  the package's declared payload without a redundant skill allowlist.

  ([#9](https://github.com/php-fast-forward/http-client/pull/9))

- Restore the bundled consumer skill automatically from the local
  `resources/skills` source.

  ([#9](https://github.com/php-fast-forward/http-client/pull/9))

- Trust installed Fast Forward Composer skill donors through `fast-forward/*`,
  replacing implicit trust for other namespaces.

  ([#9](https://github.com/php-fast-forward/http-client/pull/9))

### Fixed

- Load the consumer autoloader for PHPDoc checks when DevTools is installed as a
  dependency.

  ([#9](https://github.com/php-fast-forward/http-client/pull/9))

- Render provider API guidance with supported reStructuredText instead of missing
  PHP domain directive templates.

  ([#9](https://github.com/php-fast-forward/http-client/pull/9))

## [1.2.0] - 2026-10-21

### Added

- Bundle the fast-forward-http-client consumer skill with executable examples, optional installation guidance and Composer discovery metadata. ([#7](https://github.com/php-fast-forward/http-client/pull/7))
- Restores the Fast Forward Container consumer skill through the existing development-only Composer skill manager, alongside the configured contributor skills, without changing runtime dependencies. ([#6](https://github.com/php-fast-forward/http-client/pull/6))

### Changed

- Automate changelog checks, version pull requests and approved releases with Fast Forward Changelog, with the project skill available to contributors. ([#6](https://github.com/php-fast-forward/http-client/pull/6))
- Synchronize the Config and Container consumer skills from the installed Composer dependencies through an explicit trusted-package list instead of independent GitHub sources. ([#6](https://github.com/php-fast-forward/http-client/pull/6))
- Require fast-forward/container ^1.10 so installed Composer dependencies supply the supported Container consumer skill alongside the runtime library. ([#6](https://github.com/php-fast-forward/http-client/pull/6))
- Restore the Changelog skill from its GitHub source during Composer installation instead of committing a generated copy and separate installation receipt. ([#6](https://github.com/php-fast-forward/http-client/pull/6))

## [1.1.0] - 2026-03-29

**Full Changelog**: https://github.com/php-fast-forward/http-client/compare/v1.0.1...v1.1.0

## [1.0.1] - 2025-08-01

Release notes are unavailable for this version.

## [1.0.0] - 2025-06-12

Release notes are unavailable for this version.

[1.2.2]: https://github.com/php-fast-forward/http-client/compare/v1.2.1...v1.2.2
[1.2.1]: https://github.com/php-fast-forward/http-client/compare/v1.2.0...v1.2.1
[1.2.0]: https://github.com/php-fast-forward/http-client/compare/v1.1.0...v1.2.0
[1.1.0]: https://github.com/php-fast-forward/http-client/compare/v1.0.1...v1.1.0
[1.0.1]: https://github.com/php-fast-forward/http-client/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/php-fast-forward/http-client/releases/tag/v1.0.0
