<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * CSS System
 */
class CSS {

    /**
     * Adds CSS to the system
     *
     * @param string $name      Name of the CSS
     * @param string $css       Physical location of CSS file, or url
     * @param int $weight       Higher numbers load later
     */
    public function __construct($name = false, $css = false, $weight = 500) {
        $cssArray = Cache::get("css_array", "page");
        if (!$cssArray) {
            $cssArray = [];
        }
        if (!isset($cssArray[$name])) {
            $cssArray[$name] = [
                "css" => $css,
                "weight" => $weight
            ];
        }
        new Cache("css_array", $cssArray, "page");
    }

    static function sortByWeight($a, $b) {
        return $a['weight'] - $b['weight'];
    }

    static function draw($scope = "internal") {
        $cssArray = Cache::get("css_array", "page");
        usort($cssArray, array("self", "sortByWeight"));
        $return = NULL;
        if (is_array($cssArray)) {
            foreach ($cssArray as $css) {
                $return .= "<link href='" . $css['css'] . "' rel='stylesheet' media='all'>" . "\n";
            }
        }
        echo $return;
    }

    static function getAll() {
        $cssArray = Cache::get("css_array", "page");
        return $cssArray;
    }

}
