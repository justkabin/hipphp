<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class MySettingsRouter extends Router {

    public function __construct() {
        gateKeeper();
        $this->html = view("pages/settings");
    }

}
