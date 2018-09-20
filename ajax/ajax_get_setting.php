<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
include_once(dirname(dirname(__FILE__)) . "/engine/ajax_start.php");

$name = getInput("name");
if ($name) {
    $setting = Setting::get($name);
    echo $setting;
} else {
    $names = getInput("names");
    if ($names) {
        $return = [];
        foreach ($names as $name) {
            $value = Setting::get($name);
            if ($value) {
                $return[$name] = Setting::get($name);
            }
            switch ($name) {
                case "logged_in_user_email":
                    $logged_in_user = getLoggedInUser();
                    $email = $logged_in_user->email;
                    $return[$name] = $email;
                    break;
            }
        }
        echo json_encode($return);
    }
}