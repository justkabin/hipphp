<?php

/**
 * @package HipPhp
 * @author  Shane Barron <admin@hipphp.com>
 */
class Image {

    static function rotateImage($filename, $degrees) {
        $image = new \Imagick($filename);
        $image->rotateImage("#000", $degrees);
        $image->writeImage($filename);
    }

    static function autorotate($image) {
        switch ($image->getImageOrientation()) {
            case \Imagick::ORIENTATION_TOPLEFT:
                break;
            case \Imagick::ORIENTATION_TOPRIGHT:
                $image->flopImage();
                break;
            case \Imagick::ORIENTATION_BOTTOMRIGHT:
                $image->rotateImage("#000", 180);
                break;
            case \Imagick::ORIENTATION_BOTTOMLEFT:
                $image->flopImage();
                $image->rotateImage("#000", 180);
                break;
            case \Imagick::ORIENTATION_LEFTTOP:
                $image->flopImage();
                $image->rotateImage("#000", -90);
                break;
            case \Imagick::ORIENTATION_RIGHTTOP:
                $image->rotateImage("#000", 90);
                break;
            case \Imagick::ORIENTATION_RIGHTBOTTOM:
                $image->flopImage();
                $image->rotateImage("#000", 90);
                break;
            case \Imagick::ORIENTATION_LEFTBOTTOM:
                $image->rotateImage("#000", -90);
                break;
            default: // Invalid orientation
                break;
        }
        $image->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);
        return $image;
    }

    static function fixImageRotation($file) {
        $image = new \Imagick($file);
        $image = self::autorotate($image);
        $image->writeImage($file);
    }

    static function copyAvatar($source_model, $target_model) {
        $icon = $source_model->icon;
        $target_model->icon = $icon;
        $target_model->save();
    }

    static function createThumbnail($guid, $width) {
        $file = getModel($guid);
        $mime_type = $file->mime_type;
        $path = $file->path;
        $filename = $file->filename;
        $owner_guid = $file->owner_guid;
        $im = imagecreatefromstring(file_get_contents($path));

        $ox = imagesx($im);
        $oy = imagesy($im);

        $nx = $width;
        $ny = floor($oy * ($width / $ox));

        $nm = imagecreatetruecolor($nx, $ny);
        imagefilledrectangle($nm, 0, 0, $nx, $ny, imagecolorallocate($nm, 255, 255, 255));
        imagecopyresampled($nm, $im, 0, 0, 0, 0, $nx, $ny, $ox, $oy);

        $thumbnail_path = getDataPath() . "files" . "/" . $guid . "/" . "thumbnail" . "/" . $width;
        if (!file_exists($thumbnail_path)) {
            makePath($thumbnail_path, 0777);
        }
        switch ($mime_type) {
            case "image/jpeg":
                imagejpeg($nm, getDataPath() . "files" . "/" . $guid . "/" . "thumbnail" . "/" . $width . "/" . $filename);
                break;
            case "image/gif":
                imagegif($nm, getDataPath() . "files" . "/" . $guid . "/" . "thumbnail" . "/" . $width . "/" . $filename);
                break;
            case "image/png":
                imagepng($nm, getDataPath() . "files" . "/" . $guid . "/" . "thumbnail" . "/" . $width . "/" . $filename);
                break;
            default:
                return false;
                break;
        }
        chmod(getDataPath() . "files" . "/" . $guid . "/" . "thumbnail" . "/" . $width . "/" . $filename, 0777);
        imagedestroy($nm);
    }

    static function getImageURL($guid, $thumbnail = NULL) {
        if (!$thumbnail) {
            $thumbnail = HUGE;
        }
        return getSiteURL() . "views/output/image_viewer.php?guid=$guid&amp;thumbnail=$thumbnail";
    }

}
