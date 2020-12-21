@extends('admin.template.admin')
@section('title','نمایش درخواست ')
@section('title_content','درخواست  ')
@section('content')
    @include('admin.msg')
    <a href="{{route('admin/dash/apply/car')}}" class="btn btn-warning btn-primary mb-3">بازگشت به لیست درخواست ها</a>

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


    <div class="row">
        <div class="col">
            <a href="{{route("admin/dash/set/status/1/request/$apply_car[id]")}}"
               class="btn btn-danger btn-block">
                رد کردن
            </a>
        </div>
        <div class="col">
            <a href="{{route("admin/dash/set/status/2/request/$apply_car[id]")}}"
               class="btn btn-warning btn-block">
                در حال برسی
            </a>
        </div>
        <div class="col">
            <a href="{{route("admin/dash/apply/car/$apply_car[id]/show")}}" class="btn btn-info btn-block">
                مشاهده در خواست
            </a>
        </div>
        <div class="col">
            <a href="{{route("admin/dash/set/status/3/request/$apply_car[id]")}}" class="btn btn-success btn-block">
                تایید درخواست
            </a>
        </div>
    </div>
@endsection

