<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\interfaces\AdapterBasic;
use App\database\model\Car;
use App\database\model\DataModel;

class CarAdapter extends DatabaseConnection
{

    public function all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `car`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function show_cars_by_brand_id($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `car` WHERE `brand_id`=?");
        if ($db->execute([$id])) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `car` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function insert(Car $car)
    {
        $now_time = time();
        $sql = "INSERT INTO `car`(`brand_id`, `condition_id`, `photo_id`, `name`, `description`,`price`, `is_car_open_for_sell`, `created_at`, `updated_at`) VALUES (?,?,?,?,?,?,?,?,?)";
        $db = $this->databaseConnection->prepare($sql);
        if (!$db->execute([$car->getBrandId(), $car->getConditionId(), $car->getPhotoId(), $car->getName(), $car->getDescription(), $car->getPrice(), $car->getIsCarOpenForSell(), $now_time, $now_time])) {
            return false;
        }
        $result = $this->databaseConnection->prepare("SELECT * FROM `car` ORDER BY `id` DESC");
        $result->execute();
        return $result->fetch(2);
    }

    public function delete($id)
    {
        $db = $this->databaseConnection->prepare("DELETE FROM `car` WHERE `id`=?");
        return $db->execute([$id]);
    }

    public function update(Car $car)
    {
        $now_time = time();
        if ($car->getPhotoId()) {
            $sql = "UPDATE `car` SET `brand_id`=?,`condition_id`=?,`photo_id`=?,`name`=?,`description`=?,`price`=?,`is_car_open_for_sell`=?,`updated_at`=? WHERE `id`=?";
        } else {
            $sql = "UPDATE `car` SET `brand_id`=?,`condition_id`=?,`name`=?,`description`=?,`price`=?,`is_car_open_for_sell`=?,`updated_at`=? WHERE `id`=?";
        }
        $db = $this->databaseConnection->prepare($sql);
        if ($car->getPhotoId()) {
            return $db->execute([$car->getBrandId(), $car->getConditionId(), $car->getPhotoId(), $car->getName(), $car->getDescription(), $car->getPrice(), $car->getIsCarOpenForSell(), $now_time, $car->getId()]);
        } else {
            return $db->execute([$car->getBrandId(), $car->getConditionId(), $car->getName(), $car->getDescription(), $car->getPrice(), $car->getIsCarOpenForSell(), $now_time, $car->getId()]);
        }
    }
}