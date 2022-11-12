<?php
/**
 * YouTube Live Embed plugin for Craft CMS
 *
 * This plugin allows you to embed a YouTube live stream and/or live chat on your webpage
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2019 nystudio107
 */

namespace nystudio107\youtubeliveembed\controllers;

use craft\web\Controller;
use nystudio107\youtubeliveembed\YoutubeLiveEmbed;

/**
 * @author    nystudio107
 * @package   YoutubeLiveEmbed
 * @since     1.0.0
 */
class InfoController extends Controller
{
    // Protected Properties
    // =========================================================================

    protected $allowAnonymous = [
        'is-live',
    ];

    // Public Methods
    // =========================================================================


    /**
     * Returns whether the stream is currently live
     *
     * @return bool
     */
    public function actionIsLive(): bool
    {
        return YoutubeLiveEmbed::$plugin->embed->isLive();
    }
}
