<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_function_listMenuItems($params, &$smarty) {
    $defaults = array(
        "menu" => "header_left",
        "list_class" => "nav-item",
        "element" => "li",
        "dropdown" => false
    );
    $params = array_merge($defaults, $params);
    echo MenuItem::listMenuItems($params['menu'], $params['list_class'], $params['element'], $params['dropdown']);
}
