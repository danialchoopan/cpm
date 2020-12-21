@extends('admin.template.admin')
@section('title','بروزسانی شرایط')
@section('title_content','بروزسانی')
@section('content')
    <a href="{{route('admin/dash/conditions')}}" class="btn btn-warning">بازگشت به لیست شرایط ها </a>
    <form method="post" action="{{route("admin/dash/conditions/$condition[id]/update")}}">
        <div class="form-group">
            <label for="input_title">نام:</label>
            <input type="text" class="form-control" id="input_title" name="name"
                   value="{{$condition['name']}}"
                   required>
        </div>

        <div class="form-group">
            <label for="input_body">توضیحات :</label>
            <textarea class="form-control" name="description" id="input_body"
                      required>{{$condition['description']}}</textarea>
        </div>

        <input type="submit" class="btn btn-primary" value="برورسانی"/>
    </form>


    <form action="{{route('admin/dash/conditions/destroy')}}" method="post">
        <input type="hidden" name="condition_id" value="{{$condition['id']}}}">
        <input type="submit" class="btn btn-danger m-2" value="حذف شرایط">
    </form>
@endsection