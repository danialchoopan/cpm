<?php


namespace App\controller\admin\setting;


use App\controller\interface_controller\BasicController;
use App\core\View;
use App\database\adapter\setting\GeneralSettingAdapter;

class AdminContactUsSetting
{

    public function index()
    {
        $setting_general_adapter = new GeneralSettingAdapter();
        return View::Create('admin.setting.contact_us.update',
            [
                'setting_general' => $setting_general_adapter->all()
            ]
        );
    }

    public function update()
    {
        if (isset($_POST['contact_us'])):
            $contact_us = $_POST['contact_us'];
            $setting_general_adapter = new GeneralSettingAdapter();
            if ($setting_general_adapter->update_contact_us($contact_us)) {
                set_massage("ارتباط ما با موفیت بروز شد");
            } else {
                error_session();
            }
            redirect(route('admin/dash/setting/contact_us'));
        endif;
    }
}