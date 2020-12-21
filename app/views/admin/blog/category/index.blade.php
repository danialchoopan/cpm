@extends('admin.template.admin')
@section('title','نمایش دسته بندی ها')
@section('title_content','دسته بندی ها')
@section('content')
    @if(isset($_SESSION['msg_from_insert_status']))
        <?php
        $temp_session = flash_session('msg_from_insert_status');
        ?>
        <div class="alert alert-{{$temp_session['status']}}">
            {{$temp_session['msg']}}
        </div>
    @endif
    <div class="row">
        <div class="col-3">
            <form method="post" action="{{route('admin/dash/posts/categorys')}}">
                <div class="form-group">
                    <label for="input_name">نام دسته بندی :</label>
                    <input type="text" class="form-control" id="input_name" name="name" required>
                </div>
                <input type="submit" class="btn btn-primary" value="افزودن"/>
            </form>
        </div>
        <div class="col-9">
            @if(count($categorys)!=0)
                <table class="table table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">نام</th>
                        <th scope="col">ساخته شده در</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categorys as $category)
                        @if($category['id']!=1)
                            <tr>
                                <th scope="row">{{$category['id']}}</th>
                                <td>
                                    <a href="{{route("admin/dash/posts/categorys/$category[id]/edit")}}">{{$category['name']}}</a>
                                </td>
                                <td>{{show_date_php($category['created_at'])}}</td>
                                <td><a href="{{route("admin/dash/posts/categorys/$category[id]/destroy")}}"
                                       class="btn btn-danger">حدف</a></td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @else
                <h1 class="align-content-center">متاسفانه دسته بندی برای نمایش وجود ندارد</h1>
            @endif
        </div>
    </div>
@endsection