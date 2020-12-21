@extends('admin.template.admin')
@section('title','نمایش کاربران')
@section('title_content','کاربران')
@section('content')
    @if(isset($_SESSION['msg_from_user_status']))
        <?php
        $temp_session = flash_session('msg_from_user_status');
        ?>
        <div class="alert alert-{{$temp_session['status']}}">
            {{$temp_session['msg']}}
        </div>
    @endif
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">نام</th>
            <th scope="col">شماره همراه</th>
            <th scope="col">پست الکترونیک</th>
            <th scope="col">ساخته شده در</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <th scope="row">{{$user['id']}}</th>
                <td><a href="{{route("admin/dash/user/show/$user[id]")}}">{{$user['full_name']}}</a></td>
                <td>{{$user['phone_number']}}</td>
                <td>{{$user['email']}}</td>
                <td>{{show_date_php($user['created_date'])}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection