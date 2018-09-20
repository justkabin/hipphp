<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class ClearSiteCacheActionHandler {

    public function __construct() {
        adminGateKeeper();
        Cache::clear();
        Cache::clear();
        Cache::clear();
        new SystemMessage(translate("system:cache:cleaned:success:system:message"));
        forward();
    }

}
