<?php

use App\core\Route;
use App\database\adapter\UserTableAdapter;
use App\database\model\User;

Route::ApiGet('/', function () {
    return 'this website dose not support api';
});

//Route::ApiPost('/user/validate/phone', function () {
//    $userAdapter = new UserTableAdapter();
//    $code = $_POST['rgr_v_code'];
//    $phone = $_POST['p_phone'];
//    return $userAdapter->confirm_phone_sms_code($code, $phone);
//});

Route::ApiPost('/user/login', function () {
    $userAdapter = new UserTableAdapter();
    $user_model = new User();
    $user_model->setEmail($_POST['lgn_phone_number']);
    $user_model->setPassword($_POST['lgn_password']);
    $user_data = $userAdapter->login($user_model);
    if ($user_data) {
        echo json_encode($user_data);
    } else {
        echo "false";
    }

});
Route::ApiGet('/user/logout', function () {
    LogoutUser();
    redirect(route(''));
});
//Route::ApiPost('/user/register', function () {
//    $userAdapter = new UserTableAdapter();
//    $user_model = new User();
//    $user_model->setEmail($_POST['rgr_email']);
//    $user_model->setFullName($_POST['rgr_name']);
//    $user_model->setPhoneNumber($_POST['rgr_phone_number']);
//    $user_model->setPassword($_POST['rgr_password']);
//    $user_registered = $userAdapter->register($user_model);
//    if ($user_registered) {
//        return true;
//    } else {
//        return false;
//    }
//});
