<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class LoggedInAccessHandler {

    public function init() {
        if (loggedIn()) {
            return true;
        }
        return false;
    }

}
