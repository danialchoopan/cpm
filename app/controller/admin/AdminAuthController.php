<?php


namespace App\controller\admin;


use App\core\View;
use App\database\adapter\UserAdminTableAdapter;
use App\database\model\UserAdmin;

class AdminAuthController
{
    public function loginPage()
    {
        if (authAdmin()) {
            if ($_SERVER['REQUEST_URI'] != "/cpm/admin/dash")
                redirect(route('admin/dash'));
        }
        return View::Create('admin.login');
    }

    public function logout()
    {
        unset($_SESSION['auth_admin']);
        redirect(route('admin'));
    }

    public function login()
    {
        if (isset($_POST['username']) && isset($_POST['password'])):
            $username = $_POST['username'];
            $password = $_POST['password'];
            $userAdminTableAdapter = new UserAdminTableAdapter();
            $userAdminModel = new UserAdmin();
            $userAdminModel->setUsername($username);
            $userAdminModel->setPassword($password);
            switch ($userAdminTableAdapter->login($userAdminModel)) {
                case 1:
                    redirect(route('admin/dash'));
                    break;
                case 2:
                    set_massage('نام کاربری یا رمز عبور اشتباه است', 'danger');
                    redirect(route('admin'));
                    break;
                case 3:
                    error_session();
                    redirect(route('admin'));
                    break;
            }
        endif;
    }
}