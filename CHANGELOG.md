# YouTube Live Embed Changelog

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

## 1.0.5  2020-07-12

### Fixed
- Improved how `embed_domain` is created by making it more robust.


## 1.0.4 - 2020-07-06
### Fixed
 - Fixed issue with live chat embed cross domain issues by adding `embed_domain` URL parameter to iframe src.
 
 ## 1.0.3
 - No release

## 1.0.2 - 2019-04-04
### Added
* Switched over to a manual **Is Live** lightswitch in the CP, since YouTube removed the `live_stats` endpoint

## 1.0.1 - 2019-02-01
### Added
- Added a controller endpoint so the `is-live` and `live-viewers` can be pinged dynamically via JavaScript

## 1.0.0 - 2019-01-12
### Added
- Initial release
