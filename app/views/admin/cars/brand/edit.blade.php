@extends('admin.template.admin')
@section('title','بروزسانی برند')
@section('title_content','بروزسانی')
@section('content')
    <a href="{{route('admin/dash/brand')}}" class="btn btn-warning">بازگشت به لیست برند ها </a>
    <form method="post" action="{{route("admin/dash/brand/$brand[id]/update")}}" enctype="multipart/form-data">
        <div class="form-group">
            <label for="input_title">نام:</label>
            <input type="text" class="form-control" id="input_title" name="name"
                   value="{{$brand['name']}}"
                   required>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="input_img">لوگو برند: </label>
                    <input type="file" class="form-control" name="img_logo" id="input_img">
                </div>
            </div>
            <div class="col">
                <img src="{{$logo_img}}" alt="عکس پیدا نشد" width="100%">
            </div>
        </div>

        <div class="form-group">
            <label for="input_body">توضیحات :</label>
            <textarea class="form-control" name="description" id="input_body"
                      required>{{$brand['description']}}</textarea>
        </div>

        <input type="submit" class="btn btn-primary" value="بروزسانی"/>
    </form>

    <form action="{{route('admin/dash/brand/destroy')}}" method="post">
        <input type="hidden" name="id_brand" value="{{$brand['id']}}}">
        <input type="submit" class="btn btn-danger m-2" value="حذف برند">
    </form>
@endsection