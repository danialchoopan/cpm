@extends('admin.template.admin')
@section('title',' دسته بندی ها')
@section('title_content','برورسانی دسته')
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
        <div class="col">
            <form method="post" action="{{route("admin/dash/posts/categorys/$category[id]/update")}}">
                <div class="form-group">
                    <label for="input_name">نام دسته بندی :</label>
                    <input type="text" class="form-control" id="input_name" name="name" value="{{$category['name']}}"
                           required>
                </div>
                <input type="submit" class="btn btn-primary" value="برورسانی"/>
            </form>
        </div>
    </div>
@endsection