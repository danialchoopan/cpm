@extends('templates.for_content')
@section('title','باگشایی رمزعبور')
@section('content')
    <?php
    if (authUser()) {
        redirect(route(''));
    }
    ?>
    <div class="cp-container-content d-flex justify-content-center">
        <div class="w-50 m-4">
            <div class="card">
                <div class="card-header">بازگشایی رمز عبور</div>
                <div class="card-body">
                    <p class="form-text text-muted">یک رمز عبور جدید برای خود امتخاب کنید</p>
                    <form method="post" action="{{route("user/reset/password/$token")}}">
                        @include('include.msg')
                        <div class="form-group">
                            <label>رمز عبور: </label>
                            <input type="password" class="form-control" name="password"
                                   placeholder="******************* " required>
                        </div>
                        <div class="form-group">
                            <label>تکرار رمز عبور: </label>
                            <input type="password" class="form-control" name="re_password"
                                   placeholder="*******************" required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block" value="بازگشایی رمزعبور"/>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
