<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (file_exists(dirname(__FILE__) . "/settings.php")) {
    require_once(dirname(__FILE__) . "/settings.php");
    require_once(SITEPATH . "app/engine/definitions.php");
    $classes = glob(SITEPATH . "app/classes/*.php");
    require_once(SITEPATH . "app/engine/autoloader.php");
    if (file_exists(SITEPATH . "vendor/autoload.php")) {
        require_once(SITEPATH . "vendor/autoload.php");
    }

    $lib = glob(SITEPATH . "app/lib/*.php");
    foreach ($lib as $l) {
        require_once($l);
    }
//    new Init(true);
}
