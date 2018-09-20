<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class PageCache {

    function __construct($key = false, $value = false) {
        if (isset($GLOBALS['page_cache'])) {
            $page_cache = $GLOBALS['page_cache'];
        } else {
            $page_cache = [];
        }
        if ($key) {
            if (!$page_cache) {
                $page_cache = [];
            }
            $page_cache[$key] = $value;
            $GLOBALS['page_cache'] = $page_cache;
        }
    }

    static function get($key) {
        if (isset($GLOBALS['page_cache'])) {
            $page_cache = $GLOBALS['page_cache'];
            if (isset($page_cache[$key])) {
                return $page_cache[$key];
            }
        }
        return null;
    }

    static function clear() {
        $GLOBALS['page_cache'] = array();
    }

    static function delete($key) {
        $page_cache = $GLOBALS['page_cache'];
        if (isset($page_cache[$key])) {
            unset($page_cache[$key]);
            $GLOBALS['page_cache'] = $page_cache;
        }
    }

}
