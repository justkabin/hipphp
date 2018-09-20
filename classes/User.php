<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */

/**
 * User model class
 */
class User extends Model {

    public $verified = "false";
    public $profile_type = "default";
    public $access_id = "system";
    public $last_name;
    public $first_name;
    public $unique = [
        "email"
    ];
    public $full_name;

    /**
     * Returns url for user
     * @return string   User url
     */
    public function getURL() {
        return getSiteURL() . "profile/" . $this->guid;
    }

    /**
     * Sends password rest link to user
     * @return boolean  True if sent, false if not.
     */
    public function sendPasswordResetLink() {
        $this->password_reset_code = generateToken();
        $this->save();
        try {
            $mail = new \PHPMailer(true);
            $mail->From = getSiteEmail();
            $mail->FromName = getSiteName();
            $mail->addAddress($this->email);
            $mail->isHTML(true);
            $mail->Subject = view("email/forgot_password_subject");
            $mail->Body = view("email/forgot_password_body", [
                "user_guid" => $this->guid
            ]);
            $mail->From = getSiteEmail();
            $mail->FromName = getSiteName();

            $mail->isHTML(true); // Set email format to HTML

            $mail->send();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Saves a user.
     */
    public function save() {
        if (!$this->full_name) {
            $this->full_name = $this->first_name . " " . $this->last_name;
        }
        return parent::save();
    }

    /**
     * Checks if a user is online
     * @return boolean  True if online, false if not
     */
    public function online() {
        if (isset($this->session) && $this->session) {
            return true;
        }
        return false;
    }

    /**
     * Logs in a user.
     */
    public function logIn() {
        if ($this->verified != "true") {
            forward("verificationEmailSent/" . $this->guid);
        }

        $hash = bin2hex(md5(uniqid(rand(), true)));
        $this->session = $hash;
        $this->online = "true";
        $this->save();

        setcookie(SITESECRET . "_guid", $this->guid, time() + (86400), "/");
        setcookie(SITESECRET . "_session", $hash, time() + (86400), "/");
        $_POST['guid'] = $this->guid;
        $_POST['session'] = $hash;
        return $hash;
    }

    /**
     * Logs out a user.
     */
    public function logOut() {
        $this->session = NULL;
        $this->online = "false";
        $this->save();
        setcookie(SITESECRET . "_guid", NULL, time() - (86400 * 1), "/"); // 86400 = 1 day
        setcookie(SITESECRET . "_session", NULL, time() - (86400 * 1), "/"); // 86400 = 1 day
        return;
    }

    /**
     * Checks if user is logged out.
     * @return type
     */
    static function loggedOut() {
        return !loggedIn();
    }

    /**
     * Returns an array of online users
     *
     * @return array    Array of online users
     */
    static function getOnlineUsers() {
        $users = getModels([
            "type" => "User",
            "wheres" => [
                "session", "IS NOT", "NULL"
            ],
        ]);
        return $users;
    }

    /**
     * Returns the value of a setting
     *
     * @param string $name  The name of the setting.
     * @return mixed        The value of the setting.
     */
    public function getSetting($name) {
        if (isset($this->$name)) {
            return $this->$name;
        }
        $settings = Cache::get("user_settings", "session");
        if ($settings) {
            foreach ($settings as $key => $setting) {
                if ($key == $name) {
                    return $setting['default_value'];
                }
            }
        }
        return NULL;
    }

    /**
     * Checks if user is admin
     *
     * @return bool True if admin, false if not
     */
    public function isAdmin() {
        return $this->level == "admin";
    }

    public function icon($thumbnail = NULL, $params = array()) {
        if (!isset($params['alt'])) {
            $params['alt'] = $this->full_name;
        }
        if (isset($this->icon)) {
            return parent::icon($thumbnail, $params);
        }
        $args = arrayToArgs($params);
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email))) . "?s=" . $thumbnail;
        ;
        return "<img src='$grav_url' $args/>";
    }

}
