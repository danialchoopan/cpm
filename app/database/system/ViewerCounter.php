<?php


namespace App\database\system;


use App\database\DatabaseConnection;

class ViewerCounter extends DatabaseConnection
{

    /**
     * ViewerCounter constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (php_sapi_name() === 'cli') return;

        if ($this->dose_this_ip_visit()) {
            $this->add_count_view();
        } else {
            $this->add_ip();
        }
    }


    private function add_count_view()
    {
        $sql = "UPDATE `website_views` SET `count_of_visit`=`count_of_visit`+1 WHERE `ip`=?";
        $db = $this->databaseConnection->prepare($sql);
        return $db->execute([$_SERVER['REMOTE_ADDR']]);
    }

    private function dose_this_ip_visit()
    {
        $sql = "SELECT * FROM `website_views` WHERE `ip`=?";
        $db = $this->databaseConnection->prepare($sql);
        if ($db->execute([$_SERVER['REMOTE_ADDR']])) {
            $row = $db->fetch();
            return $row ? true : false;
        } else {
            return false;
        }
    }

    private function add_ip()
    {
        $sql = "INSERT INTO `website_views`(`ip`, `created_at`) VALUES (?,?)";
        $db = $this->databaseConnection->prepare($sql);
        return $db->execute([$_SERVER['REMOTE_ADDR'] ?? '127.0.0.1', time()]);
    }
}