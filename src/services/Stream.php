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

    public function setStreamStatus($yttoken)
    {
        $myPlugin = Craft::$app->plugins->getPlugin('youtubeliveembed');
        $isLive = (YoutubeLiveEmbed::$plugin->embed->isLive() ? false : true);

        if ($this->getToken() == $yttoken) {
            return Craft::$app->plugins->savePluginSettings($myPlugin, array('isLive' => $isLive));
        }
    }

    protected function getToken(): string
    {
        return YoutubeLiveEmbed::getInstance()->settings->connectionToken;
    }
}
