<?php


namespace App\controller\admin\setting;


use App\controller\interface_controller\BasicController;
use App\core\View;
use App\database\adapter\setting\GeneralSettingAdapter;

class AdminSettingGeneralController
{

    public function index()
    {
        $setting_general_adapter = new GeneralSettingAdapter();
        return View::Create('admin.setting.general.index', ['setting_general' => $setting_general_adapter->all()]);
    }

    public function update()
    {
        $name = $_POST['site_name'];
        $description = $_POST['site_description'];
        $site_is_disable = $_POST['site_is_disable'] == 'on' ? 1 : 0;
        $register_is_open = $_POST['register_is_open'] == 'on' ? 1 : 0;
        $format_date = $_POST['format_date'];

        $email_admin = $_POST['email_admin'];
        $phone_admin = $_POST['phone_number'];

        $setting_general_adapter = new GeneralSettingAdapter();
        $setting_general_adapter->update($name, $description, $site_is_disable, $register_is_open,
            '', $format_date,$email_admin,$phone_admin);
        $_SESSION['msg_from_insert_status'] = ['status' => 'success', 'msg' => 'تنظیمات عمومی با موفیت بروز شد'];
        redirect(route('admin/dash/setting/general'));

    }
}