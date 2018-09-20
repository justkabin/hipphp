<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class MovePluginToBottomActionHandler {

    function __construct() {
        adminGateKeeper();
        $guid = pageArray(2);
        $plugin = getModel($guid);
        $bottom_plugin = getModel([
            "type" => "plugin",
            "order_by" => "plugin_order",
            "order_by_reverse" => true
        ]);
        if ($bottom_plugin) {
            $largest = $bottom_plugin->plugin_order;
            $plugin->plugin_order = $largest + 1;
            $plugin->save();
            setupComplete(false);
        }
        forward("admin/plugins");
    }

}
