<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class DisablePluginActionHandler {

    public function __construct() {
        if (!pageArray(2)) {
            forward();
        }

        $guid = pageArray(2);
        adminGateKeeper();
        $plugin = getModel($guid);

        classGateKeeper($plugin, "Plugin");

        $plugin->status = "disabled";

        $plugin->save();

        Cache::clear();
        Cache::clear();
        Plugin::clearViews();
        clearCache();
        Cache::clear();
        Plugin::getViews();
        new SystemMessage("Your plugin has been disabled.");
        forward();
    }

}
