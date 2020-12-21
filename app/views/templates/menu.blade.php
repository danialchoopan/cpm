<nav class="cp-nav">
    <ul>
        <?php if(authAdmin()): ?>
        <li><a href="{{route('admin/dash')}}">ورود به بخش مدیریت</a></li>
        <?php endif; ?>
        <li><a href="{{route('')}}">خانه</a></li>
        <li><a href="{{route('car')}}">خودرو ها</a></li>
        <li><a href="{{route('blog')}}">بلاگ</a></li>
        <li><a href="{{route('about_us')}}">درباره ما</a></li>
        <li><a href="{{route('contact_us')}}">ارتباط با ما</a></li>
    </ul>
    <div class="cp-register-login mt-2">
        <?php if (authUser()):
        $user_auth = authUser();
//        if ($user_auth['phone_confrimed'] == 0) {
//            $redirect_url = "user/validate/phone";
//            if ($_SERVER['REQUEST_URI'] != "$_ENV[NAME]$redirect_url")
//                redirect(route($redirect_url));
//        }
        if ($user_auth['email_confrimed'] == 0) {
            $redirect_url = "user/validate/email";
            if ($_SERVER['REQUEST_URI'] != "$_ENV[NAME]$redirect_url")
                redirect(route($redirect_url));
        }
        ?>
        <a class="btn btn-outline-secondary" href="{{route('profile/user')}}">{{$user_auth['full_name']}}</a>
        <a class="btn btn-outline-danger" href="{{route('api/user/logout')}}">خروج</a>
        <?php else: ?>
        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#login_modal">
            ورود
        </button>
        <a href="{{route('register/user')}}" class="btn btn-outline-info mr-1">نام نویسی</a>
        {{--        <a id="btn-opn-login" class="cp-btn cp-btn-login">ورود</a>--}}
        {{--        <a id="btn-opn-register" class="cp-btn cp-btn-register">نام نویسی</a>--}}
        <?php endif; ?>
    </div>
    <div style="clear:both"></div>
</nav>

