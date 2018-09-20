<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class LogoutActionHandler {

    public function __construct() {
        runHook("action:logout:before");

        $user = getLoggedInUser();
        if ($user) {
            $user->logout();
        }
        runHook("action:logout:after");
        new SystemMessage(translate("system_message:logged_out", "success"));
        forward("login");
    }

}
