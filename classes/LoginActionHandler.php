<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class LoginActionHandler {

    public function __construct() {
        runHook("action:login:before");
        $email = getInput("email");
        $access = getIgnoreAccess();
        $referer = getInput("referer");
        $user = getModel(
                [
                    "type" => "User",
                    "wheres" => [
                        ["email", "=", $email]
                    ]
                ]
        );

        if ($user) {
            $password = getInput("password");
            $password1 = hash('sha512', $password);
            $password2 = $user->password;
            if ($password1 == $password2) {
                if (hookExists("login:captcha")) {
                    $captcha = runHook("login:captcha");
                    if (!$captcha) {
                        new SystemMessage("Please complete the captcha challenge and try again.");
                        forward("login");
                    }
                }
                $user->logIn();
                new SystemMessage(translate("system_message:logged_in"), "success");
                runHook("action:login:after", [
                    "user" => $user
                ]);
                if ($referer) {
                    forward($referer);
                } else {
                    forward("home");
                }
            } else {
                new SystemMessage(translate("system_message:could_not_log_in"));
                forward("login");
            }
        } else {
            new SystemMessage(translate("system_message:could_not_log_in"));
            forward("login");
        }
        forward();
    }

}
