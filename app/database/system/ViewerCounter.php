<?php


namespace App\database\system;


use App\database\DatabaseConnection;

class ViewerCounter
{

    private $databaseConnection;

    /**
     * ViewerCounter constructor.
     */
    public function __construct()
    {
        $this->connect_to_database();
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
            if ($db->rowCount() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }

    private function add_ip()
    {
        $sql = "INSERT INTO `website_views`(`ip`, `created_at`) VALUES (?,?)";
        $db = $this->databaseConnection->prepare($sql);
        return $db->execute([$_SERVER['REMOTE_ADDR'], time()]);
    }

    private function connect_to_database()
    {
        $this->databaseConnection = new \PDO($_ENV['DSN_PDO'], $_ENV['USERNAME_DB'], $_ENV['PASSWORD_DB']);
    }
}