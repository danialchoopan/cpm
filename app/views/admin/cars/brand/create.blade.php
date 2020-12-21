@extends('admin.template.admin')
@section('title','افزودن برند')
@section('title_content','افزودن')
@section('content')
    <a href="{{route('admin/dash/brand')}}" class="btn btn-warning">بازگشت به لیست برند ها </a>
    <form method="post" action="{{route('admin/dash/brand')}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="input_title">نام:</label>
            <input type="text" class="form-control" id="input_title" name="name" required>
        </div>

        <div class="form-group">
            <label for="input_img">لوگو برند: </label>
            <input type="file" class="form-control" name="img_logo" id="input_img" required>
        </div>

        <div class="form-group">
            <label for="input_body">توضیحات :</label>
            <textarea class="form-control" name="description" id="input_body" required></textarea>
        </div>

        <input type="submit" class="btn btn-primary" value="افزودن"/>
    </form>
@endsection