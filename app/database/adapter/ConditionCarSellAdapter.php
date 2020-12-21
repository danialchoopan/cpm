<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\interfaces\AdapterBasic;
use App\database\model\ConditionSellCar;
use App\database\model\DataModel;

class ConditionCarSellAdapter extends DatabaseConnection
{

    public function all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `conditions`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `conditions` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function insert(ConditionSellCar $conditionSellCar)
    {
        $now_time = time();
        $sql = "INSERT INTO `conditions`(`name`, `description`, `created_at`, `updated_at`) VALUES (?,?,?,?)";
        $db = $this->databaseConnection->prepare($sql);
        if (!$db->execute([$conditionSellCar->getName(), $conditionSellCar->getDescription(), $now_time, $now_time])) {
            return false;
        }
        $result = $this->databaseConnection->prepare("SELECT * FROM `conditions` ORDER BY `id` DESC");
        $result->execute();
        return $result->fetch(2);
    }

    public function delete($id)
    {
        $db = $this->databaseConnection->prepare("DELETE FROM `conditions` WHERE `id`=?");
        return $db->execute([$id]);
    }

    public function update(ConditionSellCar $conditionSellCar)
    {
        $now_time = time();
        $sql = "UPDATE `conditions` SET `name`=?,`description`=?,`updated_at`=? WHERE `id`=?";
        $db = $this->databaseConnection->prepare($sql);
        if (!$db->execute([$conditionSellCar->getName(), $conditionSellCar->getDescription(), $now_time, $conditionSellCar->getId()])) {
            return false;
        }
        $result = $this->databaseConnection->prepare("SELECT * FROM `conditions` ORDER BY `id` DESC");
        $result->execute();
        return $result->fetch(2);
    }
}