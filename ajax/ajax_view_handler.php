<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
include_once(dirname(dirname(__FILE__)) . "/app/engine/ajax_start.php");

$view = getInput("view", "", false);
$vars = getInput("vars", "", false);
$session = getInput("session", "", false);
if ($session) {
    Vars("session", $session);
}
if (is_array($vars)) {
    foreach ($vars as $key => $value) {
        new Vars($key, $value);
    }
}
echo view($view);
