<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\interfaces\AdapterBasic;
use App\database\model\DataModel;

class GestAdapter extends DatabaseConnection
{
    public function all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `gest`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `gest` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function find_by_apply_id($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `gest` WHERE `apply_id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function insert($user_id, $apply_id, $each_month, $month_length)
    {
        $sql = "INSERT INTO `gest`(`user_id`, `apply_id`, `each_month`, `month_lenght`) VALUES (?,?,?,?)";
        $db = $this->databaseConnection->prepare($sql);
        if (!$db->execute([$user_id, $apply_id, $each_month, $month_length])) {
            return false;
        }
        $result = $this->databaseConnection->prepare("SELECT * FROM `gest` ORDER BY `id` DESC");
        $result->execute();
        return $result->fetch(2);
    }
}