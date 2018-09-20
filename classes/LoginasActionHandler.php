<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class LoginasActionHandler {

    public function __construct() {
        adminGateKeeper();
        $guid = pageArray(2);
        $user = getModel($guid);
        $user->logOut();
        $user->logIn();
        new SystemMessage("You are now logged in as " . $user->full_name);
        forward();
    }

}
