<?php


namespace App\controller\admin\setting;


use App\controller\interface_controller\BasicController;
use App\core\View;
use App\database\adapter\setting\GeneralSettingAdapter;

class AdminAboutUsSetting
{

    public function index()
    {
        $setting_general_adapter = new GeneralSettingAdapter();
        return View::Create('admin.setting.about_us.update',
            [
                'setting_general' => $setting_general_adapter->all()
            ]
        );
    }

    public function update()
    {
        if (isset($_POST['about_us'])):
            $about_us = $_POST['about_us'];
            $setting_general_adapter = new GeneralSettingAdapter();
            if ($setting_general_adapter->update_about_us($about_us)) {
                set_massage("درباره ما با موفیت بروز شد");
            } else {
                error_session();
            }
            redirect(route('admin/dash/setting/about_us'));
        endif;
    }
}