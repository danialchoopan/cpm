@extends('admin.template.admin')
@section('title', 'مدیریت آگهی‌ها')
@section('title_content', 'لیست کل آگهی‌های خودرو')
@section('content')
<div class="overflow-x-auto" dir="rtl">
    <table class="w-full text-right border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-700 text-sm">
                <th class="p-3 border">تصویر</th>
                <th class="p-3 border">نام خودرو</th>
                <th class="p-3 border">قیمت (تومان)</th>
                <th class="p-3 border">شهر</th>
                <th class="p-3 border">سال</th>
                <th class="p-3 border">تایید مدیر</th>
                <th class="p-3 border">وضعیت فروش</th>
                <th class="p-3 border">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $car)
                <?php
                $photo_adapter = new \App\database\adapter\PhotoAdapter();
                $car_photo = $photo_adapter->find($car['photo_id'])['name'] ?? 'default-car.jpg';
                ?>
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3 border">
                        <img src="{{ show_img_user($car_photo) }}" class="w-16 h-12 object-cover rounded">
                    </td>
                    <td class="p-3 border font-bold">{{ $car['name'] }}</td>
                    <td class="p-3 border">{{ number_format((float)$car['price']) }}</td>
                    <td class="p-3 border text-sm">{{ $car['city'] }}</td>
                    <td class="p-3 border text-sm">{{ $car['year'] }}</td>
                    <td class="p-3 border">
                        @if($car['is_approved'])
                            <span class="text-green-600 font-bold text-xs">تایید شده</span>
                        @else
                            <form action="{{ route('admin/dash/cars/approve') }}" method="POST">
                                <input type="hidden" name="id" value="{{ $car['id'] }}">
                                <button type="submit" class="bg-orange-500 text-white px-2 py-1 rounded text-xs hover:bg-orange-600 transition">تایید آگهی</button>
                            </form>
                        @endif
                    </td>
                    <td class="p-3 border">
                        @if($car['is_car_open_for_sell'])
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">فعال</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">غیرفعال</span>
                        @endif
                    </td>
                    <td class="p-3 border">
                        <div class="flex space-x-reverse space-x-2">
                            <a href="{{ route("admin/dash/cars/$car[id]/edit") }}" class="text-blue-500 hover:underline text-sm">ویرایش</a>
                            <form action="{{ route('admin/dash/cars/destroy') }}" method="POST" onsubmit="return confirm('آیا مطمئن هستید؟')">
                                <input type="hidden" name="id" value="{{ $car['id'] }}">
                                <button type="submit" class="text-red-500 hover:underline text-sm">حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
