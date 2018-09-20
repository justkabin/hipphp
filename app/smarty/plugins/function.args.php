<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_args($params = array(), &$smarty) {
    $params = smartyVars();
    $params['value'] = null;
    $return = arrayToArgs($params);
    echo $return;
}
