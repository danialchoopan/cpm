@extends('admin.template.admin')
@section('title','تنظیمات عمومی')
@section('title_content','عمونی')
@section('content')
    @if(isset($_SESSION['msg_from_insert_status']))
        <?php
        $temp_session = flash_session('msg_from_insert_status');
        ?>
        <div class="alert alert-{{$temp_session['status']}}">
            {{$temp_session['msg']}}
        </div>
    @endif

    <form method="post" action="{{route("admin/dash/setting/general/update")}}">
        <div class="form-group">
            <label for="input_title">نام وبسایت:</label>
            <input type="text" class="form-control" id="input_title" name="site_name"
                   value="{{$setting_general['site_name']}}"
                   required>
        </div>
        <div class="form-group">
            <label for="input_body">توضیحات وبسایت :</label>
            <textarea class="form-control" name="site_description" id="input_body"
                      required>{{$setting_general['site_description']}}</textarea>
        </div>

        <div class="form-group">
            <label>شماره تماس وبسایت:</label>
            <input type="text" class="form-control" name="phone_number"
                   value="{{$setting_general['phone_number']}}"
                   required>
        </div>

        <div class="form-group">
            <label>پست الکترونیک وبسایت:</label>
            <input type="text" class="form-control" name="email_admin"
                   value="{{$setting_general['email']}}"
                   required>
        </div>


        <div class="form-group">
            <fieldset>
                <legend>فرمت تاریخ</legend>
                <label>
                    تاریخ میلادی
                    <input type="radio" name="format_date"
                           @if($setting_general['format_date']=='en')
                           checked
                           @endif
                           value="en">
                </label>
                <label>
                    تاریخ شمسی
                    <input type="radio" name="format_date"
                           @if($setting_general['format_date']=='fa')
                           checked
                           @endif
                           value="fa">
                </label>
            </fieldset>
        </div>

        <div class="form-group">
            <label class="m-2 form-check">
                سایت باز است
                <input type="checkbox" name="site_is_disable"
                       @if($setting_general['site_is_disable']==1)
                       checked
                        @endif>
            </label>
            <label class="m-2 form-check">
                نام نویسی باز است
                <input type="checkbox" name="register_is_open"
                       @if($setting_general['register_is_open']==1)
                       checked
                        @endif>
            </label>
        </div>

        <input type="submit" class="btn btn-primary" value="بروزسانی"/>
    </form>
@endsection
