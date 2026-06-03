@extends('admin.template.admin')
@section('title', 'داشبورد مدیریت')
@section('title_content', 'آمار کلی سامانه')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 p-4 text-right" dir="rtl">
    <div class="bg-blue-50 border-r-4 border-blue-500 p-6 shadow-sm rounded-lg">
        <div class="text-blue-600 text-sm font-bold mb-2">تعداد کل آگهی‌ها</div>
        <div class="text-3xl font-black">{{ $count_cars }}</div>
    </div>
    <div class="bg-red-50 border-r-4 border-red-500 p-6 shadow-sm rounded-lg">
        <div class="text-red-600 text-sm font-bold mb-2">آگهی‌های تایید نشده</div>
        <div class="text-3xl font-black">{{ $count_pending_cars }}</div>
    </div>
    <div class="bg-green-50 border-r-4 border-green-500 p-6 shadow-sm rounded-lg">
        <div class="text-green-600 text-sm font-bold mb-2">تعداد کاربران</div>
        <div class="text-3xl font-black">{{ $count_users }}</div>
    </div>
    <div class="bg-yellow-50 border-r-4 border-yellow-500 p-6 shadow-sm rounded-lg">
        <div class="text-yellow-600 text-sm font-bold mb-2">نظرات منتظر بررسی</div>
        <div class="text-3xl font-black">{{ $count_reviews }}</div>
    </div>
    <div class="bg-purple-50 border-r-4 border-purple-500 p-6 shadow-sm rounded-lg">
        <div class="text-purple-600 text-sm font-bold mb-2">کل بازدیدها</div>
        <div class="text-3xl font-black">{{ $count_view }}</div>
    </div>
</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8 p-4 text-right" dir="rtl">
    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <h3 class="font-bold mb-4 text-gray-700">دسترسی سریع</h3>
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin/dash/cars/create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm transition hover:bg-blue-700">ثبت آگهی جدید</a>
            <a href="{{ route('admin/dash/users/add') }}" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm transition hover:bg-gray-700">افزودن کاربر</a>
            <a href="{{ route('admin/dash/cars') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition hover:bg-red-700">مدیریت آگهی‌ها</a>
        </div>
    </div>
    <div class="bg-white border rounded-xl p-6 shadow-sm">
        <h3 class="font-bold mb-4 text-gray-700">وضعیت سیستم</h3>
        <div class="text-sm text-gray-500">
            <p>نسخه اپلیکیشن: 2.0.0 (Modern MVC)</p>
            <p>وضعیت دیتابیس: متصل</p>
        </div>
    </div>
</div>
@endsection
