@include('templates.header')

<?php
$photo_adapter = new \App\database\adapter\PhotoAdapter();
$car_photo = $photo_adapter->find($car['photo_id'])['name'] ?? 'default-car.jpg';
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
    <!-- Car Info & Gallery -->
    <div class="lg:col-span-2 space-y-8">
        <section class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-700">
            <img src="{{ show_img_user($car_photo) }}" alt="{{ $car['name'] }}" class="w-full h-[500px] object-cover">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-4xl font-extrabold">{{ $car['name'] }}</h1>
                    <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ number_format((float)$car['price']) }} تومان</span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-2xl text-center">
                        <span class="block text-gray-500 text-xs mb-1">برند</span>
                        <span class="font-bold">{{ $brand['name'] }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-2xl text-center">
                        <span class="block text-gray-500 text-xs mb-1">سال ساخت</span>
                        <span class="font-bold">{{ $car['year'] }}</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-2xl text-center">
                        <span class="block text-gray-500 text-xs mb-1">کارکرد</span>
                        <span class="font-bold">{{ number_format($car['mileage']) }} ک‌م</span>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-2xl text-center">
                        <span class="block text-gray-500 text-xs mb-1">موقعیت</span>
                        <span class="font-bold">{{ $car['province'] }}، {{ $car['city'] }}</span>
                    </div>
                </div>

                <div class="prose dark:prose-invert max-w-none">
                    <h3 class="text-xl font-bold mb-4">توضیحات آگهی</h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $car['description'] }}</p>
                </div>
            </div>
        </section>

        <!-- Reviews Section -->
        <section class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-lg border border-gray-100 dark:border-gray-700">
            <h2 class="text-2xl font-bold mb-8">نظرات و امتیازها</h2>

            @if(authUser())
                <form action="{{ route("car/show/$car[id]/review") }}" method="POST" class="mb-12 bg-gray-50 dark:bg-gray-700 p-6 rounded-2xl">
                    <h3 class="font-bold mb-4">ثبت نظر جدید</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm mb-2">امتیاز به وضعیت خودرو (۱ تا ۵)</label>
                            <input type="range" name="rating_condition" min="1" max="5" class="w-full">
                        </div>
                        <div>
                            <label class="block text-sm mb-2">امتیاز به قیمت (۱ تا ۵)</label>
                            <input type="range" name="rating_price" min="1" max="5" class="w-full">
                        </div>
                    </div>
                    <textarea name="comment" rows="4" class="w-full border rounded-xl p-4 mb-4 dark:bg-gray-800 dark:border-gray-600" placeholder="نظر خود را در مورد این خودرو بنویسید..."></textarea>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">ارسال نظر</button>
                </form>
            @else
                <div class="bg-blue-50 dark:bg-blue-900 border border-blue-200 p-4 rounded-xl text-center mb-8 text-blue-800 dark:text-blue-100">
                    برای ثبت نظر ابتدا باید <button onclick="document.getElementById('login-modal').classList.remove('hidden')" class="font-bold underline">وارد شوید</button>.
                </div>
            @endif

            <div class="space-y-6">
                @foreach($reviews as $review)
                    <div class="border-b dark:border-gray-700 pb-6 last:border-0">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold">{{ $review['full_name'] }}</span>
                            <span class="text-gray-400 text-xs">{{ date('Y/m/d', $review['created_at']) }}</span>
                        </div>
                        <div class="flex space-x-reverse space-x-4 mb-3 text-xs text-yellow-500 font-bold">
                            <span>وضعیت: {{ $review['rating_condition'] }} از ۵</span>
                            <span>قیمت: {{ $review['rating_price'] }} از ۵</span>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">{{ $review['comment'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <!-- Sidebar / CTA -->
    <div class="lg:col-span-1">
        <div class="sticky top-24 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border-2 border-blue-500">
                <h3 class="text-xl font-bold mb-6 text-center text-blue-600">درخواست خرید</h3>
                <div class="text-center mb-8">
                    <p class="text-sm text-gray-500 mb-2">میانگین امتیاز وضعیت</p>
                    <div class="text-3xl font-black text-yellow-500">{{ number_format($avg_ratings['avg_condition'], 1) }} / ۵</div>
                </div>
                <form action="{{ route("car/show/$car[id]/complete/request") }}" method="POST">
                    <label class="block text-sm mb-2">انتخاب شرایط پرداخت:</label>
                    <select name="condition_id" class="w-full border rounded-xl p-3 mb-6 dark:bg-gray-700 dark:border-gray-600">
                        <option value="1">نقدی</option>
                        <option value="2">اقساط ۱۲ ماهه</option>
                        <option value="3">اقساط ۲۴ ماهه</option>
                    </select>
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 transition shadow-lg shadow-blue-200 dark:shadow-none">رزرو و ادامه</button>
                </form>
            </div>

            <div class="bg-gray-100 dark:bg-gray-700 rounded-3xl p-6 text-center">
                <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">تماس با کارشناس</p>
                <a href="tel:02112345678" class="text-xl font-bold hover:text-blue-600 transition">۰۲۱-۱۲۳۴۵۶۷۸</a>
            </div>
        </div>
    </div>
</div>

@include('templates.footer')
