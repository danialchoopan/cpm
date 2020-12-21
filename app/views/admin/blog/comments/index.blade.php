@extends('admin.template.admin')
@section('title','نمایش کامنت ها')
@section('title_content','کامنت  ها')
@section('content')
    @include('include.msg')
    <div class="row m-3">
        <div class="col">
            <a href="{{route('admin/dash/blog/comment/status/0')}}" class="btn btn-warning btn-block">
                نمایش خوانده نشده ها
            </a>
        </div>
        <div class="col">
            <a href="{{route('admin/dash/blog/comment/status/1')}}" class="btn btn-success btn-block">
                نمایش تایید شده ها
            </a>
        </div>

        <div class="col">
            <a href="{{route('admin/dash/blog/comment/status/2')}}" class="btn btn-danger btn-block">
                نمایش رد شده ها
            </a>
        </div>
        <div class="col">
            <a href="{{route('admin/dash/blog/comment/search')}}" class="btn btn-primary btn-block">
                جستجو کامنت
            </a>
        </div>
    </div>
    <p class="text-primary text-center">همه نظرات</p>
    @if(count($comments)!=0)
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">کاربر</th>
                <th scope="col">پست</th>
                <th scope="col">خلاصه</th>
                <th scope="col">وضعیت</th>
                <th scope="col">ساخته شده در</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($comments as $comment)
                <?php
                $blog_adapter = new \App\database\adapter\BlogPostsAdapter();
                ?>
                <tr>
                    <th scope="row">{{$comment['id']}}</th>
                    <td>
                        <a href="{{route("admin/dash/user/show/$comment[user_id]")}}">
                            {{user_auth_id($comment['user_id'])['full_name']}}
                        </a>
                    </td>
                    <td>
                        <a href="{{route("admin/dash/posts/$comment[blogpost_id]/edit")}}">
                            {{$blog_adapter->find($comment['blogpost_id'])['title']}}
                        </a>
                    </td>
                    <td>{{substr($comment['content'],0,100)}} ...</td>
                    <td>@if($comment['confirmed']==1)
                            <span class="text-success">تایید شده</span>
                        @elseif($comment['confirmed']==2)
                            <span class="text-danger">رد شده</span>
                        @else
                            <span class="text-warning">خوانده نشده</span>
                        @endif</td>
                    <td>{{show_date_php($comment['created_at'])}}</td>
                    <td>
                        <a class="btn btn-success btn-block"
                           href="{{route("admin/dash/comment/$comment[id]/status/1")}}">
                            تایید فوری!
                        </a>
                        <a class="btn btn-danger btn-block"
                           href="{{route("admin/dash/comment/$comment[id]/status/2")}}">
                            رد کردن فوری!
                        </a>
                        <a class="btn btn-info btn-block"
                           href="{{route("admin/dash/blog/comment/$comment[id]")}}">
                            مشاهده
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-warning text-center">
            متاسفانه نظری برای نمایش وجود ندارد
        </div>
    @endif
@endsection
