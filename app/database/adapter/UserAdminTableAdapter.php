<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\model\UserAdmin;

class UserAdminTableAdapter extends DatabaseConnection
{
    public function login(UserAdmin $userAdmin)
    {
        $db = $this->databaseConnection->prepare("SELECT `id`, `full_name`, `username`, `phone_number`, `remmber_token`, `created_date` FROM `admins` WHERE `username`=? AND `password`=?");
        if ($db->execute([$userAdmin->getUsername(), $userAdmin->getPassword()])) {
            if ($db->rowCount() != 0) {
                $_SESSION['auth_admin'] = $db->fetch(2);
                return 1;
            } else {
                //username or password are invalid
                return 2;
            }
        } else {
            return 3;
        }
    }
}