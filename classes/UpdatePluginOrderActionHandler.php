<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class UpdatePluginOrderActionHandler {

    public function __construct($data) {
        $order = $data['order'];
        $x = 0;
        Cache::clear();
        foreach ($order as $string) {
            $guid = str_replace("guid_", "", $string);
            $plugin = getModel($guid);
            $plugin->plugin_order = $x;
            $plugin->save();
            $x = $x + 1;
        }
        ClearClasses();
    }

}
