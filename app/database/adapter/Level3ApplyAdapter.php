<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\interfaces\AdapterBasic;
use App\database\model\DataModel;

class Level3ApplyAdapter extends DatabaseConnection
{

    public function all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `level3_apply`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `level3_apply` WHERE `apply_id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function insert($apply_id, $card_meli, $shanasname, $check_photo)
    {
        $sql_apply_car = "UPDATE `apply_car` SET `level`=3 WHERE `id`=?";
        $db_apply_car = $this->databaseConnection->prepare($sql_apply_car);
        if (!$db_apply_car->execute([$apply_id])) {
            return false;
        }
        $sql = "INSERT INTO `level3_apply`(`apply_id`, `card_meli`, `shenasname`, `check_paper`, `created_at`) VALUES (?,?,?,?,?)";
        $db = $this->databaseConnection->prepare($sql);
        if (!$db->execute([$apply_id, $card_meli, $shanasname, $check_photo, time()])) {
            return false;
        }
        $result = $this->databaseConnection->prepare("SELECT * FROM `level3_apply` ORDER BY `id` DESC");
        $result->execute();
        return $result->fetch(2);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function update(DataModel $class)
    {
        // TODO: Implement update() method.
    }
}