<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Security {

    static function getAdminGuidArray() {
        $admin_array = [];
        $admins = getModels([
            "type" => "User",
            "wheres" => [
                ["level", "=", "admin"]
            ],
        ]);
        foreach ($admins as $admin) {
            $admin_array[] = $admin->guid;
        }
        return $admin_array;
    }

    static function checkForEmptyFields($fieldnames = []) {

        $failure = false;
        foreach ($fieldnames as $fieldname) {
            $test = getInput($fieldname);
            if (!$test) {
                $failure = true;
                new SystemMessage($fieldname . " can't be left empty");
            }
        }
        if ($failure) {
            forward();
        }
    }

    static function checkForEmptyFileField($fieldname) {
        if (!isset($_FILES[$fieldname]['name'])) {
            new SystemMessage("File field cannot be left empty")

            ;
            forward();
        }
    }

}
