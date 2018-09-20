<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * Classed used to create and store view extensions
 */
class ViewExtension {

    public function __construct($target = false, $source = false, $placement = "after") {
        if ($target && $source && $placement) {
            $exists = false;
            $extensions = self::getAll();
            foreach ($extensions as $extension) {
                if ($extension) {
                    if (($extension->target == $target) && ($extension->source == $source) && ($extension->placement == $placement)) {
                        $exists = true;
                    }
                }
            }
            if (!$exists) {
                $viewExtension = new stdClass();
                $viewExtension->target = $target;
                $viewExtension->source = $source;
                $viewExtension->weight = $weight;
                $viewExtension->placement = $placement;
                $extensions[] = $viewExtension;
                Cache::set("viewextensions", $extensions, "session");
            }
        }
    }

    static function view($path, $placement = "after", $variables = array()) {
        $return = null;
        $viewExtensions = Cache::get("viewextensions", "session");
        if (is_array($viewExtensions)) {
            foreach ($viewExtensions as $extension) {
                if (($extension->target == $path) && ($extension->placement == $placement)) {
                    $return .= view($extension->source, $variables, false);
                }
            }
        }
        return $return;
    }

    static function getAll() {
        $viewExtensions = Cache::get("viewextensions", "session");
        return $viewExtensions ? $viewExtensions : array();
    }

    static function remove($target, $source) {
        //TODO 
    }

}
