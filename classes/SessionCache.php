<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class SessionCache {

    function __construct($key = false, $value = false) {
        if ($key) {
            if (!isset($_SESSION[SITESECRET])) {
                $_SESSION[SITESECRET] = [];
            }
            $session = $_SESSION[SITESECRET];
            $session[$key] = $value;
            $_SESSION[SITESECRET] = $session;
        }
    }

    static function get($key) {
        if (!isset($_SESSION[SITESECRET])) {
            $_SESSION[SITESECRET] = [];
        }
        $session = $_SESSION[SITESECRET];
        if (isset($session[$key])) {
            return $session[$key];
        }
        return;
    }

    static function clear() {
        if (isset($_SESSION[SITESECRET])) {
            unset($_SESSION[SITESECRET]);
        }
    }

    static function delete($key) {
        if (isset($_SESSION[SITESECRET][$key])) {
            unset($_SESSION[SITESECRET][$key]);
        }
    }

}
