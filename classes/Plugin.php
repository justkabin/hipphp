<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Plugin extends Model {

    public $plugin_order = 0;
    public $status = "disabled";
    public $name;
    public $requires;
    public $label;
    public $access_id = "system";

    public function enabled() {
        if ($this->status == "enabled") {
            return true;
        }
        return false;
    }

    public function enable() {
        $requires = (isset($this->requires) ? $this->requires : []);
        if (!empty($requires) && is_array($requires)) {
            foreach ($requires as $required) {
                $required_plugin = getModel([
                    "type" => "Plugin",
                    "wheres" => [
                        ["name", "=", $required]
                    ]
                ]);
                if ($required_plugin) {
                    if ($required_plugin->status != "enabled") {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
        $this->status = "enabled";
        $this->save();
        clearViews();
        return true;
    }

    public function disable() {
        $this->status = "disabled";
        $this->save();
    }

    static function getEnabledPlugins($reversed = false) {
        $params = [
            "type" => "Plugin",
            "wheres" => [
                ["status", "=", "enabled"]
            ],
            "order_by" => "plugin_order",
            "order_reverse" => $reversed
        ];

        $plugins = getModels($params);
        return $plugins;
    }

    static function getAll() {
        $access = getIgnoreAccess();
        setIgnoreAccess();
        $plugins = getModels([
            "type" => "Plugin"
        ]);
        setIgnoreAccess($access);
        return $plugins;
    }

    static function getViews() {
        $extensions = array(
            "tpl",
            "php"
        );
        $plugins = self::getEnabledPlugins(true);
        if ($plugins) {
            foreach ($plugins as $plugin) {
                $plugins_iterator = false;
                if (file_exists(getSitePath() . "plugins" . DIRECTORY_SEPARATOR . $plugin->name . DIRECTORY_SEPARATOR . "views")) {
                    $plugins_iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(getSitePath() . "plugins" . DIRECTORY_SEPARATOR . $plugin->name . DIRECTORY_SEPARATOR . "views"));
                }
                if ($plugins_iterator) {
                    foreach ($plugins_iterator as $file) {
                        $path = $file->getRealpath();
                        foreach ($extensions as $ext) {
                            if (strpos($path, ".$ext") !== false) {
                                $path = strstr($path, 'views' . DIRECTORY_SEPARATOR);
                                $path = str_replace(".$ext", "", $path);
                                $path = str_replace("views" . DIRECTORY_SEPARATOR, "", $path);
                                $path = str_replace('\\', '/', $path);
                                if (!Viewlocation::get($path)) {
                                    new Viewlocation($path, "plugins" . DIRECTORY_SEPARATOR . $plugin->name . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $path . ".$ext");
                                }
                            }
                        }
                    }
                }
            }
        }

        $system_views_iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(getSitePath() . "views"));

        foreach ($system_views_iterator as $file) {
            $path = $file->getRealPath();
            foreach ($extensions as $ext) {
                if (strpos($path, ".$ext") !== false) {
                    $path = strstr($path, 'views' . DIRECTORY_SEPARATOR);
                    $path = str_replace(".$ext", "", $path);
                    $path = str_replace("views" . DIRECTORY_SEPARATOR, "", $path);
                    $path = str_replace('\\', '/', $path);

                    if ($path) {
                        new Viewlocation($path, "views" . DIRECTORY_SEPARATOR . str_replace("/", DIRECTORY_SEPARATOR, $path) . ".$ext");
                    }
                }
            }
        }
    }

    static function clearViews() {
        $views = getModels([
            "type" => "Viewlocation"
        ]);
        if ($views) {
            foreach ($views as $view) {
                $view->delete();
            }
        }
    }

    static function getPluginsFromFileSystem() {
        $plugins_path = [];
        $plugin_order = 0;
        $plugin_names = [];
        foreach (glob(SITEPATH . "plugins" . DIRECTORY_SEPARATOR . "*" . DIRECTORY_SEPARATOR) as $dir) {
            $plugins_path[] = $dir;
        }
        foreach ($plugins_path as $path) {
            if (file_exists($path . "manifest.json")) {
                $json = file_get_contents($path . "manifest.json");
                $manifest = json_decode($json, true);

                $plugin_name = $manifest['name'];
                $plugin_names[] = $plugin_name;
                $plugin_label = $manifest['label'];
                if (isset($manifest['description'])) {
                    $plugin_description = $manifest['description'];
                } else {
                    $plugin_description = NULL;
                }
                $plugin_requires = isset($manifest['requires']) ? $manifest['requires'] : [];

                $existing_plugin = getModel([
                    "type" => "Plugin",
                    "wheres" => [
                        ["name", "=", $plugin_name]
                    ]
                ]);
                if (!$existing_plugin) {
                    $existing_plugin = new Plugin;
                    $existing_plugin->name = $plugin_name;
                    $existing_plugin->requires = $plugin_requires;
                    $existing_plugin->label = $plugin_label;
                    $existing_plugin->plugin_order = $plugin_order;
                    $existing_plugin->description = $plugin_description;
                }
                $existing_plugin->save();
            }
            $plugin_order++;
        }
        $plugins = getModels([
            "type" => "Plugin"
        ]);
        if ($plugins) {
            foreach ($plugins as $plugin) {
                if (!in_array($plugin->name, $plugin_names)) {
                    $plugin->delete();
                }
            }
        }
        return;
    }

    static function getPluginByName($name) {
        $plugin = getModel([
            "type" => "Plugin",
            "wheres" => [
                ["name", "=", $name]
            ],
            "limit" => 1
        ]);
        return $plugin;
    }

}
