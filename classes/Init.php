<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Init {

    public function __construct($ajax = false) {
        $setup_complete = setupComplete();
        new SiteTranslation();
        self::loadDefaultMenus();
        self::loadPluginAutoloaders();
        if (!$setup_complete || DEVMODE || $ajax) {
            Plugin::getViews();
        }
        self::loadDefaultCSS();
        self::loadDefaultHeaderJS();
        self::loadDefaultFooterJS();
        self::loadPluginClasses();
        self::loadDefaultAccessHandlers();
        if (!$setup_complete || $ajax) {
            self::loadDefaultSettings();
        }
        self::handleActions();
        if (!$setup_complete || $ajax) {
            setupComplete(true);
        }
    }

    private static function loadDefaultAccessHandlers() {
        $access_handlers = Cache::get("access_handlers", "site");
        if (!$access_handlers) {
            $default_access_handlers = [
                "public",
                "private"
            ];
            foreach ($default_access_handlers as $handler) {
                new Accesshandler($handler);
            }
        }
        return;
    }

    private static function loadDefaultCSS() {
        $x = 0;
        foreach ($GLOBALS['default_css'] as $key => $value) {
            new CSS($key, SITEURL . $value, $x);
            $x = $x + 10;
        }
        return;
    }

    private static function loadDefaultHeaderJS() {
        $x = 0;
        foreach ($GLOBALS['default_header_js'] as $key => $value) {
            new HeaderJS($key, SITEURL . $value, $x);
            $x = $x + 10;
        }
        return;
    }

    private static function loadDefaultFooterJS() {
        $x = 0;
        foreach ($GLOBALS['default_footer_js'] as $key) {
            new FooterJS($key[0], SITEURL . $key[1], $x, $key[2]);
            $x = $x + 10;
        }
        new FooterJS("ionicons", "https://unpkg.com/ionicons@4.2.1/dist/ionicons.js");

        return;
    }

    private static function loadDefaultMenus() {

        new MenuItem([
            "name" => "home",
            "label" => "Home",
            "url" => "home",
            "menu" => "header_left",
            "link_class" => "nav-link",
            "list_class" => "nav-item"
        ]);

        new MenuItem([
            "name" => "my_account",
            "label" => "My Account",
            "url" => "#",
            "menu" => "header_right",
            "link_class" => "nav-link dropdown-toggle",
            "list_class" => "nav-item",
            "direction" => "right"
        ]);
        if (!loggedIn()) {
            new MenuItem([
                "name" => "login",
                "label" => "Login",
                "url" => "login",
                "menu" => "my_account",
                "link_class" => "dropdown-item"
            ]);
            new MenuItem([
                "name" => "register",
                "label" => "Register",
                "url" => "register",
                "menu" => "my_account",
                "link_class" => "dropdown-item"
            ]);
        } else {
            new MenuItem([
                "name" => "logout",
                "label" => "Logout",
                "url" => "action/logout",
                "menu" => "my_account",
                "link_class" => "dropdown-item",
                "weight" => 100000
            ]);
        }

        if (adminLoggedIn()) {
            new MenuItem([
                "name" => "admin",
                "label" => "Dashboard",
                "menu" => "my_account",
                "url" => "admin/general",
                "link_class" => "dropdown-item",
                "weight" => 1000
            ]);
            new MenuItem([
                "name" => "admin_general",
                "label" => "General",
                "menu" => "admin_sidebar",
                "url" => "admin/general",
                "link_class" => "nav-link",
                "list_class" => "nav-item",
                "weight" => 10
            ]);
            new MenuItem([
                "name" => "admin_plugins",
                "label" => "Plugins",
                "menu" => "admin_sidebar",
                "url" => "admin/plugins",
                "link_class" => "nav-link",
                "list_class" => "nav-item",
                "weight" => 20
            ]);
            new MenuItem([
                "name" => "admin_clear_cache",
                "label" => 'Clear cache',
                "title" => "Clear Cache",
                "menu" => "admin_general",
                "url" => "clearCache",
                "link_class" => "btn btn-warning confirm",
                "list_class" => "nav-item",
                "weight" => 10
            ]);
            new MenuItem([
                "name" => "header_clear_cache",
                "label" => "Clear Cache",
                "title" => "Clear Cache",
                "menu" => "header_right",
                "weight" => 1000,
                "url" => addTokenToURL("action/rescanPluginFolder"),
                "link_class" => "nav-link",
                "list_class" => "nav-item"
            ]);
            new MenuItem([
                "name" => "admin_rescan_plugins_folder",
                "label" => "Rescan folder",
                "title" => "Rescan plugins folder",
                "menu" => "admin_plugins",
                "url" => addTokenToURL("action/rescanPluginFolder"),
                "link_class" => "confirm btn btn-danger",
                "list_class" => "nav-item",
                "weight" => 60
            ]);
        }
        return;
    }

    private static function handleActions() {
        if (currentPage() == "action") {

            $ignore = [
                "logout",
                "verifyEmail"
            ];
            $action = pageArray(1);
            if ($action) {
                if (!in_array($action, $ignore)) {
                    tokenGatekeeper();
                }
                $action_class = ucfirst($action) . "ActionHandler";

                Cache::set("token", "", "session");
                if (class_exists($action_class)) {
                    new $action_class;
                } else {
                    forward();
                }
            } else {
                forward();
            }
            exit();
        }
    }

    public static function loadDefaultSettings() {
        new Setting([
            "name" => "default_access",
            "input_type" => "dropdown",
            "options" => accessHandlerDropdown()
        ]);
        new Setting([
            "name" => "debug_mode",
            "input_type" => "dropdown",
            "options" => array(
                false => "No",
                true => "Yes"
            )
        ]);
//        new Setting("wrap_views", "dropdown", [
//            "no" => "No",
//            "yes" => "Yes"
//        ]);
//        new Setting("show_translations", "dropdown", [
//            "no" => "No",
//            "yes" => "Yes"
//        ]);
//        new Setting("hide_hipphp_link", "dropdown", [
//            "no" => "No",
//            "yes" => "Yes"
//        ]);
    }

    private static function loadPluginAutoloaders() {
        $plugins = Plugin::getEnabledPlugins(false);
        if ($plugins) {
            foreach ($plugins as $plugin) {
                if (is_a($plugin, "Plugin")) {

                    $plugin_name = $plugin->name;
                    if (file_exists(SITEPATH . "plugins/$plugin_name/vendor/autoload.php")) {
                        require_once(SITEPATH . "plugins/$plugin_name/vendor/autoload.php");
                    }
                }
            }
        }
        return;
    }

    private static function loadPluginClasses() {
        $plugins = Plugin::getEnabledPlugins(false);
        if ($plugins) {
            foreach ($plugins as $plugin) {
                if (is_a($plugin, "Plugin")) {
                    $plugin_class_name = ucfirst($plugin->name) . "Plugin";
                    $translation_class_name = ucfirst($plugin->name) . "Translation";
                    if (class_exists($translation_class_name)) {
                        new $translation_class_name;
                    }
                    foreach (glob(getSitePath() . "plugins/" . $plugin->name . "/lib/*.php") as $filename) {
                        include_once($filename);
                    }
                    if (class_exists($plugin_class_name)) {
                        new $plugin_class_name;
                    }
                }
            }
        }
        return;
    }

}
