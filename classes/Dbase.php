<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Dbase {

    static function pdo() {
        $pdo = null;
        if (isset($GLOBALS['pdo'])) {
            $pdo = $GLOBALS['pdo'];
        }
        if (!$pdo) {
            $dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=UTF8";
            $opt = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET sql_mode="STRICT_TRANS_TABLES"'
            ];
            $pdo = new \PDO($dsn, DBUSER, DBPASS, $opt);
            $GLOBALS['pdo'] = $pdo;
        }
        $query = "CREATE TABLE IF NOT EXISTS `entities` (`guid` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, `type` VARCHAR(20), `last_updated` VARCHAR(50)) ENGINE = MyISAM;";
        $pdo->query($query);
        return $pdo;
    }

    static function close() {
        global $pdo;
        $pdo = NULL;
    }

    static function run($params) {
        $defaults = [
            "statement" => NULL,
            "variables" => [],
            "count" => false,
            "type" => NULL,
            "return" => NULL
        ];
        $params = array_merge($defaults, $params);
        try {
            $pdo = self::pdo();

            if ($params['variables']) {
                $stmt = $pdo->prepare($params['statement']);
                $stmt->execute($params['variables']);
            } else {
                $stmt = $pdo->query($params['statement']);
            }
            if ($params['count']) {
                $return = $stmt->fetchColumn();
                return $return;
            }
            if ($params['type'] && class_exists(ucfirst($params['type']))) {
                $return = $stmt->fetchAll(\PDO::FETCH_CLASS, ucfirst($params['type']));
                return $return;
            } else {
                $return = $pdo->lastInsertId();
                return $return;
            }
        } catch (\PDOException $Exception) {
            $count = 0;
            $code = $Exception->getCode();
            $message = $Exception->getMessage();
            switch ($code) {
                case "23000":
                    // Catch duplicates
                    return;
                    break;
                case "42S22":
                case "42000";
                    $field = explode("'", $message);
                    if (isset($field[1])) {
                        $field = $field[1];
                        $table = explode("`", $params['statement'])[1];
                        Dbase::run([
                            "statement" => "ALTER TABLE `$table` ADD `$field` VARCHAR(50)"
                        ]);
                        self::run($params);
                    }
                    break;
                case "22001":
                    $table = explode("`", explode("'", explode("'", $params['statement'])[0])[0])[1];
                    $field = explode("'", $message)[1];
                    Dbase::run([
                        "statement" => "ALTER TABLE `$table` MODIFY `$field` TEXT;"
                    ]);
                    self::run($params);
                    break;
                case "42S02":
                    if ($params['return'] == 'indexes') {
                        $table = $params['type'];
                    } else {
                        $array = explode("`", $params['statement']);
                        $table = $array[1];
                    }
                    Dbase::run([
                        "statement" => "CREATE TABLE IF NOT EXISTS `$table` (`guid` INT(12) UNSIGNED PRIMARY KEY,`last_updated` VARCHAR(20)) ENGINE = MyISAM;"
                    ]);
                    self::run($params);
                    break;
                case "HY000":
                default:
                    throw $Exception;
                    break;
            }
            self::close();
            return;
        }
    }

    public static function getTableArray() {
        $sql = 'SHOW TABLES';
        $query = self::pdo()->query($sql);
        return $query->fetchAll(PDO::FETCH_COLUMN);
    }

}
