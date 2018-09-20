<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * Hook system
 */
class Hook {

    /**
     * Create a new hook
     * @param string $hook_name     Name for the hook
     * @param string $class         Class to instantiate when hook is called.
     */
    public function __construct($hook_name = false, $class = false) {
        $hooks = Cache::get("hooks", "session");
        if (!isset($hooks[$hook_name])) {
            $hooks[$hook_name] = [];
        }
        if (!in_array($class, $hooks[$hook_name])) {
            $hooks[$hook_name][] = $class;
            new Cache("hooks", $hooks, "session");
        }
    }

    /**
     * Runs a hook
     *
     * @param string $hook_name     Name of the hook to run.
     * @param type $params          Array of paramaters to send to the hook class.
     * @return mixed                Returned from hook.
     */
    static function run($hook_name, $params = []) {
        $return = [];
        if (isset($params['return'])) {
            $return = $params['return'];
        }
        $hooks = self::getAllHooks();
        if (isset($hooks[$hook_name])) {
            $hook_array = $hooks[$hook_name];
            foreach ($hook_array as $class) {
                if (class_exists($class)) {
                    $return[] = (new $class)->start($params);
                }
            }
        }

        return $return;
    }

    static function getAllHooks() {
        return Cache::get("hooks", "session");
    }

}
