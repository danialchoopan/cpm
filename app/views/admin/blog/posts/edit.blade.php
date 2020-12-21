@extends('admin.template.admin')
@section('title','ویرایش پست')
@section('title_content','ویرایش')
@section('content')
    <form method="post" action="{{route("admin/dash/posts/$post[id]/update")}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="input_title">عنوان:</label>
            <input type="text" class="form-control" id="input_title" name="title"
                   value="{{$post['title']}}"
                   required>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="input_img">عکس عنوان: </label>
                    <input type="file" class="form-control" name="img_thumbnail" id="input_img">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <img src="{{$_ENV['SITE_URL'].'assets/img/user_img/'.$photo}}" width="100%"
                         alt="{{$photo}}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="input_body">بدنه :</label>
            <textarea class="form-control" name="body" id="input_body" required>{{$post['body']}}</textarea>
        </div>

        <div class="form-group">
            <label for="input_select">دسته بندی:</label>
            <select class="form-control" name="category">
                @foreach($categorys as $category)
                    <option value="{{$category['id']}}"
                            @if($category['id']==$post['category_id'])
                            selected
                            @endif
                    >{{$category['name']}}</option>
                @endforeach
            </select>
        </div>
        <input type="submit" class="btn btn-primary m-2" value="بروزسانی">
    </form>
    <form action="{{route('admin/dash/posts/destroy')}}" method="post">
        <input type="hidden" name="id_post" value="{{$post['id']}}}">
        <input type="submit" class="btn btn-danger m-2" value="حذف پست">
    </form>
@endsection