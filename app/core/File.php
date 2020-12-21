<?php


namespace App\core;


class File
{
    private $file;
    private $file_name;

    /**
     * File constructor.
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $_FILES[$file];
        $this->file_name = time() . $this->file['name'];
    }

    public function get_file_name()
    {
        return $this->file_name;
    }

    public function storeAssetsImg()
    {
        $dir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;
        return move_uploaded_file($this->file["tmp_name"], $dir . "assets\img\user_img\\" . $this->file_name);
    }

    public function is_file_img()
    {
        return getimagesize($this->file["tmp_name"]);
    }

    public function check_format_img()
    {
        $imageFileType = strtolower(pathinfo(basename($this->file['name']), PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            return false;
        } else {
            return true;
        }
    }

    public function check_file_size($size)
    {
        if ($this->file["size"] > $size) {
            return false;
        } else {
            return true;
        }
    }

    public function check_file()
    {
        if ($this->check_file_size(2048 * 1024) && $this->is_file_img() && $this->check_format_img()) {
            return true;
        } else {
            return false;
        }
    }
}