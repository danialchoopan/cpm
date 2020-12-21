@extends('admin.template.admin')
@section('title','داشبورد')
@section('title_content','آمار وبسایب')
@section('content')
    <h3 class="m-3">تعدا کاربران : {{$count_users}}</h3>
    <h3 class="m-3">تعداد درخواست ها: {{$count_apply_car}}</h3>
    <h3 class="m-3">تعداد بازدید ها : {{$count_view}}</h3>
    <h3 class="m-3">تعداد کامنت های تایید نشده : {{$count_comment_unread}}</h3>
@endsection