@extends('admin.template.admin')
@section('title','تنظیمات عمومی')
@section('title_content','تماس با ما')
@section('content')
    @include('include.msg')

    <form method="post" action="{{route("admin/dash/setting/contact_us")}}">
        <div class="form-group">
            <label>متن تماس با ما :</label>
            <textarea class="form-control"
                      name="contact_us"
                      required>{{$setting_general['contact_us']}}</textarea>
        </div>
        <input type="submit" class="btn btn-primary btn-block" value="بروزسانی"/>
    </form>
@endsection
