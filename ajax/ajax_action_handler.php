<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
require_once (dirname(dirname(__FILE__)) . "/app/engine/ajax_start.php");
$token = getInput("token");
if ($token != generateToken()) {
    die();
}
$action = getInput("action", null, true);
if (is_string($action)) {
    $data = getInput("data", null, false);
    if (!$data) {
        $data = [];
    }
    if (!is_array($data)) {
        $data = [
            "data" => $data
        ];
    }
    $session = getInput("session");
    if ($session) {
        $data['session'] = $session;
    } else {
        $data['session'] = NULL;
    }
    $action_class = $action . "ActionHandler";
    if (class_exists($action_class)) {
        new $action_class($data);
    }
}