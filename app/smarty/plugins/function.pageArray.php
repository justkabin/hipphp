<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_pageArray($params, &$smarty) {
    $defaults = array(
        "index" => null
    );
    $params = array_merge($defaults, $params);
    return pageArray($params['index']);
}
