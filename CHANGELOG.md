# YouTube Live Embed Changelog

## 4.0.2 - UNRELEASED
### Added
* Add `phpstan` and `ecs` code linting
* Add `code-analysis.yaml` GitHub action

## 4.0.1 - 2023.04.19
### Changed
* Updated the docs to use VitePress `^1.0.0-alpha.29`
* Allow for versioning of the docs

### Fixed
* Updated regex for finding video id in livestream url source ([#38](https://github.com/nystudio107/craft-youtubeliveembed/pull/38))

## 4.0.0 - 2022.11.12
### Added
* Initial Craft CMS 4 release

### Changed
* Added `allow-plugins` to `composer.json` to allow CI tests to work
* Move to using `ServicesTrait` and add getter methods for services

### Fixed
* Fixed an issue where the plugins settings were not visible

## 4.0.0-beta.1 - 2022.03.27

### Added

* Initial Craft CMS 4 compatibility
