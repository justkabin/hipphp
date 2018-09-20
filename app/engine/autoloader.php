<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function systemAutoLoader($className) {
    $path = SITEPATH . "classes/" . $className . ".php";
    if (file_exists($path)) {
        require_once($path);
        return true;
    }
}

function pluginAutoLoader($className) {

    if (class_exists("Plugin", false)) {
        $plugins = Plugin::getEnabledPlugins(false);
        foreach ($plugins as $plugin) {
            $name = $plugin->name;
            if (file_exists(SITEPATH . "plugins" . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . $className . ".php")) {
                require_once(SITEPATH . "plugins" . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . $className . ".php");
                return true;
            }

            if (file_exists(SITEPATH . "plugins" . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $className . ".php")) {
                require_once(SITEPATH . "plugins" . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . $className . ".php");
                return true;
            }
        }
    }
    return false;
}

spl_autoload_register("systemAutoLoader");
spl_autoload_register("pluginAutoLoader");
