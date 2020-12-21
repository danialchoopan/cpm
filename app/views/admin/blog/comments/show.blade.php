@extends('admin.template.admin')
@section('title','نمایش کامنت ')
@section('title_content','کامنت')
@section('content')
    @include('admin.msg')
    <a href="{{route('admin/dash/blog/comments')}}"
       class="btn btn-warning btn-primary mb-3">بازگشت به بخش نظرات</a>

    <div class="form-group">
        <label>کاربر: </label>
        <?php
        $user_model = user_auth_id($comment['user_id']);
        $blog_adapter = new \App\database\adapter\BlogPostsAdapter();
        ?>
        <a href="{{route("admin/dash/user/show/$user_model[id]")}}">{{$user_model['full_name']}}</a>
    </div>
    <div class="form-group">
        <label>پست : </label>
        <a href="{{route("admin/dash/posts/$comment[blogpost_id]/edit")}}">
            {{$blog_adapter->find($comment['blogpost_id'])['title']}}
        </a>
    </div>

    <div class="form-group">
        <label>متن کامنت :</label>
        <p>
            {{$comment['content']}}
        </p>
    </div>

    <div class="row m-3">
        <div class="col">
            <a class="btn btn-success btn-block"
               href="{{route("admin/dash/comment/$comment[id]/status/1")}}">
                تایید
            </a>
        </div>
        <div class="col">
            <a class="btn btn-danger btn-block"
               href="{{route("admin/dash/comment/$comment[id]/status/2")}}">
                اسپم
            </a>
        </div>
    </div>
@endsection

