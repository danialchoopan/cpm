<?php


namespace App\controller\user;


use App\core\View;
use App\database\adapter\UserTableAdapter;
use App\database\model\User;

class UserAuthController
{
    public function show_register()
    {
        return View::Create('user.register');
    }

    public function register_user()
    {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        if (!preg_match("/(09)[0-9]{9}/", $phone_number)) {
            set_massage('لطفا یک شماره همراه معتبر وارد کنید', 'warning', false, false);
            return redirect(route('register/user'));
        }
        $password = $_POST['password'];
        $userAdapter = new UserTableAdapter();
        $user_model = new User();
        $user_model->setFullName($full_name);
        $user_model->setEmail($email);
        $user_model->setPhoneNumber($phone_number);
        $user_model->setPassword($password);
        $user_registered = $userAdapter->register($user_model);
        var_dump($user_registered);
        if ($user_registered) {
            set_massage('نام نویسی شما با موفقیت انجام شد', 'success', true, true);
            return redirect(route(''));
        } else {
            error_session();
            return redirect(route('register/user'));
        }
    }

    public function validate_phone_show()
    {
        return View::Create('user.validate_phone');
    }

    public function check_validate_phone()
    {
        $validate_code = $_POST['validate_code'];
        $user_adapter = new UserTableAdapter();
        set_massage($user_adapter->confirm_phone_sms_code($validate_code), 'success', false, true);
        redirect(route('user/validate/phone'));
    }

    public function validate_email_show()
    {
        return View::Create('user.validate_email');
    }

    public function validate_email($token)
    {
        $user_adapter = new UserTableAdapter();
        if ($user_adapter->confirm_email($token)) {
            set_massage('پست الکترونیک شما با موفقیت تایید شد', 'success', true, true);
            redirect(route(''));
        } else {
            echo '<h1>invalid code please check again</h1>';
        }
    }

    public function forget_password_show()
    {
        return View::Create('user.forget_password');
    }

    public function send_forget_password()
    {
        $email = $_POST['email'];
        $user_adapter = new UserTableAdapter();
        set_massage($user_adapter->SEND_RESET_PASSWORD_EMAIL($email), 'primary');
        redirect(route('forget/password/user'));
    }

    public function reset_password_show($token)
    {
        $user_adapter = new UserTableAdapter();
        if ($user_adapter->check_token_reset_password($token)) {
            return View::Create('user.reset_password', [
                'token' => $token
            ]);
        } else {
            redirect(route(''));
        }
    }

    public function reset_password($token)
    {
        $user_adapter = new UserTableAdapter();
        if ($user_adapter->check_token_reset_password($token)) {
            $password = $_POST['password'];
            $re_password = $_POST['re_password'];
            if ($password == $re_password) {
                if ($user_adapter->RESET_PASSWORD($token, $password)) {
                    set_massage('رمز عبور شما بازگشایی شد می توانید با رمز عبور جدید خوب وارد شوید', 'success', true, true);
                } else {
                    set_massage('مشکلی پیش آمد رمز عبور شما بازگشایی نشد', 'danger', false, true);
                }
                redirect(route(''));
            } else {
                set_massage('رمز عبور ها با هم برار نیستند', 'warning');
            }
        } else {
            set_massage('توکن وجود ندارد', 'danger');
        }
        redirect(route("user/reset/password/$token"));
    }
}