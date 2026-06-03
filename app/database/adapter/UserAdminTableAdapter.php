<?php


namespace App\database\adapter;


use App\database\DatabaseConnection;
use App\database\model\UserAdmin;

class UserAdminTableAdapter extends DatabaseConnection
{
    public function login(UserAdmin $userAdmin)
    {
        $db = $this->databaseConnection->prepare("SELECT `id`, `full_name`, `username`, `password`, `phone_number`, `remmber_token`, `created_date` FROM `admins` WHERE `username`=?");
        if ($db->execute([$userAdmin->getUsername()])) {
            $admin_data = $db->fetch(2);
            if ($admin_data) {
                if (password_verify($userAdmin->getPassword(), $admin_data['password'])) {
                    unset($admin_data['password']);
                    $_SESSION['auth_admin'] = $admin_data;
                    return 1;
                } else {
                    return 2;
                }
            } else {
                //username or password are invalid
                return 2;
            }
        } else {
            return 3;
        }
    }
}