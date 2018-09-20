<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class ClearCacheRouter {

    public function view() {
        adminGateKeeper();
        Cache::clear();
        new SystemMessage("All caches have been cleared.");
        forward();
    }

}
