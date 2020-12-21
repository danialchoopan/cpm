<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\interfaces\AdapterBasic;
use App\database\model\DataModel;
use App\database\model\UserAdmin;

class UserAdminAdapter extends DatabaseConnection
{

    public function find($id)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `admins` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public function update(UserAdmin $userAdmin)
    {
        if ($userAdmin->getPassword()):
            $sql = "UPDATE `admins` SET `full_name`=?,`username`=?,`password`=? WHERE `id`=?";
            $db = $this->databaseConnection->prepare($sql);
            return $db->execute([$userAdmin->getFullName(), $userAdmin->getUsername(),
                $userAdmin->getPassword(), $userAdmin->getId()]);
        else:
            $sql = "UPDATE `admins` SET `full_name`=?,`username`=? WHERE `id`=?";
            $db = $this->databaseConnection->prepare($sql);
            return $db->execute([$userAdmin->getFullName(),
                $userAdmin->getUsername(), $userAdmin->getId()]);
        endif;
    }
}