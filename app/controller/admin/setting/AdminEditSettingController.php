<?php


namespace App\controller\admin\setting;


use App\controller\interface_controller\BasicController;
use App\core\View;
use App\database\adapter\UserAdminAdapter;
use App\database\model\UserAdmin;

class AdminEditSettingController
{

    public function edit()
    {
        return View::Create('admin.setting.edit_admin.index');
    }

    public function update()
    {
        if (
        isset($_POST['update_admin'])
        ):
            $user_admin_model = new UserAdmin();
            $user_admin_model_temp_adapter = new UserAdminAdapter();
            $display_name = $_POST['admin_display_name'];
            $username = $_POST['username'];
            $user_admin_id = authAdmin()['id'];
            $user_admin_model->setId($user_admin_id);
            $user_admin_model->setFullName($display_name);
            $user_admin_model->setUsername($username);
            if (
                isset($_POST['old_password'])
                &&
                isset($_POST['new_password'])
                &&
                isset($_POST['re_new_password'])
            ) :
                $old_password = $_POST['old_password'];
                $new_password = $_POST['new_password'];
                $re_new_password = $_POST['re_new_password'];
                $user_admin_adapter_tmp = $user_admin_model_temp_adapter->find($user_admin_id);
                if (md5($old_password) == $user_admin_adapter_tmp['password']) {
                    if ($new_password != $re_new_password) {
                        set_massage('رمز عبور ها برار نیستند', 'warning');
                        return redirect(route('admin/dash/setting/edit/admin'));
                    } else {
                        $user_admin_model->setPassword($new_password);
                    }
                } else {
                    set_massage('رمزعبور شما اشتباه است', 'danger');
                    return redirect(route('admin/dash/setting/edit/admin'));
                }
            endif;
            if ($user_admin_model_temp_adapter->update($user_admin_model)) {
                set_massage('اطلاعات شما با موفقیت بروز شد', 'success');
            } else {
                error_session();
            }
            return redirect(route('admin/dash/setting/edit/admin'));
        else:
            echo 'sorry post is required';
        endif;
//        var_dump($_POST);
    }

}