<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_loggedin() {
    $return = loggedIn();
    return $return;
}
