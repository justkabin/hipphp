<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class NewPasswordActionHandler {

    public function __construct() {
        $password = getInput("password");
        $password2 = getInput("password2");
        if ($password != $password2) {
            new SystemMessage("Passwords must match.");
        }
        $guid = getInput("guid");
        $code = getInput("code");
        $access = getIgnoreAccess();
        setIgnoreAccess();
        $user = getModel($guid);
        if ($user) {
            if ($user->password_reset_code == $code) {
                $user->password = md5($password);
                $user->password_reset_code = NULL;
                $user->save();
                new SystemMessage("Your password has been reset.");
                forward();
            }
        } else {
            new SystemMessage("No user found with that email.");
            forward();
        }
        setIgnoreAccess($access);
    }

}
