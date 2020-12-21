@extends('admin.template.admin')
@section('title','افزودن پست')
@section('title_content','افزودن')
@section('content')
    <form method="post" action="{{route('admin/dash/posts')}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="input_title">عنوان:</label>
            <input type="text" class="form-control" id="input_title" name="title" required>
            <small id="emailHelp" class="form-text text-muted">عنوان پست</small>
        </div>

        <div class="form-group">
            <label for="input_img">عکس عنوان: </label>
            <input type="file" class="form-control" name="img_thumbnail" id="input_img" required>
        </div>

        <div class="form-group">
            <label for="input_body">بدنه :</label>
            <textarea class="form-control" name="body" id="input_body" required></textarea>
        </div>

        <div class="form-group">
            <label for="input_select">دسته بندی:</label>
            <select class="form-control" name="category">
                @foreach($categorys as $category)
                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                @endforeach
            </select>
        </div>

        <input type="submit" class="btn btn-primary" value="افزودن"/>
    </form>
@endsection