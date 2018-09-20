<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_setting($params, &$smarty) {
    $name = $params['name'];
    $value = Setting::get($name);
    return $value;
}
