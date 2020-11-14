<?php
/**
 * YouTube Live Embed plugin for Craft CMS 3.x
 *
 * This plugin allows you to embed a YouTube live stream and/or live chat on your webpage
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\youtubeliveembed\services;

use nystudio107\youtubeliveembed\YoutubeLiveEmbed;
use nystudio107\youtubeliveembed\helpers\PluginTemplate;

use Craft;
use craft\base\Component;
use craft\helpers\UrlHelper;

/** @noinspection MissingPropertyAnnotationsInspection */

/**
 * @author    nystudio107
 * @package   YoutubeLiveEmbed
 * @since     1.0.0
 */
class Stream extends Component
{

    function setStreamStatus($status, $token)
    {
        if ($this->validateToken($token)) {
            return YoutubeLiveEmbed::$plugin->savePluginSettings(YoutubeLiveEmbed::$plugin, array('isLive' => $status));
        }

    }

    private function validateToken($token)
    {
        if ($plugin->getSettings('connectionToken') == $token) {
            return true;
        }
    }
}
