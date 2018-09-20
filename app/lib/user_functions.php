<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

function addTokenToURL($url) {
    $token = generateToken();
    new Cache("token", $token);
    if (strpos($url, '?') !== false) {
        $url .= "&token=$token";
    } else {
        $url .= "?token=$token";
    }
    return $url;
}

function adminGateKeeper() {
    if (!loggedIn() || !adminLoggedIn()) {
        new SystemMessage(translate("system_message:not_allowed_to_view"));
        forward();
    }
}

function adminLoggedIn() {
    $user = getLoggedInUser();

    if (!$user) {
        return false;
    }
    if ($user->level == "admin") {
        return true;
    }
    return false;
}

function classGateKeeper($model, $class) {
    if (!is_a($model, $class, true)) {
        new SystemMessage("Class Gatekeeper Exception", "danger");
        forward();
    }
    return true;
}

function currentPage() {
    if (urlArray(0)) {
        return urlArray(0);
    } else {
        return "home";
    }
}

function drawForm($params) {
    $class = isset($params['class']) ? $params['class'] : "";
    $name = (isset($params['name']) ? $params['name'] : "");
    $action = (isset($params['action']) ? $params['action'] : "");
    $method = (isset($params['method']) ? $params['method'] : "");
    $enctype = (isset($params['enctype']) ? $params['enctype'] : "");
    $url = getSiteURL();
    $body = NULL;
    $target_page = NULL;
    if ($action || $params ['method'] == "get") {
        if (isset($params['page'])) {
            $target_page = $params['page'];
            unset($params['page']);
        }
        $form = view("forms/$name", $params);

        $token = generateToken();
        new Cache("token", $token, "session");
        if (isset($params['files']) && $params['files'] == true) {
            $params['enctype'] = "multipart/form-data";
            unset($params['files']);
        }
        unset($params['inputs']);
        if ($params['method'] != "get") {
            $body .= "<form class='$class' action='{$url}action/$action?token=$token' method='$method' enctype='$enctype'>";
        } else {
            $body .= "<form class='$class' action='{$url}$target_page?token=$token' method='$method'>";
        }
        $body .= <<<HTML
        $form
    </form>
HTML;

        return $body;
    }

    return "Form has no action.";
}

function drawPage($heading = null, $body = null, $button = null) {
    return Page::drawPage($heading, $body, $button);
}

function forward($string = false, $variables = []) {
    return Page::forward($string, $variables);
}

function gateKeeper() {
    if (adminLoggedIn()) {
        return true;
    }
    if (!loggedIn()) {
        new SystemMessage(translate("system_message:must_be_logged_in"));
        forward("login");
    }
    return true;
}

function getDataPath() {
    return SITEDATAPATH;
}

function getLoggedInUser() {
    $user_guid = loggedIn();
    if ($user_guid) {
        $logged_in_user = getModel($user_guid, true);
        return $logged_in_user;
    }
    return false;
}

function getLoggedInUserGuid() {
    return loggedIn();
}

function getModel($params) {
    if (!is_array($params) && !isSerialized($params)) {
        $type = getTypeFromGuid($params);
        if (!$type) {
            return new Model();
        }
        $statement = "SELECT * FROM `$type` WHERE `guid` = ?";
        $variables = [$params];
        $models = Dbase::run([
                    "statement" => $statement,
                    "variables" => $variables,
                    "type" => $type
        ]);
        if ($models) {
            $models = deSerializeEntities($models);
            $model = $models[0];
            if (loggedInUserCanViewModel($model)) {
                return $model;
            }
        } else {
            return false;
        }
    } else {
        $params['limit'] = 1;
        $models = getModels($params);
        $models = deSerializeEntities($models);
        if (isset($models[0])) {
            return $models[0];
        }
    }
    return false;
}

function getModels(array $params) {
    $key = serialize($params);
    if (class_exists("Cache", false)) {
        $results = Cache::get($key, "page");
        if ($results) {
            return $results;
        }
    }
    $variables = [];
    $defaults = [
        "type" => NULL,
        "wheres" => NULL,
        "wheres_operand" => "AND",
        "limit" => false,
        "count" => false,
        "order_by" => false,
        "order_by_reverse" => false,
        "offset" => false
    ];
    $params = array_merge($defaults, $params);

    if (!isset($params['type'])) {
        return [];
    }

    $type = strtolower($params['type']);

    if ($params['count']) {
        $statement = "SELECT count(*) FROM `$type`";
    } else {
        $statement = "SELECT * FROM `$type`";
    }

    if (!empty($params["wheres"])) {
        $statement .= " WHERE ";
        foreach ($params["wheres"] as $wheres) {
            $statement .= "(" . "`" . $wheres[0] . "`" . $wheres[1] . "?)";
            $variables[] = $wheres[2];
            if ($wheres != end($params["wheres"])) {
                $statement .= " " . $params['wheres_operand'] . " ";
            }
        }
    }

    if ($params['order_by']) {
        $statement .= " ORDER BY `{$params['order_by']}`";
        if ($params['order_by_reverse']) {
            $statement .= " DESC ";
        } else {
            $statement .= " ASC ";
        }
    }

    if ($params['limit']) {
        $statement .= " LIMIT " . $params['limit'];
    }
    if ($params['offset']) {
        $statement .= "," . $params['offset'];
    }

    $entities = Dbase::run([
                "type" => $type,
                "statement" => $statement,
                "variables" => $variables,
                "count" => $params['count']
    ]);

    if ($params['count']) {
        $return = $entities;
    } else {
        $return = deSerializeEntities($entities);
    }

    if (class_exists("Cache", false)) {
        Cache::set($key, $return, "page");
    }
    return $return ? $return : array();
}

function getSiteName() {
    return SITENAME;
}

function getSitePath() {
    return SITEPATH;
}

function getSiteURL() {
    return SITEURL;
}

function getSiteEmail() {
    $setting = Setting::get("site_email");
    if ($setting) {
        return $setting;
    }
    return SITEEMAIL;
}

function isAdmin($user) {
    if (!is_object($user)) {
        $user = getModel($user);
    }
    if (!is_a($user, "User")) {
        return false;
    }
    if ($user->level == "admin") {
        return true;
    }
    return false;
}

function isEnabledPlugin($name) {
    $plugin = getModel([
        "type" => "Plugin",
        "wheres" => [
            ["name", "=", $name],
            ["status", "=", "enabled"]
        ]
    ]);
    return $plugin;
}

function listModels($params) {
    $entities = getModels($params);
    if ($entities) {
        $view_type = (isset($params['view_type']) ? $params['view_type'] : "list");
        $wrapper_class = (isset($params['wrapper_class']) ? $params['wrapper_class'] : NULL);
        $item_class = (isset($params['item_class']) ? $params['item_class'] : NULL);
        $link = (isset($params['link']) ? $params['link'] : NULL);
        $size = (isset($params['size']) ? $params['size'] : MEDIUM);
        return viewModelList($entities, $view_type, $wrapper_class, $item_class, $link, $size);
    }
    return NULL;
}

function loggedIn() {
    // cookies aren't available until page refresh.  This is a workaround for the action:login:after hook to be able to
    // access the logged in user functions
    if (isset($_POST['guid']) && isset($_POST['session'])) {
        $guid = filter_input(INPUT_POST, 'guid', FILTER_UNSAFE_RAW);
        $session = filter_input(INPUT_POST, 'session', FILTER_UNSAFE_RAW);
        unset($_POST['guid']);
        unset($_POST['session']);
    } elseif (isset($_COOKIE[SITESECRET . "_guid"]) && isset($_COOKIE[SITESECRET . "_session"])) {
        $guid = filter_input(INPUT_COOKIE, SITESECRET . "_guid", FILTER_UNSAFE_RAW);
        $session = filter_input(INPUT_COOKIE, SITESECRET . "_session", FILTER_UNSAFE_RAW);
    }
    if (isset($guid) && isset($session)) {
        $user = getModel([
            "type" => "User",
            "wheres" => [
                ["guid", "=", $guid],
                ["session", "=", $session]
            ],
        ]);
        if ($user) {
            $guid = $user->guid;
            return $guid;
        }
    }
    return false;
}

function loggedInUserCanDelete($model) {
    if ($model->owner_guid) {
        if (getLoggedInUserGuid() == $model->owner_guid) {
            return true;
        }
        if (adminLoggedIn()) {
            return true;
        }
    }
    return false;
}

function loggedOut() {
    return !loggedIn();
}

function pageArray($index = null) {
    return urlArray($index);
}

function removeCSS($name) {
    $cssArray = Cache::get("css_array", "page");
    if (isset($cssArray[$name])) {
        unset($cssArray[$name]);
    }
    new Cache("css_array", $cssArray, "page");
}

function removeHeaderJS($name) {
    $headerjs = Cache::get("headerjs", "page");
    if (isset($headerjs[$name])) {
        unset($headerjs[$name]);
        new Cache("headerjs", $headerjs, "page");
        return true;
    }
    return false;
}

function removeFooterJS($name) {
    $footerjs = Cache::get("footer_jsarray", "page");
    if (isset($footerjs[$name])) {
        unset($footerjs[$name]);
        new Cache("footer_jsarray", $footerjs, "page");
        return true;
    }
    return false;
}

function removeMenuItem($name, $menu = "header_left") {
    return MenuItem::remove($name, $menu);
}

function removeViewExtension($target, $source) {
    return ViewExtension::remove($target, $source);
}

function reverseGatekeeper() {
    if (loggedIn()) {
        new SystemMessage(translate("system_message:must_be_logged_out"));
        forward("home");

        return false;
    }
    return true;
}

function runHook($hook_name, $params = NULL) {
    return Hook::run($hook_name, $params);
}

function resetTheme() {
    foreach ($GLOBALS['default_css'] as $key => $value) {
        removeCSS($key);
    }
    return;
}

function sendEmail($params) {
    if (!isset($params['html'])) {
        $params['html'] = true;
    }
    try {
        $mail = new PHPMailer(true);
        $mail->SMTPSecure = 'tls';
        $mail->From = $params['from']['email'];
        $mail->FromName = $params['from']['name'];
        $mail->addAddress($params['to']['email'], $params['to']['name']);
        $mail->Subject = $params['subject'];
        $mail->Body = $params['body'];
        $mail->isHTML($params['html']);
        $mail->send();
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

function translate($string, $args = []) {
    $language = SITELANGUAGE;
    $translation = Cache::get("translation", "session");
    if (!$translation) {
        $translation = [];
    }
    if (isset($translation[$language][$string])) {
        $string = $translation[$language][$string];
    }
    $setting = Setting::get("show_translations");
    if (!$setting) {
        $setting = "no";
    }
    if ($setting == "no") {
        if (empty($args)) {
            return $string;
        } else {
            $string = vsprintf($string, $args);
            return $string;
        }
    } else {
        return $string;
    }
}

function updateMenuItem($menu_item) {
    return MenuItem::update($menu_item);
}

function urlArray($index = null) {
    $page = null;
    if (isset($GLOBALS['page'])) {
        $page = $GLOBALS['page'];
    }
    if (!$page) {
        $page = urlString();
    }
    if (!$page) {
        $page = "home";
    }
    $GLOBALS['page'] = $page;
    $page = htmlspecialchars($page);
    $page_array = explode("/", $page);
    if (is_null($index)) {
        return $page_array;
    } else {
        if (isset($page_array[$index])) {
            return $page_array[$index];
        }
    }
    return false;
}

function view($path, $variables = [], $extend = false) {
    $variables['loggedin'] = loggedIn();
    $variables['adminloggedin'] = adminLoggedIn();
    $returnstring = NULL;
    $path = str_replace("\\", "/", $path);
    $smarty = smartyInit();
    $smarty->clearAllAssign();
    if ($extend) {
        Cache::set("beforevars", $variables, "session");
        $returnstring .= ViewExtension::view($path, "before", $variables);
        $variables = Cache::get("beforevars", "session");
    }
    $smarty->clearAllAssign();
    if (!empty($variables)) {
        foreach ($variables as $key => $value) {
            $smarty->assign($key, $value);
        }
    }
    $smarty->assign("extend", $extend);
    $view_path = Viewlocation::get($path);
    if ($view_path) {
//            $returnstring .= <<<HTML
//<!-- Start View $view_path -->
//HTML;
        if (strpos($view_path, 'php') !== false) {
            if (is_readable($view_path) && $path) {
                ob_start();
                include_once($view_path);
                $returnstring .= ob_get_clean();
            }
        } else {
            $returnstring .= $smarty->fetch(SITEPATH . $view_path);
        }
//            $returnstring .= <<<HTML
//<!-- End View $view_path -->
//HTML;
    }
    $smarty->clearAllAssign();
    if ($extend) {
        $returnstring .= ViewExtension::view($path, "after", $variables);
    }
    return $returnstring;
}

function viewModel($model) {
    if (!is_object($model)) {
        $model = getModel($model);
    }
    return $model->view();
}

function viewModelList($entities, $view_type = "list", $wrapper_class = "row", $item_class = NULL, $link = true, $size = "medium") {
    $current_model = 0;
    $return = NULL;
    if (!empty($entities)) {
        if ($wrapper_class) {
            $return .= "<div class='$wrapper_class '>";
        }
        foreach ($entities as $model) {
            $owner = NULL;
            if ($model->owner_guid) {
                $owner = getModel($model->owner_guid);
            }
            $return .= view("model/" . ucfirst($model->type), [
                "model" => $model,
                "owner" => $owner,
                "ownerurl" => $owner ? $owner->getURL() : ""
            ]);
            $current_model++;
        }
        if ($wrapper_class) {
            $return .= "</div>";
        }
        return $return;
    }
    return false;
}
