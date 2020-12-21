<?php


namespace App\database\adapter\setting;


use App\database\DatabaseConnection;
use App\database\interfaces\AdapterBasic;
use App\database\model\DataModel;

class GeneralSettingAdapter extends DatabaseConnection
{

    public function all()
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `site_setting`");
        if ($db->execute()) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }


    public function update($site_name, $site_description, $site_is_disable, $register_is_open, $site_url = '', $format_date = 'en', $email, $phone)
    {
        $db = $this->databaseConnection->prepare(
            "UPDATE `site_setting` SET `site_name`=?,`site_description`=?,`site_is_disable`=?,`register_is_open`=?,`site_url`=?,`format_date`=?,`email`=?,`phone_number`=?");
        $db->execute([$site_name, $site_description, $site_is_disable, $register_is_open, $site_url, $format_date, $email, $phone]);
    }

    public function update_about_us($about_us)
    {
        $db = $this->databaseConnection->prepare(
            "UPDATE `site_setting` SET `about_us`=?");
        return $db->execute([$about_us]);
    }

    public function update_contact_us($contact_us)
    {
        $db = $this->databaseConnection->prepare(
            "UPDATE `site_setting` SET `contact_us`=?");
        return $db->execute([$contact_us]);
    }
}