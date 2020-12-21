@extends('admin.template.admin')
@section('title','نمایش برند ها')
@section('title_content','برند  ها')
@section('content')
    @include('include.msg')
    <div class="row m-1">
        <div class="col">
            <a href="{{route('admin/dash/brand/create')}}" class="btn btn-primary">افزودن</a>
        </div>
    </div>
    @if(count($brands)!=0)
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">نام</th>
                <th scope="col">لوگو</th>
                <th scope="col">ساخته شده در</th>
                <th scope="col">بروزرسانی شده در</th>
            </tr>
            </thead>
            <tbody>
            @foreach($brands as $brand)
                <?php
                $photo_adapter = new \App\database\adapter\PhotoAdapter();
                ?>
                <tr>
                    <th scope="row">{{$brand['id']}}</th>
                    <td>
                        <a href="{{route("admin/dash/brand/$brand[id]/edit")}}">{{$brand['name']}}</a>
                    </td>
                    <td>
                        <img src="{{show_img_user($photo_adapter->find($brand['photo_id'])['name'])}}"
                             alt="عکس پیدا نشد"
                             width="50px" height="50px">
                    </td>
                    <td>{{show_date_php($brand['created_at'])}}</td>
                    <td>{{show_date_php($brand['updated_at'])}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="row m-1">
            <div class="col text-center">
                <h4>متاسفانه برندی برای نمایش وجود ندارد</h4>
                <a href="{{route('admin/dash/brand/create')}}">افزودن برند</a>
            </div>
        </div>
    @endif
@endsection
