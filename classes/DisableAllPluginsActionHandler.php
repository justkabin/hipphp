<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class DisableAllPluginsActionHandler {

    public function __construct() {
        adminGateKeeper();
        Cache::clear();
        Cache::clear();
        $plugins = Plugin::getAll();
        foreach ($plugins as $plugin) {
            $plugin->disable();
        }
        Admintab::deleteAll();
        clearCache();
        Cache::clear();
        Cache::clear();
        Cache::clear();
        Plugin::clearViews();

        Setting::set("setup_complete", false);
        new SystemMessage("All plugins have been disabled.");
        forward();
    }

}
