@extends('admin.template.admin')
@section('title','نمایش درخواست ')
@section('title_content','درخواست  ')
@section('content')
    @include('admin.msg')
    <div class="form-group">
        <label>کاربر: </label>
        <?php
        $user_model = user_auth_id($apply_car['user_id']);
        $car_adapter = new \App\database\adapter\CarAdapter();
        $car_model = $car_adapter->find($apply_car['car_id']);
        ?>
        <a href="{{route("admin/dash/user/show/$user_model[id]")}}">{{$user_model['full_name']}}</a>
    </div>
    <div class="form-group">
        <label>خودرو: </label>
        <a href="{{route("admin/dash/cars/$car_model[id]/edit")}}">{{$car_model['name']}}</a>
    </div>

    <div class="form-group">
        <label>شرایط: </label>
        <?php
        $condition_model = show_condition_by_id($apply_car['condition_id'])
        ?>
        <a href="{{route("admin/dash/conditions/$condition_model[id]/edit")}}">{{$condition_model['name']}}</a>
    </div>

    <div class="form-group">
        <label>کد ملی :</label>
        <p>{{$apply_car['n_code']}}</p>
    </div>

    <div class="form-group">
        <label>شماره حساب :</label>
        <p>{{$apply_car['account_number']}}</p>
    </div>

    <div class="form-group">
        <label>توضیحات :</label>
        <p>
            {{$apply_car['msg']}}
        </p>
    </div>

    <div class="form-group">
        <label for="input_img">عکس کارت ملی: </label>
        <img src="{{show_by_photo_id($level3['card_meli'])}}" width="80%" alt="پروفایل">
    </div>

    <div class="form-group">
        <label for="input_img">عکس شناسنامه: </label>
        <img src="{{show_by_photo_id($level3['shenasname'])}}" width="80%" alt="پروفایل">
    </div>

    <div class="form-group">
        <label for="input_img">عکس چک: </label>
        <img src="{{show_by_photo_id($level3['check_paper'])}}" width="80%" alt="پروفایل">
    </div>

    <div class="form-group">
        <p>درخواست تکمیل مدارک ارسال شده در
            {{show_date_php($level3['created_at'])}}
        </p>
    </div>

    <div class="row">
        <div class="col">
            <a href="{{route("admin/dash/set/status/1/request/$apply_car[id]")}}"
               class="btn btn-danger btn-block">
                رد کردن
            </a>
        </div>
        <div class="col">
            <a href="{{route("admin/dash/gests/add/$apply_car[id]/apply_id")}}" class="btn btn-success btn-block">
                تایید تکمیل مدارک و ایجاد قسط برای این کاربر
            </a>
        </div>
    </div>
@endsection

