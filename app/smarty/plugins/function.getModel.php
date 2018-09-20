<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_getModel($params, &$smarty) {
    $defaults = array(
        "guid" => null
    );
    $params = array_merge($defaults, $params);
    return getModel($params['guid']);
}
