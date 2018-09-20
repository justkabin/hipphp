<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class ForgotPasswordRouter extends Router {

    public function __construct() {
        $code = pageArray(1);
        $email = pageArray(2);

        if ($code && $email) {
            $access = getIgnoreAccess();
            setIgnoreAccess();
            $user = getModels([
                "type" => "User",
                "wheres" => [
                    ["email", "=", $email],
                    ["password_reset_code", "=", $code]
                ],
            ]);
            setIgnoreAccess($access);
            if ($user) {
                $user = $user[0];
                new Vars("guid", $user->guid);
                new Vars("code", $code);
                $form = drawForm([
                    "name" => "new_password",
                    "method" => "post",
                    "action" => "newPassword"
                ]);
                $heading = "Enter your new password.";
                $this->html = drawPage([
                    "heading" => $heading,
                    "body" => $form
                ]);
            }
        } else {
            $form = drawForm([
                "name" => "forgot_password",
                "method" => "post",
                "action" => "ForgotPassword"
            ]);
            $this->html = drawPage([
                "heading" => "Reset Your Password",
                "body" => $form
            ]);
        }
    }

}
