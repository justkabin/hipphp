<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class ForgotPasswordActionHandler {

    public function __construct() {
        $email = getInput("email");
        $access = getIgnoreAccess();
        setIgnoreAccess();
        $user = getModels([
            "type" => "User",
            "wheres" => [
                ["email", "=", $email]
            ],
            "limit" => 1
        ]);
        setIgnoreAccess($access);
        if (!empty($user)) {
            $user = $user[0];
            $user->sendPasswordResetLink();
            forward("passwordResetEmailSent");
        } else {
            new SystemMessage("No account with that email found.");
            forward();
        }
    }

}
