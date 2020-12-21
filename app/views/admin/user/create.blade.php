@extends('admin.template.admin')
@section('title','افزودن کاربر')
@section('title_content','افزودن')
@section('content')
    <form method="post" action="{{route('admin/dash/users/add')}}">
        <div class="form-group">
            <label for="input_name">نام نام خانوادگی :</label>
            <input type="text" class="form-control" id="input_name" name="full_name" required>
            <small id="emailHelp" class="form-text text-muted">نام کامل وارد کنید.</small>
        </div>

        <div class="form-group">
            <label for=input_email>پست الکترونیک :</label>
            <input type="email" class="form-control" name="email" id="input_email" required>
        </div>

        <div class="form-group">
            <label for=input_phone>تلفن همراه :</label>
            <input type="text" class="form-control" name="phone" id="input_email" required>
        </div>

        <div class="form-group">
            <label for=input_email>گذرواژه :</label>
            <input type="password" class="form-control" name="password" id="input_email" required>
        </div>

        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" name="validate_account" id="input_validate">
            <label for="input_validate" style="margin: 10px">
                حساب تایید شود ؟
            </label>
        </div>

        <input type="submit" class="btn btn-primary" value="نام نویسی"/>
    </form>
@endsection