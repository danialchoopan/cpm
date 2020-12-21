@extends('templates.for_content')
@section('title','درخواست ها')
@section('content')
    <?php
    $auth_user = authUser();
    $apply_car_adapter = new App\database\adapter\ApplyCarAdapter();
    ?>
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-100 m-4">
            <div class="card">
                <div class="card-header">درخواست های {{show_status_car_adapter($id_status)}}</div>
                <div class="card-body">
                    @include('include.msg')
                    <div class="row m-3">
                        <div class="col">
                            <a href="{{route('profile/user/request/status/0')}}" class="btn btn-primary btn-block">
                                {{count($apply_car_adapter->status(0))}}
                                -
                                خوانده نشده ها
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{route('profile/user/request/status/1')}}" class="btn btn-danger btn-block">
                                {{count($apply_car_adapter->status(1))}}
                                -
                                رد شده ها
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{route('profile/user/request/status/2')}}" class="btn btn-warning btn-block">
                                {{count($apply_car_adapter->status(2))}}
                                -
                                در حال برسی ها
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{route('profile/user/request/status/3')}}" class="btn btn-success btn-block">
                                {{count($apply_car_adapter->status(3))}}
                                -
                                تایید شده ها
                            </a>
                        </div>
                    </div>
                    @if(count($apply_cars)!=0)
                        <table class="table table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">خودرو</th>
                                <th scope="col">شرایط</th>
                                <th scope="col">وضعیت</th>
                                <th scope="col">ارسال شده در</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($apply_cars as $apply)
                                <?php
                                $car_adapter = new \App\database\adapter\CarAdapter();
                                ?>
                                <tr>
                                    <th scope="row">{{$apply['id'].""}}</th>
                                    <td>{{$car_adapter->find($apply['car_id'])['name']}}</td>
                                    <td>{{show_condition_by_id($apply['condition_id'])['name']}}</td>
                                    <td>{{show_status_car_adapter($apply['status'])}}
                                        |
                                        @if($apply['level']==3 && $apply['status']==2)
                                            برسی مدارک/چک/کارت ملی
                                        @endif
                                    </td>
                                    <td>{{show_date_php($apply['created_at'])}}</td>
                                    <td>
                                        @if($apply['level']!=3)
                                            <a href="{{route("profile/user/request/apply/car/$apply[id]/show")}}"
                                               class="btn btn-info btn-block">
                                                مشاهده در خواست
                                            </a>
                                        @endif
                                        @if($apply['level']==2)
                                            <a href="{{route("profile/user/level/3/apply/$apply[id]")}}"
                                               class="btn btn-success btn-block"
                                            >تکمیل مدارک</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning">
                            <p class="m-3 text-center">متاسفانه در خواستی برای نمایش وجود ندارد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection