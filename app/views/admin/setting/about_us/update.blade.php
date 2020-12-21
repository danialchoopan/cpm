@extends('admin.template.admin')
@section('title','تنظیمات عمومی')
@section('title_content','عمونی')
@section('content')
    @include('include.msg')

    <form method="post" action="{{route("admin/dash/setting/about_us")}}">
        <div class="form-group">
            <label>متن درباره ما :</label>
            <textarea class="form-control"
                      name="about_us"
                      required>{{$setting_general['about_us']}}</textarea>
        </div>
        <input type="submit" class="btn btn-primary btn-block" value="بروزسانی"/>
    </form>
@endsection
