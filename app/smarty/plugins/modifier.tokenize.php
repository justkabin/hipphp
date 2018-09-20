<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
function smarty_modifier_tokenize($string) {
    return addTokenToURL($string);
}
