@extends('admin.template.admin')
@section('title','نمایش خودرو ها')
@section('title_content','خودرو  ها')
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
        <div class="col text-center">
            <a class="mb-3 btn btn-primary d-block btn-lg" href="{{route('admin/dash/setting/general')}}">تنظیمات
                عمومی</a>
            <a class="mb-3 btn btn-primary d-block btn-lg" href="{{route('admin/dash/setting/about_us')}}">درباره ما</a>
            <a class="mb-3 btn btn-primary d-block btn-lg" href="{{route('admin/dash/setting/contact_us')}}">تماس با
                ما</a>
            <a class="mb-3 btn btn-primary d-block btn-lg"
               href="{{route('admin/dash/setting/edit/admin')}}">
                ویرایش اطلاعات</a>

        </div>
    </div>
@endsection
