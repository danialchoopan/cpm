@extends('templates.for_content')
@section('title','درخواست')
@section('content')
    <?php
    $auth_user = authUser();
    $apply_car_adapter = new App\database\adapter\ApplyCarAdapter();
    ?>
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-100 m-4">
            <div class="card">
                <div class="card-header">درخواست</div>
                <div class="card-body">
                    @include('admin.msg')
                    <?php
                    $car_adapter = new \App\database\adapter\CarAdapter();
                    $car_model = $car_adapter->find($apply_car['car_id']);
                    ?>
                    <div class="form-group">
                        <label>خودرو: </label>
                        <a href="{{route("car/show/$car_model[id]")}}">{{$car_model['name']}}</a>
                    </div>

                    <div class="form-group">
                        <label>شرایط: </label>
                        <?php
                        $condition_model = show_condition_by_id($apply_car['condition_id'])
                        ?>
                        {{$condition_model['name']}}
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
                </div>
            </div>
        </div>
    </div>
@endsection
