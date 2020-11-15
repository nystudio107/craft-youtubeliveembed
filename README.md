[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nystudio107/craft-youtubeliveembed/badges/quality-score.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-youtubeliveembed/?branch=v1) [![Code Coverage](https://scrutinizer-ci.com/g/nystudio107/craft-youtubeliveembed/badges/coverage.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-youtubeliveembed/?branch=v1) [![Build Status](https://scrutinizer-ci.com/g/nystudio107/craft-youtubeliveembed/badges/build.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-youtubeliveembed/build-status/v1) [![Code Intelligence Status](https://scrutinizer-ci.com/g/nystudio107/craft-youtubeliveembed/badges/code-intelligence.svg?b=v1)](https://scrutinizer-ci.com/code-intelligence)

# YouTube Live Embed plugin for Craft CMS 3.x

This plugin allows you to embed a YouTube live stream and/or live chat on your webpage. You provide your YouTube account ID.

## Features

- Embed a livestream YouTube video in your Craft Twig template.
- Embed a livestream live chat in your Craft Twig template.
- Enable and disable the live status so you can hide or show code based on whether the livestream is live or not.
- Toggle the live status using a webhook.

_Due to changes in the YouTube live stats endpoint, you must enable the live status manually._

![Screenshot](./docs/docs/resources/img/plugin-logo.png)

## Requirements

- This plugin requires Craft CMS 3.0.0 or later and PHP 7.0+.
- This plugin requires a certain type of YouTube account. [See more in the docs](https://nystudio107.com/docs/youtubeliveembed/#using-youtube-live-embed).

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require nystudio107/craft-youtubeliveembed

3. Install the plugin via `./craft install/plugin youtubeliveembed` via the CLI, or in the Control Panel, go to Settings → Plugins and click the “Install” button for YouTube Live Embed.

You can also install YouTube Live Embed via the **Plugin Store** in the Craft Control Panel.

## Documentation

Click here -> [YouTube Live Embed Documentation](https://nystudio107.com/plugins/youtube-live-embed/documentation)

## YouTube Live Embed Roadmap

Some things to do, and ideas for potential features:

* Redo the ability to trigger live mode automatically from YouTube API endpoint
* Improve webhook functionality

Brought to you by [nystudio107](https://nystudio107.com)
