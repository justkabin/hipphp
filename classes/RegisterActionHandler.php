<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class RegisterActionHandler {

    public function __construct($first_name = NULL, $last_name = NULL, $email = NULL, $password = NULL, $password2 = NULL) {

        $registration_fields = [
            ["name" => "first_name"],
            ["name" => "last_name"],
            ["name" => "email"],
            ["name" => "password"],
            ["name" => "password2"]
        ];
        runHook("action:register:before");
        if (!$first_name) {
            foreach ($registration_fields as $field) {
                $name = $field['name'];
                $$name = getInput($name);
            }
        }

        if (isset($password) && isset($password2) && isset($email)) {
            if ($password != $password2) {
                new SystemMessage(translate("system_message:passwords_must_match"));
                forward("register?first_name=" . $first_name . "&last_name=" . $last_name . "&email=" . $email . "&message_type=danger");
            }
            $access = getIgnoreAccess();
            setIgnoreAccess();
            $test = getModels([
                "type" => "User",
                "wheres" => [
                    ["email", "=", $email]
                ],
                "limit" => 1
            ]);
            setIgnoreAccess($access);
            if ($test) {
                new SystemMessage(translate("system_message:email_taken"));
                forward("login");
            }

            if (hookExists("register:captcha")) {
                $captcha = runHook("register:captcha");
                if (!$captcha) {
                    new SystemMessage("Please complete the captcha challenge and try again.");
                    forward("register");
                }
            }

            $user = new User;
            foreach ($registration_fields as $field) {
                if (isset($field['name'])) {
                    $name = $field['name'];
                    $user->$name = $$name;
                }
            }
            $user->password = hash('sha512', $password);
            $user->verified = "false";

            $user->ip1 = NULL != getenv('REMOTE_ADDR') ? getenv('REMOTE_ADDR') : "";
            $user->ip2 = NULL != getenv('HTTP_X_FORWARDED_FOR') ? getenv('HTTP_X_FORWARDED_FOR') : "";
            unset($user->password2);
            $user_exists = getModels([
                "type" => "User",
                "limit" => 1
            ]);
            if (!$user_exists) {
                $user->level = "admin";
                $user->verified = "true";
                new SystemMessage("Since you are the first registered user, your account has been setup as the site administrator, and your email verified.");
                $user->save();
                $user->login();
                forward("admin");
            }

            $user->save();

            runHook("send_verification_email:before");
            $email_sent = Email::sendVerificationEmail($user);
            runHook("send_verification_email:after");
            runHook("action:register:after", ['user' => $user]);
            if ($email_sent) {
                $sitename = getSiteName();
                new SystemMessage("You have successfully registered for $sitename.  Please check your email for your verification link.");
                $referer = getInput("referer");
                if ($referer) {
                    forward($referer);
                } else {
                    forward("VerificationEmailSent/" . $user->guid);
                }
            } else {
                forward("home");
            }
        }
    }

}
