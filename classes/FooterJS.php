<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * Footer Javascript System
 */
class FooterJS {

    /**
     * Creates new Footer Javascript
     *
     * @param string $name      Name for the javascript
     * @param string $js        Link to javascript
     * @param type $weight      Higher numbers are called later
     * @param type $init        If true, system will call $name.init()
     */
    public function __construct($name = false, $js = false, $weight = 500, $init = false) {
        if ($name && $js) {
            $jsarray = Cache::get("footer_jsarray", "page");
            if (!isset($jsarray[$name])) {
                $jsarray[$name] = [
                    "link" => $js,
                    "weight" => $weight,
                    "init" => $init
                ];
                new Cache("footer_jsarray", $jsarray, "page");
            }
        }
    }

    static function draw() {
        $footerJSArray = Cache::get("footer_jsarray", "page");
        if (is_array($footerJSArray)) {
            $return = "\n\r";
            uasort($footerJSArray, function($a, $b) {
                return $a['weight'] - $b['weight'];
            });
            foreach ($footerJSArray as $footerJS) {
                $link = $footerJS['link'];
                $return .= "<script src='$link'></script>" . "\n\r";
            }
            return $return;
        }
        return NULL;
    }

    static function getFooterJSNameArray() {
        $return = [];
        $footerJSArray = Cache::get("footer_jsarray", "page");
        if (is_array($footerJSArray)) {
            uasort($footerJSArray, function($a, $b) {
                return $a['weight'] - $b['weight'];
            });
            foreach ($footerJSArray as $name => $footerJS) {
                if ($footerJS['init']) {
                    $return[] = $name;
                }
            }
        }
        return $return;
    }

}
