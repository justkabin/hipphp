<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class UpdateMenuOrderActionHandler {

    function __construct($data) {
        $order = $data['order'];
        $x = 0;
        Cache::clear();
        foreach ($order as $string) {
            $guid = str_replace("guid_", "", $string);
            $menuitem = getModel($guid);
            $menuitem->weight = $x;
            $menuitem->save();
            $x = $x + 1;
        }
    }

}
