@extends('admin.template.admin')
@section('title','نمایش پست ها')
@section('title_content','پست  ها')
@section('content')
    @if(isset($_SESSION['msg_from_insert_status']))
        <?php
        $temp_session = flash_session('msg_from_insert_status');
        ?>
        <div class="alert alert-{{$temp_session['status']}}">
            {{$temp_session['msg']}}
        </div>
    @endif
    @if(count($posts)!=0)
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">عنوان</th>
                <th scope="col">دسته بندی</th>
                <th scope="col">نظرات</th>
                <th scope="col">ساخته شده در</th>
                <th scope="col">بروزرسانی شده در</th>
            </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <?php
                $categoryPostsBlogAdapter = new \App\database\adapter\CategoryPostsBlogAdapter();
                $blog_posts_adapter = new \App\database\adapter\BlogCommentAdapter();
                $post_comments = $blog_posts_adapter->post_comments($post['id'])
                ?>
                <tr>
                    <th scope="row">{{$post['id']}}</th>
                    <td>
                        <a href="{{route("admin/dash/posts/$post[id]/edit")}}">{{$post['title']}}</a>
                    </td>
                    <td>{{$categoryPostsBlogAdapter->find($post['category_id'])['name']}}</td>
                    <td><a href="{{route("admin/dash/posts/comments/$post[id]")}}"> تعداد
                            نظرات {{count($post_comments)}}</a></td>
                    <td>{{show_date_php($post['created_at'])}}</td>
                    <td>{{show_date_php($post['updated_at'])}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h3 class="align-content-center">متاسفانه پستی برای نمایش وجود ندارد</h3>
    @endif
@endsection
