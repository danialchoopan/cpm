@extends('templates.for_content')
@section('title','تکمیل در خواست')
@section('content')
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-50 m-4">
            <div class="card">
                <div class="card-header">تکمیل در خواست</div>
                <div class="card-body">
                    <form method="post" action="{{route("car/show/$car_id/complete/request/store")}}">
                        @include('include.msg')
                        <div class="alert alert-info">
                            لطفا برای ثبت در خواست خود فرم زیر را پر نمایید کارشناسان ما بزودی با شما تماس خواهند گرفت
                        </div>
                        <p>نوع در خواست خرید :
                            {{show_condition_by_id($condition_id)['name']}} </p>
                        <div class="form-group">
                            <label>شماره ملی :</label>
                            <input type="text" class="form-control" name="n_code"
                                   placeholder="XXX-XXX-XXX"
                                   min="5"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>شماره حساب: </label>
                            <input type="text" class="form-control" name="account_number"
                                   placeholder="XXX-XXX-XXX-XXX" required>
                            <small class="form-text text-muted">شماره حساب برای برسی حساب شما</small>
                        </div>
                        <div class="form-group">
                            <label>پیام: </label>
                            <textarea type="text" class="form-control" name="body_msg" required></textarea>
                            <small class="form-text text-muted">توضیحاتی اگر داری وارد کنید</small>
                        </div>
                        <input type="hidden" name="condition_id" value="{{$condition_id}}">
                        <input type="submit" class="btn btn-primary btn-block" value="ثبت و تایید در خواست"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection