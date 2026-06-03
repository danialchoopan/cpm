@extends('admin.template.admin')
@section('title', 'مدیریت نظرات')
@section('title_content', 'نظرات و امتیازهای کاربران')
@section('content')
<div class="overflow-x-auto">
    <table class="w-full text-right border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-700 text-sm">
                <th class="p-3 border">کاربر</th>
                <th class="p-3 border">خودرو</th>
                <th class="p-3 border">نظر</th>
                <th class="p-3 border">امتیاز وضعیت</th>
                <th class="p-3 border">امتیاز قیمت</th>
                <th class="p-3 border">تاریخ</th>
                <th class="p-3 border">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews as $review)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3 border font-bold">{{ $review['full_name'] }}</td>
                    <td class="p-3 border text-sm text-blue-600">{{ $review['car_name'] }}</td>
                    <td class="p-3 border text-sm max-w-xs truncate">{{ $review['comment'] }}</td>
                    <td class="p-3 border text-center font-bold text-yellow-600">{{ $review['rating_condition'] }}</td>
                    <td class="p-3 border text-center font-bold text-yellow-600">{{ $review['rating_price'] }}</td>
                    <td class="p-3 border text-xs text-gray-500">{{ date('Y/m/d', $review['created_at']) }}</td>
                    <td class="p-3 border text-center">
                        <form action="{{ route('admin/dash/reviews/destroy') }}" method="POST" onsubmit="return confirm('آیا از حذف این نظر مطمئن هستید؟')">
                            <input type="hidden" name="id" value="{{ $review['id'] }}">
                            <button type="submit" class="text-red-500 hover:underline text-sm">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
