<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Translation {

    public function __construct($language, $new_language_array) {
        $translation = Cache::get("translation", "session");
        if (!$translation) {
            $translation = [];
        }
        foreach ($new_language_array as $key => $value) {
            $translation[$language][$key] = $value;
        }
        Cache::set("translation", $translation, "session");
    }

}
