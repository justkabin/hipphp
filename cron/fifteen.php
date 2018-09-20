<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
require_once(dirname(dirname(__FILE__)) . "/engine/start.php");

runHook("cron:fifteen");
