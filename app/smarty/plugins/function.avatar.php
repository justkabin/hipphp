<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_avatar($params) {
    $defaults = array(
        "size" => MEDIUM,
        "guid" => null,
        "class" => "img-fluid"
    );
    $params = array_merge($defaults, $params);
    if ($params['guid']) {
        $object = getModel($params['guid']);
        $size = $params['size'];
        unset($params['size']);
        unset($params['guid']);
        echo "<a href='" . $object->getURL() . "'>" . $object->icon($size, $params) . "</a>";
    }
}
