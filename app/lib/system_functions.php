<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

function clearViews() {
    $views = getModels([
        "type" => "Viewlocation"
    ]);
    if ($views) {
        foreach ($views as $view) {
            $view->delete();
        }
    }
    return;
}

function generateToken() {
    $token = Cache::get("token", "session");
    if ($token) {
        return $token;
    } else {
        $token = bin2hex(openssl_random_pseudo_bytes(20));
        new Cache("token", $token, "session");
        return $token;
    }
}

function getAccessHandler($handler) {
    $return = getModel([
        "type" => "Accesshandler",
        "wheres" => [
            ["handler", "=", $handler]
        ]
    ]);
    if ($return) {
        return $return->handler;
    }
    return false;
}

function sendVerificationEmail($user) {
    if ($user->verified == "true") {
        return false;
    }
    $user->email_verification_code = randString(70);
    $user->save();
    if (sendEmail([
                "from" => [
                    "email" => getSiteEmail(),
                    "name" => getSiteName()
                ],
                "to" => [
                    "email" => $user->email,
                    "name" => $user->first_name . " " . $user->last_name
                ], "subject" => view("email/verify_email_subject", [
                    "user_guid" => $user->guid
                ]), "body" => view("email/verify_email_body", [
                    "user_guid" => $user->guid
                ])
            ])) {
        return true;
    }
    $user->email_verification_code = NULL;
    $user->save();
    return false;
}

function setIgnoreAccess($value = true) {
    new Cache("ignore_access", $value);
}

function getIgnoreAccess() {
    $ignore_access = Cache::get("ignore_access", false);
    return $ignore_access;
}

function accessHandlerDropdown() {
    $array = [];
    $access_handlers = getModels([
        "type" => "Accesshandler"
    ]);
    if (is_array($access_handlers)) {
        foreach ($access_handlers as $handler) {
            $array[$handler->handler] = translate("access_handler:" . $handler->handler);
        }
        if (isEnabledPlugin("Groups")) {
            $groups = GroupsPlugin::getGroups(getLoggedInUserGuid());
            foreach ($groups as $group) {
                $array[$group->guid] = $group->title . " Group";
            }
        }
        return $array;
    } else {
        return [];
    }
}

function array_of_objects_sorter($a, $b) {
    if ($a->weight == $b->weight) {
        return ($a->name < $b->name) ? -1 : 1;
    }
    return ($a->weight < $b->weight) ? -1 : 1;
}

function dirIsEmpty($dir) {
    if (!file_exists($dir)) {
        return true;
    }
    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            return FALSE;
        }
    }
    return TRUE;
}

function draw() {
    $page = pageArray(0);
    if (($page != "setupcomplete") && ($page != "action") && ($page != "views") && (file_exists(getSitePath() . "install/"))) {
        forward("setupcomplete");
    }
    if ($page && is_string($page)) {
        $page_handler_class = ucfirst($page) . "Router";
    } else {
        $page_handler_class = "HomeRouter";
    }
    $ajax = getInput('ajax', "", true);
    if (class_exists($page_handler_class)) {
        $body = (new $page_handler_class)->view();
    }
    $output = view("page_elements/header");
    if (!$ajax) {
        $output .= view("page_elements/navigation");
        $output .= $body;
        $system_messages = Cache::get("system_messages", "session");
        if ($system_messages) {
            foreach ($system_messages as $system_message) {
                $type = $system_message['message_type'];
                $message = $system_message['message'];
                $output . "<script type='text/javascript'>hipphp.displayNotification(" . translate($message) . ", " . $type . ");</script>";
            }
        }
        new Cache("system_messages", NULL, "session");
        $output .= view("page_elements/footer");
    } else {
        $output .= $body;
    }
    clearVars();
    echo $output;
    Dbase::close();
}

function getTypeFromGuid($guid) {
    $query = "SELECT `type` FROM `entities` WHERE `guid` = ?";
    $stmt = Dbase::pdo()->prepare($query);
    $stmt->execute([$guid]);
    $results = $stmt->fetchAll(\PDO::FETCH_COLUMN);
    if (!empty($results)) {
        $result = $results[0];
        return $result;
    } else {
        return NULL;
    }
}

function makePath($directory) {
    $fileSystem = new Filesystem();
    $fileSystem->mkdir($directory);
    return true;
}

function pagination($params) {
    $defaults = array(
        "count" => "",
        "limit" => "",
        "url" => ""
    );
    $params = array_merge($defaults, $params);
    $count = $params['count'];
    $url = $params['url'];
    $offset = getInput("offset");
    if (!$offset) {
        $offset = 0;
    }
    if ($count && $offset && $limit && $url) {

        if (strpos($url, '?') !== false) {
            $chr = "&";
        } else {
            $chr = "?";
        }

        if ($count >= $limit) {

            $total_pages = (int) ceil($count / $limit);
            $current_page = (int) ceil($offset / $limit) + 1;

            $pages = [];

            $start_page = max(min([$current_page - 2, $total_pages - 4]), 1);

            $prev_offset = $offset - $limit;
            if ($prev_offset < 1) {
                $prev_offset = null;
            }

            $pages['prev'] = [
                'text' => "Previous",
                'href' => "{$chr}offset=" . ((int) $offset - (int) $limit)
            ];

            if ($current_page == 1) {
                $pages['prev']['disabled'] = true;
            }

            if (1 < $start_page) {
                $pages[1] = [
                    "text" => "1",
                    "href" => "{$chr}offset=0"
                ];
            }

            if (1 < ($start_page - 2)) {
                $pages[] = ['text' => '...', 'disabled' => true];
            } elseif ($start_page == 3) {
                $pages[2] = [
                    'text' => '2',
                    'href' => "{$chr}offset=" . ($limit * 2)
                ];
            }

            $max = 1;
            for ($page = $start_page; $page <= $total_pages; $page++) {
                if ($max > 20) {
                    break;
                }
                $href_offset = ((($max * (int) $limit) - ((int) $limit)) + ($start_page * $limit) - $limit);
                $href = "{$chr}offset=" . $href_offset;
                $pages[$page] = [
                    "text" => $page,
                    "href" => $href,
                    "class" => ($href_offset == $offset ? "active" : "")
                ];
                $max++;
            }

            if ($total_pages > ($start_page + 6)) {
                $pages[] = ['text' => '...', 'disabled' => true];
            } elseif (($start_page + 5) == ($total_pages - 1)) {
                $pages[$total_pages - 1] = [];
            }

            if ($total_pages >= ($start_page + 5)) {
                $pages[$total_pages] = [
                    "text" => $total_pages,
                    "href" => "{$chr}offset=" . (((int) $total_pages * (int) $limit) - (int) $limit)
                ];
            }

            $next_offset = $offset + $limit;
            if ($next_offset >= $count) {
                $next_offset--;
            }

            $pages['next'] = [
                'text' => "Next",
                'href' => "{$chr}offset=" . ($offset + $limit)
            ];

            if ($current_page == $total_pages) {
                $pages['next']['disabled'] = true;
            }
            echo "<div style='clear:both;'></div><center>";
            echo "<ul class='pagination'>";
            foreach ($pages as $page) {
                $href = (isset($page['href']) ? $page['href'] : "");
                $class = NULL;
                if (isset($page['disabled'])) {
                    $class .= "disabled";
                }
                if (isset($page['class']) && $page['class']) {
                    $class .= " " . $page['class'];
                }
                echo "<li class='$class'><a href='{$url}{$href}'>{$page['text']}</a></li>";
            }
            echo "</ul>";
            echo "</center>";
        }
    }
}

function deSerializeEntities($entities) {
    if (!empty($entities)) {
        $index = 0;
        foreach ($entities as $model) {
            $vars = get_object_vars($model);
            foreach ($vars as $key => $value) {
                if (isSerialized($value)) {
                    $entities[$index]->$key = unserialize($value);
                }
            }
            $index ++;
        }
    }
    return $entities;
}

function urlString() {
    return getInput("page");
}

function smartyInit() {
    $smarty = null;
    if (isset($GLOBALS['smarty'])) {
        $smarty = $GLOBALS['smarty'];
    }
    if (!$smarty) {
        $smarty = new \Smarty();
        $smarty->addPluginsDir(SITEPATH . 'app/smarty/plugins/')
                ->setCompileDir(SITEDATAPATH . '/templates_c');
        $smarty->error_reporting = E_ALL & ~E_NOTICE;
        $plugins = Plugin::getEnabledPlugins(false);
        if ($plugins) {
            foreach ($plugins as $plugin) {
                if (is_a($plugin, "Plugin")) {
                    if (!dirIsEmpty(SITEPATH . "plugins/" . $plugin->name . "/smarty/")) {
                        $smarty->addPluginsdir(SITEPATH . "plugins/" . $plugin->name . "/smarty/");
                    }
                }
            }
        }
    }
    $GLOBALS['smarty'] = $smarty;
    return $smarty;
}

function smartyVars() {
    $smarty = smartyInit();
    $params = $smarty->getTemplateVars();
    return $params;
}

function processImageFile($model, $filename = "avatar", $copy = false) {
    return $model->createAvatar($filename, $copy);
}

function Vars($name = false) {
    return Vars::get($name);
}

function clearVars() {
    return Vars::clear();
}

function loggedInUserCanViewModelGuid($guid, $ignore_access = false, $logged_in_user_guid = false) {
    $model = getModel($guid, true);
    return loggedInUserCanViewModel($model, $ignore_access, $logged_in_user_guid);
}

function loggedInUserCanViewModel($model = false, $ignore_access = false, $logged_in_user_guid = false) {

    if (!is_object($model)) {
        return true;
    }

    if ($model->access_id == "system") {
        return true;
    }

    if (!is_a($model, "User")) {
        if (loggedIn()) {
            $logged_in_user_guid = getLoggedInUserGuid();
        }
    }

    if (!is_object($model)) {
        return true;
    }
    if (!$model) {
        return true;
    }
    if (!$model->access_id) {
        $model->access_id = "system";
        $model->save();
    }
    if ($ignore_access) {
        return true;
    }
    if (!is_object($model)) {
        return true;
    }

    if (getIgnoreAccess()) {
        return true;
    }

    // Logged in user trying to view him/herself
    if (getLoggedInUserGuid() == $model->guid || $logged_in_user_guid == $model->guid) {
        return true;
    }

    // Logged in user owns model
    if (getLoggedInUserGuid() == $model->owner_guid || $logged_in_user_guid == $model->owner_guid) {
        return true;
    }

    // Admins can view everything
    if (adminLoggedIn()) {
        return true;
    }

    if (is_numeric($model->access_id)) {
        $access_model = getModel($model->access_id);
        if (is_a($access_model, "Group")) {
            if (isEnabledPlugin("Groups")) {
                if ($access_model->loggedInUserIsMember($logged_in_user_guid)) {
                    return true;
                }
            }
        }
        return false;
    }

    $access_handler = getAccessHandler($model->access_id);

    $access_handler = ucfirst($model->access_id) . "AccessHandler";
    $access_handler = $access_handler;
    if (class_exists($access_handler)) {
        $return = (new $access_handler)->init($model, $logged_in_user_guid);
        return $return;
    }


    return false;
}

function uploadFile($filename, $file_guid, $allowed_extensions = ["png", "jpg", "jpeg", "gif", "doc", "docx", "ods"]) {

    if (!$filename || !$file_guid) {
        return false;
    }

    $file_model = getModel($file_guid);

    $name = basename($_FILES[$filename]["name"]);
    if (!$name) {
        $file_model->delete();
        return;
    }


    $target_dir = getDataPath() . "files" . "/" . $file_guid . "/";

    makePath($target_dir, 0777);
    $name = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', $name);
    $name = preg_replace("([\.]{2,})", '', $name);
    $target_file = $target_dir . $name;

    $file_model->path = $target_file;
    $file_model->extension = pathinfo($target_file, PATHINFO_EXTENSION);
    $file_model->save();
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    if (!empty($allowed_extensions) && is_array($allowed_extensions)) {
        if (!in_array(strtolower($file_model->extension), $allowed_extensions)) {
            $file_model->delete();
            new SystemMessage("Allowed file types: " . implode(" ", $allowed_extensions));
            forward();
        }
    }
    $error = move_uploaded_file($_FILES[$filename]["tmp_name"], $target_file);
    chmod($target_file, 0777);
    $finfo = \finfo_open(FILEINFO_MIME_TYPE);
    $mime = \finfo_file($finfo, $target_file);
    \finfo_close($finfo);
    if ($mime == "image/jpeg" || $mime == "image/jpg" || $mime == "image/gif") {
        Image::fixImageRotation($target_file);
    }
    $file_model->file_location = $target_file;
    $file_model->mime_type = $mime;
    $file_model->filename = $name;
    $file_model->save();
    return $name;
}

function normalizeURL($url) {
    if (strpos($url, getSiteURL()) !== false) {
        return $url;
    }
    return getSiteURL() . $url;
}

function clearCache() {
    Cache::clear();
}

function denyDirect() {
    if (!defined("SITENAME")) {
        die();
    }
}

function hookExists($hook_name) {
    $hooks = Hook::getAllHooks();
    if (isset($hooks[$hook_name])) {
        return true;
    }
    return false;
}

function removeHook($hook_name, $class) {
    $hooks = Cache::get("hooks", "session");
    if (isset($hooks[$hook_name])) {
        foreach ($hooks[$hook_name] as $key => $hook) {
            if ($hook == $class) {
                unset($hooks[$hook_name][$key]);
                if (empty($hooks[$hook_name])) {
                    unset($hooks[$hook_name]);
                }
            }
        }
    }
    new Cache("hooks", $hooks, "session");
}

function setupComplete($value = null) {

    if (is_null($value)) {
        if (file_exists(SITEDATAPATH . "setup_complete.dat")) {
            return true;
        } else {
            return false;
        }
    } else {
        if ($value) {
            if (!setupComplete()) {
                fopen(SITEDATAPATH . "setup_complete.dat", "w");
            }
        } else {
            if (file_exists(SITEDATAPATH . "setup_complete.dat ")) {
                unlink(SITEDATAPATH . "setup_complete.dat");
            }
        }
    }

    return false;
}

function tokenGatekeeper() {
    $token = getInput("token");
    $session_token = generateToken();
    if (is_null($token) || ($token != $session_token)) {
        new SystemMessage("Token mismatch.  Try refreshing the page.");
        forward();
    }
    return;
}
