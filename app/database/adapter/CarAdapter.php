<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\interfaces\AdapterBasic;
use App\database\model\Car;
use App\database\model\DataModel;

class CarAdapter extends DatabaseConnection
{

    public function all($filters = [], $only_approved = false)
    {
        $sql = "SELECT * FROM `car` WHERE 1=1";
        $params = [];

        if ($only_approved) {
            $sql .= " AND `is_approved` = 1";
        }

        if (!empty($filters['brand_id'])) {
            $sql .= " AND `brand_id` = ?";
            $params[] = $filters['brand_id'];
        }
        if (!empty($filters['city'])) {
            $sql .= " AND `city` LIKE ?";
            $params[] = "%" . $filters['city'] . "%";
        }
        $db_type = $_ENV['DB_CONNECTION'] ?? 'mysql';
        $cast_type = ($db_type === 'sqlite') ? 'INTEGER' : 'UNSIGNED';

        if (!empty($filters['min_price'])) {
            $sql .= " AND CAST(`price` AS $cast_type) >= ?";
            $params[] = $filters['min_price'];
        }
        if (!empty($filters['max_price'])) {
            $sql .= " AND CAST(`price` AS $cast_type) <= ?";
            $params[] = $filters['max_price'];
        }
        if (!empty($filters['year'])) {
            $sql .= " AND `year` = ?";
            $params[] = $filters['year'];
        }

        $sql .= " ORDER BY `created_at` DESC";

        $db = $this->databaseConnection->prepare($sql);
        if ($db->execute($params)) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function show_cars_by_brand_id($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `car` WHERE `brand_id`=? AND `is_approved` = 1 ORDER BY `created_at` DESC");
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
        $sql = "INSERT INTO `car`(`brand_id`, `condition_id`, `photo_id`, `name`, `description`, `province`, `city`, `mileage`, `year`, `price`, `is_car_open_for_sell`, `is_approved`, `created_at`, `updated_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $db = $this->databaseConnection->prepare($sql);
        if (!$db->execute([
            $car->getBrandId(),
            $car->getConditionId(),
            $car->getPhotoId(),
            $car->getName(),
            $car->getDescription(),
            $car->getProvince(),
            $car->getCity(),
            $car->getMileage(),
            $car->getYear(),
            $car->getPrice(),
            $car->getIsCarOpenForSell(),
            $car->getIsApproved() ?? 0,
            $now_time,
            $now_time
        ])) {
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
            $sql = "UPDATE `car` SET `brand_id`=?,`condition_id`=?,`photo_id`=?,`name`=?,`description`=?, `province`=?, `city`=?, `mileage`=?, `year`=?, `price`=?,`is_car_open_for_sell`=?,`is_approved`=?,`updated_at`=? WHERE `id`=?";
        } else {
            $sql = "UPDATE `car` SET `brand_id`=?,`condition_id`=?,`name`=?,`description`=?, `province`=?, `city`=?, `mileage`=?, `year`=?, `price`=?,`is_car_open_for_sell`=?, `is_approved`=?, `updated_at`=? WHERE `id`=?";
        }
        $db = $this->databaseConnection->prepare($sql);

        $params = [
            $car->getBrandId(),
            $car->getConditionId()
        ];
        if ($car->getPhotoId()) {
            $params[] = $car->getPhotoId();
        }
        $params = array_merge($params, [
            $car->getName(),
            $car->getDescription(),
            $car->getProvince(),
            $car->getCity(),
            $car->getMileage(),
            $car->getYear(),
            $car->getPrice(),
            $car->getIsCarOpenForSell(),
            $car->getIsApproved(),
            $now_time,
            $car->getId()
        ]);

        return $db->execute($params);
    }

    public function approve($id)
    {
        $db = $this->databaseConnection->prepare("UPDATE `car` SET `is_approved` = 1 WHERE `id` = ?");
        return $db->execute([$id]);
    }
}