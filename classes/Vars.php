<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Vars {

    public function __construct($name = false, $value = false) {
        $vars = Cache::get("vars", "session");
        if (!$vars) {
            $vars = [];
        }
        $vars[$name] = $value;
        new Cache("vars", $vars, "session");
    }

    static function get($name = false, $default = false) {

        $vars = Cache::get("vars", "session");
        if (!$name) {
            return $vars;
        }
        if (isset($vars[$name])) {
            return $vars[$name];
        } else {
            return $default;
        }
        return $vars;
    }

    static function clear() {
        new Cache("vars", null, "session");
        return true;
    }

    static function all() {
        return Cache::get("vars", "session");
    }

}
