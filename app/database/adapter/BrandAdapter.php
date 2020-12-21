<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\model\Brand;
use App\database\model\DataModel;

class BrandAdapter extends DatabaseConnection
{

    public function all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `brand`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `brand` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function insert(Brand $brand)
    {
        $now_time = time();
        $sql = "INSERT INTO `brand`(`name`,`description`, `photo_id`, `created_at`, `updated_at`) VALUES (?,?,?,?,?)";
        $db = $this->databaseConnection->prepare($sql);
        if (!$db->execute([$brand->getName(), $brand->getDescription(), $brand->getPhotoId(), $now_time, $now_time])) {
            return false;
        }
        $result = $this->databaseConnection->prepare("SELECT * FROM `brand` ORDER BY `id` DESC");
        $result->execute();
        return $result->fetch(2);
    }

    public function delete($id)
    {
        $db = $this->databaseConnection->prepare("DELETE FROM `brand` WHERE `id`=?");
        return $db->execute([$id]);
    }

    public function update(Brand $brand)
    {
        $now_time = time();

        if ($brand->getPhotoId()) {
            $sql = "UPDATE `brand` SET `name`=?,`description`=?,`photo_id`=?,`updated_at`=? WHERE `id`=?";
        } else {
            $sql = "UPDATE `brand` SET `name`=?,`description`=?,`updated_at`=? WHERE `id`=?";
        }
        $db = $this->databaseConnection->prepare($sql);
        if ($brand->getPhotoId()) {
            return $db->execute([$brand->getName(), $brand->getDescription(), $brand->getPhotoId(), $now_time, $brand->getId()]);
        } else {
            return $db->execute([$brand->getName(), $brand->getDescription(), $now_time, $brand->getId()]);
        }

    }
}