@extends('admin.template.admin')
@section('title','بروز رسانی ')
@section('title_content','بروزرسانی')
@section('content')
    @include('include.msg')
    <?php
    $auth_admin = authAdmin();
    ?>
    <form method="post" action="{{route('admin/dash/setting/edit/admin')}}">
        <input type="hidden" name="admin_id" value="{{$auth_admin['id']}}">

        <div class="form-group">
            <label>نام نمایشی ادمین :</label>
            <input type="text" class="form-control" name="admin_display_name" value="{{$auth_admin['full_name']}}"
                   required>
        </div>

        <div class="form-group">
            <label>نام کاربری :</label>
            <input type="text" class="form-control" name="username" value="{{$auth_admin['username']}}"
                   required>
        </div>
        <div class="form-group">
            <div class="alert alert-warning">
                برای تغییر رمز عبور خود این قسمت را تکمیل کنید
            </div>
        </div>
        <div class="form-group">
            <label>رمز عبور فعلی: </label>
            <input type="password" class="form-control"
                   name="old_password">
        </div>
        <div class="form-group">
            <label>رمز عبور جدید: </label>
            <input type="password" class="form-control"
                   name="new_password">
        </div>

        <div class="form-group">
            <label>تکرار رمز عبور جدید: </label>
            <input type="password" class="form-control" name="re_new_password"
            >
        </div>
        <input type="submit" class="btn btn-info btn-block" name="update_admin" value="بروزرسانی"/>
    </form>
@endsection