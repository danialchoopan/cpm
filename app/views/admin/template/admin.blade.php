<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{assets('css/style.css')}}">
    @include('include.cssbootstrap')
    <title>@yield('title')</title>
</head>
<body>
<div class="container-fluid cp-admin-container">
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
        <a class="navbar-brand" href="#">مدیریت سایت</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{authAdmin()['full_name']}}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('admin/logout')}}">خروج</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="row">
        {{--        menu--}}
        <div class="col-12 col-md-2">
            <div class="accordion" id="accordionExample">
                <ul>

                    <li class="cp-admin-menu" style="background-color: #9fcdff">
                        <a href="{{route('admin/dash')}}" style="color: black">داشبورد</a>
                    </li>

                    <li class="collapsed dropdown-toggle cp-admin-menu" data-toggle="collapse" data-target="#users_menu"
                        aria-expanded="false" aria-controls="collapseThree">
                        کاربران
                    </li>
                    <div id="users_menu" class="collapse" aria-labelledby="headingThree"
                         data-parent="#accordionExample">
                        <ul class="cp-admin-menu-ul">
                            <li><a href="{{route('admin/dash/users/show')}}">نمایش</a></li>
                            <li><a href="{{route('admin/dash/users/add')}}">افزودن</a></li>
                        </ul>
                    </div>

                    <li class="collapsed dropdown-toggle cp-admin-menu" data-toggle="collapse" data-target="#blog_menu"
                        aria-expanded="false" aria-controls="collapseThree" style="background-color: #8fd19e">
                        بلاگ
                    </li>
                    <div id="blog_menu" class="collapse" aria-labelledby="headingThree"
                         data-parent="#accordionExample">
                        <ul class="cp-admin-menu-ul">
                            <li><a href="{{route("admin/dash/posts")}}">نمایش پست ها</a></li>
                            <li><a href="{{route("admin/dash/posts/create")}}">افزودن پست</a></li>
                            <li><a href="{{route('admin/dash/posts/categorys')}}">درسته بندی ها</a></li>
                            <li><a href="{{route('admin/dash/blog/comments')}}">کامنت ها</a></li>
                        </ul>
                    </div>

                    <li class="collapsed dropdown-toggle cp-admin-menu" data-toggle="collapse" data-target="#car_menu"
                        aria-expanded="false" aria-controls="collapseThree" style="background-color: #adb5bd">
                        خودرو ها
                    </li>
                    <div id="car_menu" class="collapse" aria-labelledby="headingThree"
                         data-parent="#accordionExample">
                        <ul class="cp-admin-menu-ul">
                            <li><a href="{{route('admin/dash/cars')}}">نمایش</a></li>
                            <li><a href="{{route('admin/dash/cars/create')}}">افزودن</a></li>
                            <li><a href="{{route('admin/dash/brand')}}">برند</a></li>
                            <li><a href="{{route('admin/dash/conditions')}}">شرایط</a></li>
                        </ul>
                    </div>


                    <li class="cp-admin-menu" style="background-color: #8fd19e">
                        <a href="{{route('admin/dash/apply/car')}}" style="color: black">درخواست ها</a>
                    </li>
                    {{--                    <div id="car_menu2" class="collapse" aria-labelledby="headingThree"--}}
                    {{--                         data-parent="#accordionExample">--}}
                    {{--                        <ul class="cp-admin-menu-ul">--}}
                    {{--                            <li>نمایش</li>--}}
                    {{--                            <li>افزودن</li>--}}
                    {{--                        </ul>--}}
                    {{--                    </div>--}}

                    <li class="collapsed dropdown-toggle cp-admin-menu" data-toggle="collapse" data-target="#car_menu3"
                        aria-expanded="false" aria-controls="collapseThree" style="background-color: #8fd19e">
                        قسط ها
                    </li>
                    <div id="car_menu3" class="collapse" aria-labelledby="headingThree"
                         data-parent="#accordionExample">
                        <ul class="cp-admin-menu-ul">
                            <li><a href="{{route("admin/dash/gests")}}">نمایش</a></li>
                        </ul>
                    </div>

                    <li class="cp-admin-menu" style="background-color: #95999c">
                        <a href="{{route('admin/dash/view/status')}}" style="color: black">گزارش بازدید ها</a>
                    </li>

                    <li class="cp-admin-menu" style="background-color: #95999c">
                        <a href="{{route('admin/dash/setting')}}" style="color: black">تنظیمات سایت</a>
                    </li>


                </ul>
            </div>
        </div>
        {{--        content--}}
        <div class="col-12 col-md-10 cp-admin-content rtl" style="direction: rtl !important;">
            <div class="card w-100">
                <div class="card-header">
                    @yield('title_content')
                </div>
                <div class="p-3">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
@include('include.jsbootstrap')
</body>
</html>