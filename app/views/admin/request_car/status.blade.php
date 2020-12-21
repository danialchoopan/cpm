@extends('admin.template.admin')
@section('title','نمایش درخواست ها')
@section('title_content','درخواست  ها')
@section('content')
    @include('admin.msg')
    @if(count($apply_cars)!=0)
        <div class="row m-3">
            <div class="col">
                <a href="{{route('admin/dash/apply/car/status/show/1')}}" class="btn btn-danger btn-block">
                    نمایش رد شده ها
                </a>
            </div>
            <div class="col">
                <a href="{{route('admin/dash/apply/car/status/show/2')}}" class="btn btn-warning btn-block">
                    نمایش در حال برسی ها
                </a>
            </div>
            <div class="col">
                <a href="{{route('admin/dash/apply/car/status/show/3')}}" class="btn btn-success btn-block">
                    نمایش تایید شده ها
                </a>
            </div>
        </div>
        <h1 class="text-center">{{show_status_car_adapter($status_id)}}</h1>
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">کاربر</th>
                <th scope="col">خودرو</th>
                <th scope="col">شرایط</th>
                <th scope="col">وضعیت</th>
                <th scope="col">ساخته شده در</th>
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
                    <td>{{user_auth_id($apply['user_id'])['full_name']}}</td>
                    <td>{{$car_adapter->find($apply['car_id'])['name']}}</td>
                    <td>{{show_condition_by_id($apply['condition_id'])['name']}}</td>
                    <td>{{show_status_car_adapter($apply['status'])}}</td>
                    <td>{{show_date_php($apply['created_at'])}}</td>
                    <td>
                        <a href="{{route("admin/dash/set/status/1/request/$apply[id]")}}"
                           class="btn btn-danger btn-block">
                            رد کردن
                        </a>
                        <a href="{{route("admin/dash/set/status/2/request/$apply[id]")}}"
                           class="btn btn-warning btn-block">
                            در حال برسی
                        </a>
                        <a href="{{route("admin/dash/apply/car/$apply[id]/show")}}"
                           class="btn btn-info btn-block">
                            مشاهده در خواست
                        </a>

                        @if($apply['level']==3)
                            <a
                                    href="{{route("admin/dash/level/3/confirm/$apply[id]")}}"
                                    class="btn btn-success btn-block"
                            >درخواست تکمیل مدارک</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="row m-1">
            <div class="col text-center">
                <h4>متاسفانه درخواستی برای نمایش وجود ندارد</h4>
            </div>
        </div>
    @endif
@endsection
