@extends('templates.for_content')
@section('title','نام نویسی')
@section('content')
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-50 m-4">
            <div class="card">
                <div class="card-header">نام نویسی</div>
                <div class="card-body">
                    <form method="post" action="{{route('register/user')}}">
                        @include('include.msg')
                        <div class="form-group">
                            <label>نام و نام خانوادگی </label>
                            <input type="text" class="form-control" name="full_name"
                                   placeholder="نام نام خانوادگی را وارد کنید ..."
                                   min="5"
                                   required>
                            <small class="form-text text-muted">نام و نام خانوادگی خود را وارد کنید</small>
                        </div>
                        <div class="form-group">
                            <label>پست الکترونیک</label>
                            <input type="email" class="form-control" name="email"
                                   placeholder="example@example.com" required>
                            <small class="form-text text-muted">ترجیحا از gmail استفاده کنید</small>
                        </div>
                        <div class="form-group">
                            <label>شماره همراه</label>
                            <input type="text" class="form-control" name="phone_number"
                                   min="10"
                                   placeholder="091* *** ****" required>
                            <small class="form-text text-muted">شماره همراه معتبر وارد کنید </small>
                        </div>
                        <div class="form-group">
                            <label>گذرواژه</label>
                            <input type="password" class="form-control" name="password"
                                   min="10"
                                   placeholder="****************" required>
                        </div>
                        <div class="form-group">
                            <label>تکرار گذرواژه</label>
                            <input type="password" class="form-control" name="re_password"
                                   min="10"
                                   placeholder="****************" required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="نام نویسی"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection