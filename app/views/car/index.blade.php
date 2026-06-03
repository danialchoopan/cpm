@include('templates.header')

<section class="mb-8">
    <h1 class="text-3xl font-bold mb-4">آگهی‌های خودرو</h1>
    <nav class="flex text-gray-500 text-sm mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-reverse space-x-2">
            <li><a href="{{ route('') }}" class="hover:text-blue-600">خانه</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 dark:text-gray-100 font-bold">آگهی‌ها</li>
        </ol>
    </nav>
</section>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Sidebar Filters -->
    <aside class="lg:col-span-1 space-y-6">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md border border-gray-100 dark:border-gray-700">
            <h3 class="font-bold text-lg mb-4 pb-2 border-b dark:border-gray-700">فیلترهای جستجو</h3>
            <form action="{{ route('car') }}" method="GET" class="space-y-4">
                <div>
                    <label class="block text-sm mb-1">برند</label>
                    <select name="brand_id" class="w-full border rounded-lg p-2 dark:bg-gray-700 dark:border-gray-600">
                        <option value="">همه</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand['id'] }}" {{ ($filters['brand_id'] ?? '') == $brand['id'] ? 'selected' : '' }}>{{ $brand['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1">شهر</label>
                    <input type="text" name="city" value="{{ $filters['city'] ?? '' }}" class="w-full border rounded-lg p-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm mb-1">حداقل قیمت</label>
                    <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}" class="w-full border rounded-lg p-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm mb-1">حداکثر قیمت</label>
                    <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}" class="w-full border rounded-lg p-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <div>
                    <label class="block text-sm mb-1">سال ساخت</label>
                    <input type="number" name="year" value="{{ $filters['year'] ?? '' }}" class="w-full border rounded-lg p-2 dark:bg-gray-700 dark:border-gray-600">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-bold">اعمال فیلترها</button>
                <a href="{{ route('car') }}" class="block text-center text-sm text-gray-500 hover:text-red-500 mt-2">حذف فیلترها</a>
            </form>
        </div>
    </aside>

    <!-- Ad List -->
    <div class="lg:col-span-3">
        @if(empty($cars))
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-6 rounded-xl text-center">
                هیچ خودرویی با مشخصات انتخابی شما یافت نشد.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($cars as $car)
                    <?php
                    $photo_adapter = new \App\database\adapter\PhotoAdapter();
                    $car_photo = $photo_adapter->find($car['photo_id'])['name'] ?? 'default-car.jpg';
                    ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow transition hover:shadow-xl border border-gray-100 dark:border-gray-700 flex flex-col h-full">
                        <img src="{{ show_img_user($car_photo) }}" alt="{{ $car['name'] }}" class="w-full h-48 object-cover">
                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold">{{ $car['name'] }}</h3>
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $car['year'] }}</span>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ $car['description'] }}</p>
                            <div class="mt-auto space-y-3">
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 space-x-reverse space-x-4">
                                    <span>📍 {{ $car['city'] }}</span>
                                    <span>🛣️ {{ number_format($car['mileage']) }} ک‌م</span>
                                </div>
                                <div class="flex justify-between items-center pt-3 border-t dark:border-gray-700">
                                    <span class="text-green-600 dark:text-green-400 font-bold">{{ number_format((float)$car['price']) }} تومان</span>
                                    <a href="{{ route("car/show/$car[id]") }}" class="text-blue-600 font-semibold hover:underline">جزئیات بیشتر</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@include('templates.footer')
