<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class InsertFileRouter extends Router {

    public function __construct($data) {
        $guid = $data['guid'];
        $file = getModel($guid);
        $mime = $file->mime_type;
        switch ($mime) {
            case "image/jpeg":
            case "image/png":
            case "image/gif":
                $this->html = "<img alt='$file->title' src='" . Image::getImageURL($guid) . "'/>";
                break;
            default:
                $image_url = getSiteURL() . "plugins/files/assets/img/file_avatar.png";
                $this->html = "<div style='width:75px;'><a href='" . getSiteURL() . $file->getURL() . "'><img src='$image_url' title='$file->title' class='img-responsive' style='width:75px;' data-title='$file->title' alt='$file->title'/></a><p class='small text-center'><center>$file->title</center></p></div>";
                break;
        }
    }

}
