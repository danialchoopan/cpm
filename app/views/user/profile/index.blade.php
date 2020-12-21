@extends('templates.for_content')
@section('title','پروفایل')
@section('content')
    <?php
    $auth_user = authUser();
    ?>
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-100 m-4">
            <div class="card">
                <div class="card-header">مشخصات کاربر</div>
                <div class="card-body">
                    @if(!authUser()['phone_confrimed'] && !authUser()['email_confrimed'])
                        <div class="alert alert-danger text-center">
                            حساب شما تایید نشده است لطفا شماره خود را تایید کنید برای درخواست خرید خودرو باید حساب خود
                            را تایید کنید
                        </div>
                    @endif
                    <?php
                    $apply_car_adapter = new \App\database\adapter\ApplyCarAdapter();
                    $level_apply = $apply_car_adapter->show_apply_car_by_user_id($auth_user['id'], 2);
                    ?>
                    @if(count($level_apply)>0)
                        <div class="alert alert-success text-center">
                            در خواست شما تایید شده است لطفا برای تکمیل مدارک خود از قسمت
                            درخواست های تایید شده اقدام نمایید
                        </div>
                    @endif
                    @include('include.msg')
                    <div class="row">
                        <div class="col">
                            <h3>مشخصات کاربر</h3>
                            <p>نام :{{$auth_user['full_name']}}</p>
                            <p>پست الکترونیک :{{$auth_user['email']}} / @if($auth_user['email_confrimed'])
                                    <small class="text-muted">پست الکترونیک شما تایید شده است</small>
                                @else
                                    <small class="text-muted">پست الکترونیک شما تایید نشده است</small>
                                @endif</p>
                            <p>شماره همراه :{{$auth_user['phone_number']}} / @if($auth_user['phone_confrimed'])
                                    <small class="text-muted">شماره شما تایید شده است</small>
                                @else
                                    <small class="text-muted">شماره همراه شما تایید نشده است برای در خواست خودرو باید
                                        شماره خود راتایید کنید</small>
                                @endif</p>
                            @if(authUser()['phone_confrimed'] && authUser()['email_confrimed'])
                                <p class="text-success">حساب شما تایید شده است</p>
                            @endif
                            <div class="row">
                                @if($auth_user['phone_confrimed']==0)
                                    <a class="col m-2 btn btn-primary btn-block"
                                       href="{{route('user/validate/phone')}}">تایید
                                        شماره</a>
                                @endif
                                <a class="col m-2 btn btn-info btn-block" href="{{route('profile/user/edit')}}">
                                    ویرایش پروفایل
                                </a>
                                <a class="col m-2 btn btn-secondary btn-block"
                                   href="{{route('profile/user/change/password')}}">تغییر
                                    رمز
                                    عبور</a>
                            </div>
                            <div class="row">
                                <a class="col m-2 btn btn-primary btn-block"
                                   href="{{route('profile/user/request/status/0')}}">
                                    درخواست های خودرو
                                </a>
                                <a class="col m-2 btn btn-success btn-block"
                                   href="{{route('profile/user/request/status/3')}}">
                                    {{count($level_apply)}}
                                    -
                                    درخواست تایید شده
                                </a>
                            </div>
                            @if(isset($gest))
                                <p class="mt-3">اقساط شما : برای خودروی
                                    <?php
                                    $car_adapter = new \App\database\adapter\CarAdapter();
                                    $car_model = $car_adapter->find($apply_model['car_id']);
                                    ?>
                                    <a href="{{route("car/show/$car_model[id]")}}">
                                        {{$car_model['name']}}
                                    </a>
                                </p>
                                <p class="alert alert-info">
                                    ماهانه :
                                    {{$gest['month_lenght']}}
                                    <br>
                                    سود: 120%
                                    <br>
                                    تعداد ماه ها :
                                    {{$gest['each_month']}}
                                </p>
                            @endif
                        </div>
                        <div class="col text-center">
                            @if($auth_user['photo_id'])
                                <img src="{{show_by_photo_id($auth_user['photo_id'])}}" width="80%" alt="پروفایل">
                            @else
                                <img src="" alt="بدون پروفایل">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection