<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\interfaces\AdapterBasic;
use App\database\model\ApplyCar;
use App\database\model\DataModel;

class ApplyCarAdapter extends DatabaseConnection
{

    public function all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `apply_car`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function status($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `apply_car` WHERE `status`=?");
        if ($db->execute([$id])) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `apply_car` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function insert(ApplyCar $applyCar)
    {
        $sql = "INSERT INTO `apply_car`(`user_id`, `car_id`, `condition_id`, `msg`, `n_code`, `account_number`, `created_at`) 
VALUES (?,?,?,?,?,?,?)";
        $db = $this->databaseConnection->prepare($sql);
        if (!$db->execute([$applyCar->getUserId(), $applyCar->getCarId(), $applyCar->getConditionId(), $applyCar->getMsg(),
            $applyCar->getNCode(), $applyCar->getAccountNumber(), time()])) {
            return false;
        }
        $result = $this->databaseConnection->prepare("SELECT * FROM `apply_car` ORDER BY `id` DESC");
        $result->execute();
        return $result->fetch(2);
    }

    public function delete($id)
    {
        $db = $this->databaseConnection->prepare("DELETE FROM `apply_car` WHERE `id`=?");
        return $db->execute([$id]);
    }

    public function update_status($status, $id)
    {
        switch ($status) {
            case 1:
                $sql = "UPDATE `apply_car` SET `status`=?,`level`=0 WHERE `id`=?";
                $db = $this->databaseConnection->prepare($sql);
                if (!$db->execute([$status, $id])) {
                    return false;
                }
                break;
            case 3:
                $sql = "UPDATE `apply_car` SET `status`=?,`level`=2 WHERE `id`=?";
                $db = $this->databaseConnection->prepare($sql);
                if (!$db->execute([$status, $id])) {
                    return false;
                }
                break;
            default:

                $sql = "UPDATE `apply_car` SET `status`=? WHERE `id`=?";
                $db = $this->databaseConnection->prepare($sql);
                if (!$db->execute([$status, $id])) {
                    return false;
                }
                break;
        }
        return true;
    }

    public function show_apply_car_by_user_id($user_id, $level = 3)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `apply_car` WHERE `user_id`=? AND `level`=?");
        if ($db->execute([$user_id, $level])) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function show_apply1_car_by_user_id($user_id, $level = 3)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `apply_car` WHERE `user_id`=? AND `level`=?");
        if ($db->execute([$user_id, $level])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function count_all_apply_car()
    {
        $sql = "SELECT COUNT(*) as count FROM `apply_car` ";
        $db = $this->databaseConnection->prepare($sql);
        if ($db->execute()) {
            return $db->fetch(2)['count'];
        } else {
            return false;
        }
    }
}