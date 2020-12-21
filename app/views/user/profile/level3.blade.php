@extends('templates.for_content')
@section('title','تکمیل در خواست')
@section('content')
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-50 m-4">
            <div class="card">
                <div class="card-header">تکمیل در خواست</div>
                <div class="card-body">
                    <form method="post" action="{{route("profile/user/level/3/apply/$id_request")}}"
                          enctype="multipart/form-data">
                        @include('include.msg')
                        <div class="alert alert-info">
                            اطلاعات شما تایید شده است مدارک خواسته شده را بفرستید
                        </div>
                        <div class="form-group">
                            <label>عکس کارت ملی: </label>
                            <input type="file" class="form-control" name="card_meli_photo"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>عکس صفحه اول شناسنامه : </label>
                            <input type="file" class="form-control" name="shesname_photo"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>عکس برگه چک پر شده: </label>

                            <input type="file" class="form-control" name="check_photo"
                                   required>
                            <small class="form-text text-muted">
                                یک برگه چک به اطلاعات زیر پر نمایید و برای ما عکس آن را ارسال کنید کارشناسان ما پس از
                                تایید چک
                                برای دریافت آن با شما تماس خواهند گرفت
                            </small>
                            <small class="form-text text-warning">
                                مبلغ 120% قیمت خودرو انتخابی
                                <br>
                                در وجه : دانیال خودرو
                                <br>
                                تاریخ 15 ماه پس از امروز
                            </small>

                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="ثبت و تایید در خواست"/>
                        <small class="text-primary">پس از تایید این مرحله کارشناسان ما برای مراجعه حضوری با شما تماس
                            خواهند گرفت</small>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection