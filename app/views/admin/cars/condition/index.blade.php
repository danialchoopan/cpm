@extends('admin.template.admin')
@section('title','نمایش شرایط فروش ها')
@section('title_content','شرایط فروش   ها')
@section('content')
    @if(isset($_SESSION['msg_from_insert_status']))
        <?php
        $temp_session = flash_session('msg_from_insert_status');
        ?>
        <div class="alert alert-{{$temp_session['status']}}">
            {{$temp_session['msg']}}
        </div>
    @endif
    <div class="row m-1">
        <div class="col">
            <a href="{{route('admin/dash/conditions/create')}}" class="btn btn-primary">افزودن</a>
        </div>
    </div>
    @if(count($conditions)!=0)
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">نام</th>
                <th scope="col">ساخته شده در</th>
                <th scope="col">بروزرسانی شده در</th>
            </tr>
            </thead>
            <tbody>
            @foreach($conditions as $condition)
                <tr>
                    <th scope="row">{{$condition['id']}}</th>
                    <td>
                        <a href="{{route("admin/dash/conditions/$condition[id]/edit")}}">{{$condition['name']}}</a>
                    </td>
                    <td>{{show_date_php($condition['created_at'])}}</td>
                    <td>{{show_date_php($condition['updated_at'])}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="row m-1">
            <div class="col text-center">
                <h4>متاسفانه شرایطی برای نمایش وجود ندارد</h4>
                <a href="{{route('admin/dash/conditions/create')}}">افزودن شرایط</a>
            </div>
        </div>
    @endif
@endsection
