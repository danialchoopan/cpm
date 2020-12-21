@extends('admin.template.admin')
@section('title','بروز رسانی کاربر')
@section('title_content','بروزرسانی')
@section('content')
    <form method="post" action="{{route('admin/dash/users/update')}}">
        {{--        check phone--}}
        @if($user['phone_confrimed'])
            <div class="alert alert-success" role="alert">
                شماره کاربر تایید شده است
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                شماره کاربر تایید نشده است
            </div>
        @endif
        {{--        check email--}}
        @if($user['email_confrimed'])
            <div class="alert alert-success" role="alert">
                پست الکترونیک کاربر تایید شده است
            </div>
        @else
            <div class="alert alert-danger" role="alert">
                پست الکترونیک کاربر تایید نشده است
            </div>
        @endif
        <input type="hidden" name="user_id" value="{{$user['id']}}">
        <div class="form-group">
            <label for="input_name">نام نام خانوادگی :</label>
            <input type="text" class="form-control" id="input_name" name="full_name" value="{{$user['full_name']}}"
                   required>
            <small id="emailHelp" class="form-text text-muted">نام کامل وارد کنید.</small>
        </div>

        <div class="form-group">
            <label for=input_email>پست الکترونیک :</label>
            <input type="email" class="form-control" name="email" id="input_email" value="{{$user['email']}}" required>
        </div>

        <div class="form-group">
            <label for=input_phone>تلفن همراه :</label>
            <input type="text" class="form-control" name="phone" id="input_email" value="{{$user['phone_number']}}"
                   required>
        </div>

        <input type="submit" class="btn btn-primary ml-2" name="submit_update" value="بروزرسانی"/>
        <input type="submit" class="btn btn-danger ml-2" name="submit_delete" value="حدف کاربر"/>
        <input type="submit" class="btn btn-warning ml-2" name="submit_send_rest_password"
               value="ارسال ریست گذارواژه لینک"/>
        @if(!$user['email_confrimed'])
        <input type="submit" class="btn btn-warning ml-2" name="submit_send_rest_password"
               value="ارسال لینک تایید پیست الکترونیک"/>
        @endif
    </form>
@endsection