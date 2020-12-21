<?php
function assets($namePath)
{
    return $_ENV['SITE_URL'] . 'assets/' . $namePath;
}

function route($routeName)
{
    return $_ENV['SITE_URL'] . $routeName;
}

function redirect($url)
{
    header("location: $url");
}

function flash_session($name)
{
    $tmp_session_name = $_SESSION[$name];
    unset($_SESSION[$name]);
    return $tmp_session_name;
}

function authAdmin()
{
    if (!isset($_SESSION['auth_admin']))
        return false;
    $user_admin_adapter = new \App\database\adapter\UserAdminAdapter();
    return $user_admin_adapter->find($_SESSION['auth_admin']['id']);
}

function authUser()
{
    if (!isset($_SESSION['user_auth']))
        return false;
    $user_adapter = new \App\database\adapter\UserTableAdapter();

    return $user_adapter->get_user_by_id($_SESSION['user_auth']['id']);
}

function LogoutUser()
{
    unset($_SESSION['user_auth']);
}

function token_maker($size = 200)
{
    $token = '';
    $letters = 'UIOPLlQWERTYUIOPLlkjhgfzxcvbnmKJHGFDSAZXCVBNMkjhgfdsazxcvbnmKJHGFDSAZXCVBNM';
    $letters = str_shuffle(rand(1111111, 9999999) . str_shuffle($letters . rand(1111111, 9999999) . $letters . $letters . rand(1111111, 9999999) . $letters . $letters . $letters));
    $array_letters = str_split($letters);
    for ($i = 0; $i <= $size; $i++) {
        $token .= $array_letters[$i];
    }
    return $token;
}

function sms_code_validation_generator($length = 6)
{
    $code = '';
    $number = '1234567890';
    $number = str_shuffle(str_shuffle(rand(1, 999999) . $number . rand(1, 999999) . $number . rand(1, 999999) . $number . rand(1, 999999) . $number));
    $ar_numbers = str_split($number);
    for ($i = 0; $i <= $length; $i++) {
        $code .= $ar_numbers[$i];
    }
    return $code;

}

function show_img_user($name)
{
    return $_ENV['SITE_URL'] . 'assets/img/user_img/' . $name;
}

function show_by_photo_id($id)
{
    $photo_adapter = new \App\database\adapter\PhotoAdapter();
    return show_img_user($photo_adapter->find($id)['name']);
}

function connect_to_database()
{
    return new PDO($_ENV['DSN_PDO'], $_ENV['USERNAME_DB'], $_ENV['PASSWORD_DB']);
}

function get_setting()
{
    $sql = "SELECT * FROM `site_setting`";
    $setting = connect_to_database()->prepare($sql);
    $setting->execute();
    return $setting->fetch(2);
}

function user_auth_id($id)
{
    $user_adapter = new \App\database\adapter\UserTableAdapter();
    return $user_adapter->get_user_by_id($id);
}

function set_massage($msg, $status = 'primary', $harmane = false, $modal = false)
{
    $_SESSION['msg_from_insert_status'] = ['msg' => $msg, 'status' => $status, 'harmane' => $harmane, 'modal' => $modal];
}

function error_session()
{
    $_SESSION['msg_from_insert_status'] = ['status' => 'danger', 'msg' => 'مشکلی  پیش آمده لطفا بعدا امتحان کنید'];

}

function show_status_car_adapter($id)
{
    $msg = '';
    switch ($id) {
        case 0:
            $msg = 'خوانده نشده';
            break;
        case 1:
            $msg = 'رد شده';
            break;
        case 2:
            $msg = 'در حال برسی';
            break;
        case 3:
            $msg = 'تایید شده';
            break;
    }
    return $msg;
}

//j date
function cp_jdate($time)
{
    list($y, $m, $d) = explode('-', date('Y-n-d', $time));
    return $j_date_string = gregorian_to_jalali($y, $m, $d, '/'); //خروجی رشته

}//show date site
function show_date_php($time_php, $format = 'Y-n-d', $delimiter = '-')
{
    $date_format = get_setting()['format_date'];
    if ($date_format == 'fa') {
        list($y, $m, $d) = explode($delimiter, date($format, $time_php));
        return $j_date_string = gregorian_to_jalali($y, $m, $d, '/'); //خروجی رشته
    } else if ($date_format == 'en') {
        return date($format, $time_php);
    }
}

function show_condition_by_id($id)
{
    $result = connect_to_database()->prepare("SELECT * FROM `conditions` WHERE `id`=?");
    $result->execute([$id]);
    return $result->fetch(2);
}

function gregorian_to_jalali($gy, $gm, $gd, $mod = '')
{
    $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
    $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
    $days = 355666 + (365 * $gy) + ((int)(($gy2 + 3) / 4)) - ((int)(($gy2 + 99) / 100)) + ((int)(($gy2 + 399) / 400)) + $gd + $g_d_m[$gm - 1];
    $jy = -1595 + (33 * ((int)($days / 12053)));
    $days %= 12053;
    $jy += 4 * ((int)($days / 1461));
    $days %= 1461;
    if ($days > 365) {
        $jy += (int)(($days - 1) / 365);
        $days = ($days - 1) % 365;
    }
    if ($days < 186) {
        $jm = 1 + (int)($days / 31);
        $jd = 1 + ($days % 31);
    } else {
        $jm = 7 + (int)(($days - 186) / 30);
        $jd = 1 + (($days - 186) % 30);
    }
    return ($mod == '') ? array($jy, $jm, $jd) : $jy . $mod . $jm . $mod . $jd;
}
