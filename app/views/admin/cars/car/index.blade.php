@extends('admin.template.admin')
@section('title','نمایش خودرو ها')
@section('title_content','خودرو  ها')
@section('content')
    @if(isset($_SESSION['msg_from_insert_status']))
        <?php
        $temp_session = flash_session('msg_from_insert_status');
        ?>
        <div class="alert alert-{{$temp_session['status']}}">
            {{$temp_session['msg']}}
        </div>
    @endif
    @if(count($cars)!=0)
        <div class="row">
            <div class="col text-left">
                <a href="{{route('admin/dash/cars/create')}}" class="btn btn-primary mb-2">افزودن خودرو</a>
            </div>
        </div>
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">نام</th>
                <th scope="col">قیمت</th>
                <th scope="col">برند</th>
                <th scope="col">ساخته شده در</th>
                <th scope="col">بروزرسانی شده در</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cars as $car)
                <?php
                $photo_adapter = new \App\database\adapter\PhotoAdapter();
                $brand_adapter = new \App\database\adapter\BrandAdapter();
                $brand = $brand_adapter->find($car['brand_id']);
                ?>
                <tr>
                    <th scope="row">{{$car['id']}}</th>
                    <td>
                        <a href="{{route("admin/dash/cars/$car[id]/edit")}}">{{$car['name']}}</a>
                    </td>
                    <td>{{number_format($car['price'])}} تومان</td>
                    <td>
                        <img src="{{show_img_user($photo_adapter->find($brand['photo_id'])['name'])}}"
                             alt="عکس پیدا نشد"
                             width="50px" height="50px">
                        {{$brand['name']}}
                    </td>
                    <td>{{show_date_php($car['created_at'])}}</td>
                    <td>{{show_date_php($car['updated_at'])}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="row m-1">
            <div class="col text-center">
                <h4>متاسفانه خودرویی برای نمایش وجود ندارد</h4>
                <a href="{{route('admin/dash/cars/create')}}">افزودن خودرو</a>
            </div>
        </div>
    @endif
@endsection
