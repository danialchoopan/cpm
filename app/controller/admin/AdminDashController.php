<?php


namespace App\controller\admin;


use App\core\View;
use App\database\adapter\ApplyCarAdapter;
use App\database\adapter\BlogCommentAdapter;
use App\database\adapter\UserTableAdapter;
use App\database\adapter\ViewerAdapter;
use App\database\model\User;
use App\middleware\MiddlewareAdminLogin;

class AdminDashController
{

    public function dash()
    {
        $viewerAdapter = new ViewerAdapter();
        $user_adapter = new UserTableAdapter();
        $apply_car_adapter = new ApplyCarAdapter();
        $comment_adapter = new BlogCommentAdapter();
        return View::Create('admin.dash', [
            'count_view' => $viewerAdapter->getCountViewAllTimes(),
            'count_users' => $user_adapter->count_all_users(),
            'count_apply_car' => $apply_car_adapter->count_all_apply_car(),
            'count_comment_unread' => count($comment_adapter->confirmed(0))
        ]);
    }

    public function show_view()
    {
        $viewerAdapter = new ViewerAdapter();
        return View::Create('admin.view.index', [
            'views' => $viewerAdapter->get_all_views()
        ]);
    }

    public function showUsers()
    {
        $user_adapter = new UserTableAdapter();
        return View::Create('admin.user.index', ['users' => $user_adapter->show_all_users()]);
    }

    public function showUser($user_id)
    {
        $user_adapter = new UserTableAdapter();
        return View::Create('admin.user.show', ['user' => $user_adapter->get_user_by_id($user_id)]);
    }

    public function addUser()
    {
        return View::Create('admin.user.create');

    }

    public function addUser_by_admin()
    {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $validate_account = $_POST['validate_account'] ?? false;
        $user = new User();
        if ($validate_account == "on") {
            $user->setPhoneConfrimed(1);
            $user->setEmailConfrimed(1);
        } else {
            $user->setPhoneConfrimed(0);
            $user->setEmailConfrimed(0);
        }
        $user->setFullName($full_name);
        $user->setEmail($email);
        $user->setPhoneNumber($phone);
        $user->setPassword($password);
        $user->setValidateToken($validate_account);
        $userAdapter = new UserTableAdapter();
        $userAdapter->register_by_admin($user);
        redirect(route('admin/dash/users/show'));
    }

    public function rest_password_send()
    {

    }

    public function updateUser_by_admin()
    {
//        new MiddlewareAdminLogin();
        $id = $_POST['user_id'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $userAdapter = new UserTableAdapter();
        if (isset($_POST['submit_update'])) {
            $user = new User();
            $user->setId($id);
            $user->setFullName($full_name);
            $user->setEmail($email);
            $user->setPhoneNumber($phone);
            if ($userAdapter->update_user_by_admin($user)) {
                $_SESSION['msg_from_user_status'] = ['status' => 'success', 'msg' => 'کاربر شما با موفیت بروزرسانی شد'];
            } else {
                $_SESSION['msg_from_user_status'] = ['status' => 'danger', 'msg' => 'مشکلی در بروز رسانی پیش آمده لطفا بعدا امتحان کنید'];
            }
            redirect(route('admin/dash/users/show'));
        }
        if (isset($_POST['submit_delete'])) {
            if ($userAdapter->delete_user_by_admin($id)) {
                $_SESSION['msg_from_user_status'] = ['status' => 'success', 'msg' => 'کاربر مورد نظر شمار با موفقیت حدف شد'];
            } else {
                $_SESSION['msg_from_user_status'] = ['status' => 'danger', 'msg' => 'مشکلی در حدف کاربر پیش آمده لطفا بعدا امتحان کنید'];
            }
            redirect(route('admin/dash/users/show'));
        }
//        if (isset($_POST['submit_send_rest_password'])) {
//            //send reset password
//        }
    }
}