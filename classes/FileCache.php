<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class FileCache {

    function __construct($key = false, $value = false) {
        if ($key) {
            self::set($key, $value);
        }
    }

    static function set($key, $value) {
        $path = getDataPath() . "cache/";
        $filename = md5($key);
        if (is_array($value) || is_object($value)) {
            $value = serialize($value);
        }
        makePath($path);
        file_put_contents($path . $filename, $value);
    }

    static function get($key) {
        $path = getDataPath() . "cache/";
        $filename = md5($key);
        if (file_exists($path . $filename)) {
            $return = file_get_contents($path . $filename);
            if (isSerialized($return)) {
                $return = unserialize($return);
            }
            return $return;
        }
    }

    static function clear() {

    }

}
