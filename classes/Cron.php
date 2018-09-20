<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Cron extends Model {

    public $access_id = "system";
    public $system = true;

    static function run($interval, $ignore_last_run = true) {
        $phpbin = PHP_BINDIR . "/php";
        if ($ignore_last_run) {
            shell_exec('echo $phpbin -q ' . SITEPATH . 'cron/' . $interval . '.php | at now');

            return;
        }
        $model = getModel([
            "type" => "Cron",
            "wheres" => [
                ["interval", "=", $interval]
            ]
        ]);
        if (!$model) {
            $model = new Cron;
            $model->interval = $interval;
            $model->save();
        }
        $last_ran = $model->last_ran;
        if (!$last_ran) {
            $last_ran = 0;
        }
        switch ($interval) {
            case "minute":
                $seconds = 60;
                break;
            case "five":
                $seconds = 60 * 5;
                break;
            case "fifteen":
                $seconds = 60 * 15;
                break;
            case "hour":
                $seconds = 60 * 60;
                break;
            case "week":
            default:
                $seconds = 60 * 60 * 24 * 7;
                break;
        }
        $time = time();
        if ($time > $last_ran + $seconds) {
            $shell = $phpbin . ' -q ' . SITEPATH . 'cron/' . $interval . '.php > /dev/null 2>/dev/null &';
            shell_exec($shell);
            $last_ran = $time;
            $model = getModel([
                "type" => "Cron",
                "wheres" => [
                    ["interval", "=", $interval]
                ]
            ]);
            if ($model) {
                $model->last_ran = $last_ran;
                $model->save();
            }
        }
        return;
    }

}
