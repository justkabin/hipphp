<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * Header Javascript System
 */
class HeaderJS {

    /**
     * Adds javascript to the header
     * @param string $name  Name of the javascript
     * @param string $js    Path to the javascript
     * @param type $weight
     */
    public function __construct($name = false, $js = false, $weight = 500) {
        if ($name && $js) {
            $jsarray = Cache::get("headerjs", "page");
            $jsarray[$name] = [
                "link" => $js,
                "weight" => $weight
            ];
            new Cache("headerjs", $jsarray, "page");
        }
    }

    static function draw() {
        $headerJSArray = Cache::get("headerjs", "page");
        if (is_array($headerJSArray)) {
            $return = "\n\r";
            uasort($headerJSArray, function($a, $b) {
                return $a['weight'] - $b['weight'];
            });
            foreach ($headerJSArray as $headerJS) {
                $link = $headerJS['link'];
                $return .= "<script src='$link'></script>";
            }
            echo $return;
        }
        echo NULL;
    }

}
