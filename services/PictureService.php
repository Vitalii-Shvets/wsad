<?php


class PictureService
{
    const TYPES = ['image/gif', 'image/png', 'image/jpeg'];
    const PATH = 'uploads/image/';

    public static function canUpload($file)
    {
        if ($file['size'] == 0) {
            return 'File is too large or exist.';
        }

        if (!in_array($file['type'], self::TYPES)) {
            return 'Invalid file type.';
        }

        return true;
    }

    public static function makeUpload($file)
    {
        self::resize($file, 300, 300);
    }

    private static function resize($file, $w_dest, $h_dest)
    {
        if ($file['type'] == 'image/jpeg') {
            $source = imagecreatefromjpeg($file['tmp_name']);
        } elseif ($file['type'] == 'image/png') {
            $source = imagecreatefrompng($file['tmp_name']);
        } elseif ($file['type'] == 'image/gif') {
            $source = imagecreatefromgif($file['tmp_name']);
        } else {
            return false;
        }

        $w_src = imagesx($source);
        $h_src = imagesy($source);

        $dest = imagecreatetruecolor($w_dest, $h_dest);
        imagecopyresampled($dest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

        imagejpeg($dest, self::PATH . $file['name']);
        imagedestroy($dest);
        imagedestroy($source);

        return $file['name'];
    }
}
