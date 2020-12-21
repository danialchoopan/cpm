<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\model\DataModel;

class PhotoAdapter extends DatabaseConnection
{

    public function all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `photo`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `photo` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function insert($name)
    {
        $now_time = time();
        $sql = "INSERT INTO `photo`(`name`, `created_at`) VALUES (?,?)";
        $db = $this->databaseConnection->prepare($sql);
        $db->execute([$name, $now_time]);
        $result = $this->databaseConnection->prepare("SELECT * FROM `photo` ORDER BY `id` DESC");
        $result->execute();
        return $result->fetch(2);
    }

    public function delete($id)
    {
        $db = $this->databaseConnection->prepare("DELETE FROM `photo` WHERE `id`=?");
        return $db->execute([$id]);
    }
}