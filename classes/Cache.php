<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * Cache system
 */
class Cache {

    /**
     * Save to cache
     *
     * @param string $key       Data key
     * @param mixed $value      Value of key
     * @param string $handler   Where to store the key.  session, page, file
     */
    function __construct($key = false, $value = false, $handler = "page") {
        if ($key) {
            $cacheDriver = self::cacheHandler($handler);
            if (is_array($value)) {
                $value = serialize($value);
            }
            new $cacheDriver($key, $value);
        }
    }

    static function cacheHandler($handler = "page") {
        $cacheDriver = "PageCache";
        switch ($handler) {
            case "session":
                $cacheDriver = "SessionCache";
                break;
            case "site":
                $cacheDriver = "SiteCache";
                break;
            case "file":
                $cacheDriver = "FileCache";
                break;
        }
        return $cacheDriver;
    }

    static function set($key, $value, $handler = "page") {
        if (is_array($key)) {
            $key = bin2hex(serialize($key));
        }
        if (is_array($value)) {
            $value = serialize($value);
        }
        $cacheDriver = self::cacheHandler($handler);
        new $cacheDriver($key, $value);
        return;
    }

    static function get($key, $handler = "page") {
        if (is_array($key)) {
            $key = bin2hex(serialize($key));
        }
        $cacheDriver = self::cacheHandler($handler);
        if (class_exists($cacheDriver)) {
            $return = $cacheDriver::get($key);
            if (isSerialized($return)) {
                return unserialize($return);
            }
            return $return;
        }
    }

    /**
     * @param string $key
     */
    static function delete($key, $handler = "page") {
        if (is_array($key)) {
            $key = bin2hex(serialize($key));
        }
        $cacheDriver = self::cacheHandler($handler);
        return $cacheDriver::delete($key);
    }

    static function clear($handler = "page") {
        $setup_complete = $GLOBALS['setup_complete'];
        FileCache::clear();
        PageCache::clear();
        SessionCache::clear();
        Viewlocation::purgeAll();
        Plugin::getViews();
        setupComplete(false);
        return;
    }

}
