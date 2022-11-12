# YouTube Live Embed Changelog

## 1.0.9 - 2022.11.12
### Changed
* Added `allow-plugins` to `composer.json` to allow CI tests to work
* Move to using `ServicesTrait` and add getter methods for services

### Fixed
* Fixed an issue where the plugins settings were not visible

## 1.0.8 - 2020-11-14
### Added
* Support for webhook to toggle livestream status on and off.

## 1.0.7 - 2020-11-12
### Fixed
* Fixed additional regex issue with fetching the video id from the live page

## 1.0.6 - 2020-07-11
### Fixed
* Fixed regex issue with fetching the video id from the live page

## 1.0.5 - 2020-07-12
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
