<?php


namespace App\controller;


use App\core\View;
use App\database\adapter\ApplyCarAdapter;
use App\database\adapter\BrandAdapter;
use App\database\adapter\CarAdapter;
use App\database\adapter\ConditionCarSellAdapter;
use App\database\model\ApplyCar;

class CarPageController
{
    public function index()
    {
        $car_adapter = new CarAdapter();
        $brand_adapter = new BrandAdapter();
        return View::Create('car.index', [
            'cars' => $car_adapter->all(),
            'brands' => $brand_adapter->all()
        ]);
    }

    public function show($id)
    {
        $car_adapter = new CarAdapter();
        $car = $car_adapter->find($id);
        $brand_adapter = new BrandAdapter();
        return View::Create('car.show', [
            'car' => $car,
            'brand' => $brand_adapter->find($car['brand_id'])
        ]);
    }

    public function complete_request_show($car_id)
    {
        $condition_id = $_POST['condition_id'];
        return View::Create('car.complete_request', [
            'car_id' => $car_id,
            'condition_id' => $condition_id
        ]);
    }

    public function complete_request($car_id)
    {
        $n_code = $_POST['n_code'];
        $account_number = $_POST['account_number'];
        $body_msg = $_POST['body_msg'];
        $condition_id = $_POST['condition_id'];
        $user_id = authUser()['id'];
        $apply_car_model = new ApplyCar();
        $apply_car_model->setNCode($n_code);
        $apply_car_model->setAccountNumber($account_number);
        $apply_car_model->setMsg($body_msg);
        $apply_car_model->setConditionId($condition_id);
        $apply_car_model->setUserId($user_id);
        $apply_car_model->setCarId($car_id);
        $car_apply_adapter = new ApplyCarAdapter();
        if ($car_apply_adapter->insert($apply_car_model)) {
            $msg = 'در خواست شما با موفقیت ثبت شد همکاران ما بزودی با شما تماس خواهند گرفت پست الکترونیک خود را برسی کنید';
            set_massage($msg, 'success', false, true);
        } else {
            $msg = 'درخواست شما متاسفانه ثبت نشد لطفا دوباره امتحان کنید';
            set_massage($msg, 'danger', false, true);
        }
        redirect(route(''));
    }
}