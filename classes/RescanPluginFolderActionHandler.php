<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class RescanPluginFolderActionHandler {

    function __construct() {
        Plugin::getPluginsFromFileSystem();
        Cache::clear();
        new SystemMessage("Your plugin folder has been re-scanned.");
        forward();
    }

}
