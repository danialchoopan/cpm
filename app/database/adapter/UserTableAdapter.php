<?php


namespace App\database\adapter;


use App\core\api\SendMailApi;
use App\database\DatabaseConnection;
use App\database\model\User;
use Kavenegar\KavenegarApi;
use Mailgun\Mailgun;

class UserTableAdapter extends DatabaseConnection
{
    public function register(User $user)
    {
        $sql = "INSERT INTO `users`(`full_name`, `password`, `email`, `phone_number`, `created_date`) 
VALUES (?,?,?,?,?)";
        $db = $this->databaseConnection->prepare($sql);
        if (!$db->execute([$user->getFullName(), $user->getPassword(), $user->getEmail(), $user->getPhoneNumber(), time()])) {
            return false;
        }
        $this->login($user);
        return $this->get_user_by_phone_number($user->getPhoneNumber());

    }

    public function login(User $user)
    {
        $db = $this->databaseConnection->prepare("SELECT `id`,`full_name` FROM `users` WHERE `email`=? AND `password`=?");
        $db->execute([$user->getEmail(), $user->getPassword()]);
        if ($db->rowCount() != 0) {
            $user_data = $db->fetch(2);
            $_SESSION['user_auth'] = $user_data;
            return $user_data;
        } else {
            return false;
        }

    }

    public function update_profile_photo($photo_id)
    {
        $auth_user = authUser();
        $sql = "UPDATE `users` SET `photo_id`=? WHERE `id`=?";
        $user_table = $this->databaseConnection->prepare($sql);
        return $user_table->execute([$photo_id, $auth_user['id']]);
    }

    public function change_password_user($old_password, $password)
    {
        $auth_user = authUser();
        $sql = "SELECT * FROM `users` WHERE `id`=?";
        $user_table_1 = $this->databaseConnection->prepare($sql);
        $user_table_1->execute([$auth_user['id']]);
        $tmp_user_model = $user_table_1->fetch(2);
        if ($tmp_user_model['password'] == md5($old_password)) {
            $sql = "UPDATE `users` SET `password`=? WHERE `id`=?";
            $user_table = $this->databaseConnection->prepare($sql);
            $user_table->execute([md5($password), $auth_user['id']]);
            return
                [
                    'status' => 'success',
                    'msg' => 'رمز عبور شما با موفقیت تغییر کرد'
                ];
        } else {
            return
                [
                    'status' => 'danger',
                    'msg' => 'رمز عبور اشتباه است'
                ];
        }
    }

    public function SEND_SMS_VALIDATION()
    {
        if (authUser()) {
            $phone_number = authUser()['phone_number'];
            $db = $this->databaseConnection->prepare("SELECT * FROM `send_validation_sms_code` WHERE `phone`=? ORDER BY `id` DESC");
            $db->execute([$phone_number]);
            if ($db->rowCount() != 0) {
                $tmp_send_validation_sms_code_model = $db->fetch(2);
                if ($tmp_send_validation_sms_code_model['expire_time'] < time()) {
                    //send validate sms
                    $this->sendValidateSMSCode($phone_number);
                    return "کد تایید برای شما قبلا ارسال شده است کد تایید جدیدی برای شما ارسال شده ";
                } else {
                    return "کد تایید قبلا برای شما ارسال شده است کد تایید ارسال شده تا 5 دقیقه معتبر است";
                }
            } else {
                //send validate sms
                $this->sendValidateSMSCode($phone_number);
                return "کد تایید برای شما ارسال شده";
            }
        } else {
            return 'برای  تایید ابتدا باید وارد شوید';
        }

    }

    public function RESET_PASSWORD($token, $password)
    {
        if ($this->check_token_reset_password($token)) {
            $reset_password_table = $this->databaseConnection->prepare("SELECT * FROM `send_reset_password` WHERE `token`=? ORDER BY `id` DESC");
            $reset_password_table->execute([$token]);
            $user_id = $reset_password_table->fetch(2)['user_id'];
            $user_table = $this->databaseConnection->prepare("UPDATE `users` SET `password`=? WHERE `id`=?");
            $user_table->execute([md5($password), $user_id]);
            $reset_password_table_2 = $this->databaseConnection->prepare("DELETE FROM `send_reset_password` WHERE `token`=?");
            $reset_password_table_2->execute([$token]);
            return true;
        } else {
            return false;
        }
    }

    public function SEND_RESET_PASSWORD_EMAIL($email)
    {
        if ($this->get_user_by_email($email)) {
            $user_model = $this->get_user_by_email($email);
            $db = $this->databaseConnection->prepare("SELECT * FROM `send_reset_password` WHERE `user_id`=? ORDER BY `id` DESC");
            $db->execute([$user_model['id']]);
            if ($db->rowCount() != 0) {
                $tmp_send_reset_password = $db->fetch(2);
                if ($tmp_send_reset_password['expire_time'] < time()) {
                    //send reset password
                    $this->sendResetPasswordEmail($user_model['email']);
                    return "بازگشایی رمز عبور جدیدی برای شما ارسال شد";
                } else {
                    return "بازگشایی رمز عبور قبلا برای شما ارسال شده است و تا 6 ساعت معتبر است";
                }
            } else {
                //send reset password
                $this->sendResetPasswordEmail($user_model['email']);
                return "بازگشایی رمز عبور برای شما ارسال شد";
            }
        } else {
            return 'کاربری پیدا نشد پست الکترونیک را چک کنید';
        }

    }

    //email send validation
    public function SEND_EMAIL_VALIDATION()
    {
        if (authUser()) {
            $email = authUser()['email'];
            $db = $this->databaseConnection->prepare("SELECT * FROM `send_validation_email` WHERE `email`=? ORDER BY `id` DESC");
            $db->execute([$email]);
            if ($db->rowCount() != 0) {
                $tmp_validation_email_model = $db->fetch(2);
                if ($tmp_validation_email_model['expire_time'] < time()) {
                    //send validate email
                    $this->sendEmailValidation_token_by_email($email);
                    return "ایمیل تایید برای شما قبلا ارسال شده است ایمیل تایید جدیدی برای شما ارسال شده ";
                } else {
                    return "ایمیل تایید قبلا برای شما ارسال شده است ایمیل تایید ارسال شده تا 48 ساعت معتبر است";
                }
            } else {
                //send validate email
                $this->sendEmailValidation_token_by_email($email);
                return "ایمیل تایید برای شما ارسال شده";
            }
        } else {
            return 'برای  تایید ابتدا باید وارد شوید';
        }

    }

    private function sendEmailValidation_token_by_email($email)
    {
        $token = token_maker();
        //expire_time 48h
        $expire_time = strtotime("+5 hours");
        $time_now = time();
        $temp_model_user = authUser();
        $mg = Mailgun::create($_ENV['MAILGUN_API_KEY']);
        $mg->messages()->send($_ENV['MAILGUN_DOMAIN_NAME'], [
            'from' => 'cardanial@danialchoopan.ir',
            'to' => $temp_model_user['email'],
            'subject' => 'دانیال خودرو',
            'text' => "
            برای تایید حساب خود اینجا کلیک کنید
            \n
            http://127.0.0.1/cpm/user/validate/email/$token
            "
        ]);
        if (!$temp_model_user) {
            return false;
        }
        $user_id = $temp_model_user['id'];
        $db = $this->databaseConnection->prepare("INSERT INTO `send_validation_email`(`user_id`, `email`, `token`, `expire_time`, `created_at`) VALUES (?,?,?,?,?)");
        return $db->execute([$user_id, $email, $token, $expire_time, $time_now]);
    }

    private function sendResetPasswordEmail($email)
    {
        $token = token_maker();
        //expire_time 6h
        $expire_time = strtotime("+6 hours");
        $time_now = time();
        $temp_model_user = $this->get_user_by_email($email);
        $mg = Mailgun::create($_ENV['MAILGUN_API_KEY']);
        $mg->messages()->send($_ENV['MAILGUN_DOMAIN_NAME'], [
            'from' => 'cardanial@danialchoopan.ir',
            'to' => $temp_model_user['email'],
            'subject' => 'دانیال خودرو',
            'text' => "
            برای تایید حساب خود اینجا کلیک کنید
            \n
            http://127.0.0.1/cpm/user/validate/email/$token
            "
        ]);
        if (!$temp_model_user) {
            return false;
        }
        $user_id = $temp_model_user['id'];
        $db = $this->databaseConnection->prepare("INSERT INTO `send_reset_password`(`user_id`, `token`, `expire_time`, `created_at`) VALUES (?,?,?,?)");
        return $db->execute([$user_id, $token, $expire_time, $time_now]);
    }

    private function sendValidateSMSCode($phone, $expire_time = 500)
    {
        $code_sms = sms_code_validation_generator();
        $sender = "1000596446";
        $receptor = "09216059177";
        $message = "code:$code_sms" . "\n" . "کد تایید ارسال شده شما تا 5 دقیقه معتبر است";
        $api = new KavenegarApi($_ENV['KAVENEGAR_API_KEY']);
        $api->Send($sender, $receptor, $message);
        //expire_time 5m
        $expire_time = time() + $expire_time;
        $temp_model_user = $this->get_user_by_phone_number($phone);
        if (!$temp_model_user) {
            return false;
        }
        $user_id = $temp_model_user['id'];
        $db = $this->databaseConnection->prepare("INSERT INTO `send_validation_sms_code`(`id`, `user_id`,`phone`, `code`, `expire_time`) VALUES (null,?,?,?,?)");
        return $db->execute([$user_id, $phone, $code_sms, $expire_time]);
    }

    public function confirm_phone_sms_code($code)
    {
        $phone = authUser()['phone_number'];
        $db = $this->databaseConnection->prepare("SELECT * FROM `send_validation_sms_code` WHERE `code`=? AND `phone`=? ");
        $db->execute([$code, $phone]);
        if ($db->rowCount() != 0) {
            $tmp_send_validation_sms_code_model = $db->fetch(2);
            if ($tmp_send_validation_sms_code_model['expire_time'] < time()) {
                return
                    [
                        'status' => 'danger',
                        'msg' =>
                            "کد تایید شما منقضی شده است"
                    ];
            } else {
                if ($this->get_user_by_phone_number($tmp_send_validation_sms_code_model['phone'])['phone_confrimed'] == 1) {
                    return
                        [
                            'status' => 'warning',
                            'msg' =>
                                "شماره شما قبلا تایید شده است"
                        ];
                }
                $this->update_confirm_phone_user($tmp_send_validation_sms_code_model['user_id']);
                return
                    [
                        'status' => 'success',
                        'msg' => "شماره شما تایید شد",
                        'harmane' => true
                    ];
            }
        } else {
            return
                [
                    'status' => 'danger',
                    'msg' =>
                        "کد تایید شما اشتباه است"
                ];
        }
    }

    public function confirm_email($token)
    {
        $authUser = authUser();
        $email = $authUser['email'];
        $db = $this->databaseConnection->prepare("SELECT * FROM `send_validation_email` WHERE `token`=? AND `email`=? ");
        $db->execute([$token, $email]);
        if ($db->rowCount() != 0) {
            $this->update_confirm_email_user($authUser['id']);
            return true;
        } else {
            return false;
        }
    }

    public function send_again_validation_sms($phone)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `send_validation_sms_code` WHERE `phone`=? ");
        $db->execute([$phone]);
        if ($db->rowCount() != 0) {
            $tmp_send_validation_sms_code_model = $db->fetch(2);
            if ($tmp_send_validation_sms_code_model['expire_time'] < time()) {
                return 'code is send before';
            } else {
                $this->send_validation_sms($phone);
                return "کد تایید ارسال شد";
            }
        } else {
            return "کد تایید برای شما ارسال شد";
        }
    }

    public function show_all_users()
    {
        $db = $this->databaseConnection->prepare("SELECT `id`, `full_name`,  `email`, `phone_number`, `created_date` FROM `users`");
        if ($db->execute()) {
            return $db->fetchAll();
        } else {
            return false;
        }
    }

    public function check_token_reset_password($token)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `send_reset_password` WHERE `token`=?");
        $db->execute([$token]);
        if ($db->rowCount() != 0) {
            if ($db->fetch(2)['expire_time'] < time())
                return false;
            return true;
        } else {
            return false;
        }
    }

//admin

    public
    function get_user_by_id($id)
    {
        $db = $this->databaseConnection->prepare("SELECT `id`, `full_name`,  `email`, `phone_number`, `created_date`,`phone_confrimed`,`email_confrimed`,`photo_id` FROM `users` WHERE `id`=?");
        if ($db->execute([$id])) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    public
    function update_user_by_admin(User $user)
    {
        $db = $this->databaseConnection->prepare("UPDATE `users` SET `full_name`=?,`email`=?,`phone_number`=? WHERE `id`=?");
        if ($db->execute([$user->getFullName(), $user->getEmail(), $user->getPhoneNumber(), $user->getId()])) {
            return true;
        } else {
            return false;
        }
    }

    public
    function delete_user_by_admin($user_id)
    {
        $db = $this->databaseConnection->prepare("DELETE FROM `users` WHERE `id`=?");
        if ($db->execute([$user_id])) {
            return true;
        } else {
            return false;
        }
    }

    public
    function register_by_admin(User $user)
    {
        $db = $this->databaseConnection->prepare("INSERT INTO `users`(`id`, `full_name`, `password`, `email`, `phone_number`, `created_date`, `remmber_token`, `validate_token`, `forget_pass_token`,`email_confrimed`, `phone_confrimed`) VALUES (null,?,?,?,?,?,?,?,?,?,?)");
        if (!$db->execute([$user->getFullName(), $user->getPassword(), $user->getEmail(), $user->getPhoneNumber(), time(), token_maker(), token_maker(), token_maker(), $user->getEmailConfrimed(), $user->getPhoneConfrimed()])) {
            return false;
        }
        return $this->get_user_by_phone_number($user->getPhoneNumber());
    }

    public
    function count_all_users()
    {
        $db = $this->databaseConnection->prepare("SELECT COUNT(*) as user_count FROM `users`");
        if ($db->execute()) {
            return $db->fetch(2)['user_count'];
        } else {
            return false;
        }
    }

    private
    function update_confirm_phone_user($user_id)
    {
        $db = $this->databaseConnection->prepare("UPDATE `users` SET `phone_confrimed`=1 WHERE `id`=?");
        return $db->execute([$user_id]);
    }

    private
    function update_confirm_email_user($user_id)
    {
        $db = $this->databaseConnection->prepare("UPDATE `users` SET `email_confrimed`=1 WHERE `id`=?");
        return $db->execute([$user_id]);
    }

    private
    function get_user_by_phone_number($phone_number)
    {
        $db = $this->databaseConnection->prepare("SELECT `id`,`full_name`,`phone_number`,`phone_confrimed` FROM `users` WHERE `phone_number`=?");
        $db->execute([$phone_number]);
        if ($db->rowCount() != 0) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }

    private
    function get_user_by_email($email)
    {
        $db = $this->databaseConnection->prepare("SELECT * FROM `users` WHERE `email`=?");
        $db->execute([$email]);
        if ($db->rowCount() != 0) {
            return $db->fetch(2);
        } else {
            return false;
        }
    }
}