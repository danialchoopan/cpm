@extends('admin.template.admin')
@section('title','افزودن شرایط')
@section('title_content','افزودن')
@section('content')
    <a href="{{route('admin/dash/conditions')}}" class="btn btn-warning">بازگشت به لیست شرایط ها </a>
    <form method="post" action="{{route('admin/dash/conditions')}}">
        <div class="form-group">
            <label for="input_title">نام:</label>
            <input type="text" class="form-control" id="input_title" name="name" required>
        </div>

        <div class="form-group">
            <label for="input_body">توضیحات :</label>
            <textarea class="form-control" name="description" id="input_body" required></textarea>
        </div>

        <input type="submit" class="btn btn-primary" value="افزودن"/>
    </form>
@endsection