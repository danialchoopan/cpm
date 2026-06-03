<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ assets('css/tailwind.min.css') }}">
    <style>
        @font-face {
            font-family: 'Vazir';
            src: local('Vazir'), url("{{ assets('fonts/Vazir.woff2') }}") format('woff2');
        }
        body {
            font-family: 'Vazir', sans-serif;
        }
    </style>
    <title>@yield('title') | {{ get_setting()['site_name'] }}</title>
    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <nav class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('') }}" class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                        {{ get_setting()['site_name'] }}
                    </a>
                    <div class="hidden md:block mr-10 space-x-reverse space-x-4">
                        <a href="{{ route('') }}" class="hover:text-blue-500 transition">صفحه اصلی</a>
                        <a href="{{ route('car') }}" class="hover:text-blue-500 transition">آگهی‌ها</a>
                        <a href="{{ route('blog') }}" class="hover:text-blue-500 transition">بلاگ</a>
                    </div>
                </div>
                <div class="flex items-center space-x-reverse space-x-4">
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:ring-2 hover:ring-gray-300 transition">
                        <span class="dark:hidden">🌙</span>
                        <span class="hidden dark:inline">☀️</span>
                    </button>
                    @if(authUser())
                        <a href="{{ route('profile/user') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">پنل کاربری</a>
                        <a href="{{ route('admin/logout') }}" class="text-red-500 hover:underline">خروج</a>
                    @else
                        <button onclick="document.getElementById('login-modal').classList.remove('hidden')" class="text-blue-600 dark:text-blue-400 hover:underline">ورود / ثبت‌نام</button>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @include('include.msg')
