<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;

class ViewerAdapter extends DatabaseConnection
{
    public function getCountViewAllTimes()
    {
        $sql = "SELECT COUNT(*) as count FROM `website_views` ";
        $db = $this->databaseConnection->prepare($sql);
        if ($db->execute()) {
            return $db->fetch(2)['count'];
        } else {
            return false;
        }
    }

    public function get_all_views()
    {
        $sql = "SELECT * FROM `website_views` ";
        $db = $this->databaseConnection->prepare($sql);
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }
}