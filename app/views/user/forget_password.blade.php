@extends('templates.for_content')
@section('title','رمز عبور خود را فراموش کرده ام')
@section('content')
    <?php
    if (authUser()) {
        redirect(route(''));
    }
    ?>
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-50 m-4">
            <div class="card">
                <div class="card-header">رمز عبور خود را فراموش کرده ام</div>
                <div class="card-body">
                    <p class="form-text text-muted">پست الکترونیک خود راوارد کنید تا ریست پسورد برای شما ارسال
                        شود</p>
                    <form method="post" action="{{route('forget/password/user')}}">
                        @include('include.msg')
                        <div class="form-group">
                            <label>پست الکترونیک</label>
                            <input type="email" class="form-control" name="email"
                                   placeholder="example@example.com .. " required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="ارسال بازگشایی رمز عبور"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection