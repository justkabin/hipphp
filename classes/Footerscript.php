<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * Footer Javascript System
 */
class Footerscript {

    /**
     * Creates new Footer Javascript
     *
     * @param string $name      Name for the javascript
     * @param string $js        Link to javascript
     * @param type $weight      Higher numbers are called later
     * @param type $init        If true, system will call $name.init()
     */
    public function __construct($name = false, $script = false) {
        if ($name && $script) {
            $footerscript = Cache::get("footer_script", "page");
            if (!isset($footerscript[$name])) {
                $footerscript[$name] = $script;
            }
            new Cache("footer_script", $footerscript, "page");
        }
    }

    /**
     * Removes javascript from the site footer
     *
     * @param string $name  Name of the javascript to remove
     */
    static function removeFooterJS($name) {
        $footerscript = Cache::get("footer_script", "page");
        if (isset($footerscript[$name])) {
            unset($footerscript[$name]);
            new Cache("footer_script", $footerscript, "page");
        }
    }

    static function draw() {
        $return = NULL;
        $footerscript = Cache::get("footer_script", "page");
        if (!empty($footerscript)) {
            foreach ($footerscript as $script) {
                $return .= $script;
            }
        }
        return $return;
    }

}
