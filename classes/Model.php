<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * Model Layer
 */
class Model {

    public $type;
    public $owner_guid;
    public $time_created;
    public $last_updated;
    public $access_id = "system";
    public $title;
    public $description;
    public $name;
    public $icon;
    public $guid;

    /**
     * Fields for model (ie title, description)
     */
    public function fields() {
        return [];
    }

    public function canEdit() {
        return true;
    }

    public function canDelete() {
        return true;
    }

    /**
     * If true, system auto initializes all interfaces for model (add, delete, view, etc.)
     */
    public function autoInit() {
        return false;
    }

    /**
     * Determines the cache type used by the model
     */
    public function cacheType() {
        return "page";
    }

    public static function defined($model_type) {
        if (class_exists(ucfirst($model_type))) {
            return true;
        }
        return false;
    }

    public function exists($params) {
        $static = !(isset($this) && get_class($this) == __CLASS__);
        if (!$static) {
            if ($this->type) {
                $params['type'] = $this->type;
            }
        }
        $test = getModel($params);
        if ($test) {
            return true;
        }
        return false;
    }

    /**
     * Saves an model to the database.
     */
    public function save() {
        $setup_complete = $GLOBALS['setup_complete'];
        if ($setup_complete) {
            if (isset($this->system) && $this->system) {
                return true;
            }
        }
        $this->type = get_class($this);
        if (!$this->owner_guid && loggedIn()) {
            if ($this->type != "Setting") {
                $this->owner_guid = getLoggedInUserGuid();
            }
        }
        $time = time();
        $ignore = [
            "guid",
            "default_icon"
        ];
        if (!$this->access_id) {
            $default_access = Setting::get("default_access");
            if (!$default_access) {
                $default_access = "public";
            }
            $this->access_id = getInput("access_id") ? getInput("access_id") : $default_access;
        }
        $this->last_updated = $time;
        if (!$this->guid) {
            if (!$this->time_created) {
                $this->time_created = date("c", $time);
            }
            $guid = Dbase::run([
                        "statement" => "INSERT INTO `entities` (`type`) VALUES (?)",
                        "variables" => [strtolower($this->type)]
            ]);
            if ($guid == 0 || !$guid) {
                return false;
            }
            $this->guid = $guid;
        }

        $vars = get_object_vars($this);
        foreach ($vars as $key => $value) {
            if (is_string($value)) {
                $vars[$key] = preg_replace('~\r\n?~', "\n", $value);
            }
        }

        $results = Dbase::run([
                    "statement" => "SELECT * FROM `" . strtolower($this->type) . "` WHERE `guid` = ? LIMIT 1",
                    "variables" => [$this->guid],
                    "type" => $this->type
        ]);


        if (!$results) {
            Dbase::run([
                "statement" => "INSERT INTO `" . strtolower($this->type) . "` (`guid`) VALUES (?)",
                "variables" => [$this->guid]
            ]);
        }

        $query = "UPDATE `" . strtolower($this->type) . "` SET ";
        $values = [];
        foreach ($vars as $key => $value) {
            if (!in_array($key, $ignore)) {

                if (is_array($value) || is_object($value) || is_bool($value)) {
                    $value = serialize($value);
                }
                $query .= "`$key`= ?,";
                $values[] = $value;
            }
        }
        $query = rtrim($query, ",");
        $query .= " WHERE `guid` = '$this->guid'";

        Dbase::run([
            "statement" => $query,
            "variables" => $values
        ]);


        return $this->guid;
    }

    /**
     * Deletes an model from the database
     */
    public function delete($delete_owned_by = false) {
        $guid = $this->guid;
        Dbase::run([
            "statement" => "DELETE FROM `" . strtolower($this->type) . "` WHERE `guid`=?",
            "variables" => [$guid]
        ]);
        Dbase::run([
            "statement" => "DELETE FROM `entities` WHERE `guid`=?",
            "variables" => [$guid]
        ]);
        if ($delete_owned_by) {
            $tables = Dbase::getTableArray();
            foreach ($tables as $type) {
                if ($type != "entities") {
                    $models = getModels([
                        "type" => $type,
                        "wheres" => [
                            ["owner_guid", "=", $guid]
                        ]
                    ]);
                    if ($models) {
                        foreach ($models as $model) {
                            $model->delete();
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * Returns the icon (avatar) for an model
     *
     * @param integer $thumbnail    Width of image.  Full width if null
     * @param string $class         CSS class to apply to the image.
     */
    public function icon($thumbnail = NULL, $params = []) {
        $defaults = [
            "class" => "img-responsive",
            "alt" => $this->title,
            "width" => $thumbnail
        ];
        $params = array_merge($defaults, $params);
        $args = arrayToArgs($params);
        if (!$this->icon && $this->email) {
            $hash = md5(strtolower(trim($this->email)));
            return "<img $args src='https://www.gravatar.com/avatar/$hash?s=$thumbnail'/>";
        }
        if ($this->icon) {
            return "<img $args src='" . Image::getImageURL($this->icon, $thumbnail) . "'/>";
        } elseif ($this->default_icon) {
            return "<img $args src='" . getSiteURL() . $this->default_icon . "'/>";
        } else {
            return "<img $args src='" . getSiteURL() . "assets/img/avatars/icon_missing.png" . "'/>";
        }
    }

    public function view() {
        return view("model/" . $this->type, [
            "guid" => $this->guid,
            "view_type" => "model"
        ]);
    }

    /**
     * Checks if model owner is online
     *
     * @return boolean  True or false
     */
    public function ownerIsLoggedIn() {
        $user_guid = getLoggedInUserGuid();
        if ($user_guid == $this->owner_guid) {
            return true;
        }
        return false;
    }

    /**
     * Creates an avatar for an model
     *
     * @param string $filename  Name of file (in post)
     * @param bool $copy        Whether or not this is a copy.
     */
    public function createAvatar($filename = "avatar", $copy = false) {
        $file = new File;
        $file->owner_guid = $this->guid;
        $file->access_id = $this->access_id;
        $file_guid = $file->save();
        $filename = uploadFile($filename, $file_guid, [
            "png",
            "jpg",
            "jpeg",
            "gif"
                ], $copy);
        if (!$filename) {
            return;
        }
        $file = getModel($file_guid);
        $file->filename = $filename;
        $file->save();

        $this->icon = $file->guid;
        $this->save();

        Image::createThumbnail($file->guid, TINY);
        Image::createThumbnail($file->guid, SMALL);
        Image::createThumbnail($file->guid, MEDIUM);
        Image::createThumbnail($file->guid, LARGE);
        Image::createThumbnail($file->guid, EXTRALARGE);
        Image::createThumbnail($file->guid, HUGE);
    }

    /**
     * Checks if this object owner owns another object.
     *
     * @param object $object    Object to check
     * @return boolean          True or false
     */
    public static function owns($object) {
        if ($object->owner_guid == $this->guid || adminLoggedIn()) {
            return true;
        }
        return false;
    }

    /**
     *  Get the url for an model
     */
    public function getURL() {
        return false;
    }

}
