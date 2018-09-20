<?php

require_once(dirname(dirname(dirname(__FILE__))) . "/app/engine/ajax_start.php");
$guid = getInput("guid");
if (!$guid) {
    $guid = Vars::get("guid");
}
$file = getModel($guid);
$thumbnail = getInput("thumbnail");
if (!$thumbnail) {
    $thumbnail = Vars::get("thumbnail");
}
if (!$thumbnail) {
    $file_location = getDataPath() . "files" . "/" . $file->guid . "/" . $file->filename;
} else {
    $file_location = getDataPath() . "files" . "/" . $file->guid . "/" . "thumbnail" . "/" . $thumbnail . "/" . $file->filename;
}

if (file_exists($file_location)) {
    $mime_type = mime_content_type($file_location);
    header('Content-Type: ' . $mime_type);

    readfile($file_location);
}

