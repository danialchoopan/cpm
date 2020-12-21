<!doctype html>
<html lang="`fa`">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{assets('css/style.css')}}">
    <link rel="stylesheet" href="{{assets('css/bootstrap-rtl.min.css')}}">
    <title>ورود به بخش مدیریت</title>
</head>
<body>
<div class="cp-container-content d-flex justify-content-center" style="height: 100vh">
    <div class="w-50 m-4">
        <div class="card">
            <div class="card-header">ورود به بخش مدیریت</div>
            <div class="card-body">
                <form method="post" action="{{route('admin')}}">
                    @include('include.msg')
                    <div class="form-group">
                        <label>نام کاربری</label>
                        <input type="text" class="form-control" name="username"
                               style="text-align: left;direction: ltr"
                               placeholder="username" required>
                    </div>
                    <div class="form-group">
                        <label>گذرواژه</label>
                        <input type="password" class="form-control" name="password"
                               style="text-align: left;direction: ltr"
                               placeholder="****************" required>
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" value="ورود"/>
                </form>
            </div>
        </div>
    </div>
</div>

@include('include.jsbootstrap')
</body>
</html>


{{--<form action="{{route('admin')}}" method="post" style="border: 0">--}}
{{--    <h1>ورود به بخش مدیریت</h1>--}}
{{--    @include('include.msg')--}}
{{--    <label for="lgn-username-phone-input">نام کاربری : </label>--}}
{{--    <input type="text" name="username" id="lgn-username-phone-input" placeholder="username ..." required>--}}
{{--    <label for="lgn-password-input">رمز عبور : </label>--}}
{{--    <input type="password" name="password" id="lgn-password-input" placeholder="**** ..." required>--}}
{{--    <input type="submit" value="ورود">--}}
{{--</form>--}}
