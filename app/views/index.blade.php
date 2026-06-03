@include('templates.header')

<!-- Hero Section -->
<section class="relative bg-blue-700 text-white py-20 rounded-3xl overflow-hidden mb-12">
    <div class="absolute inset-0 opacity-20 bg-cover bg-center" style="background-image: url('{{ assets('img/hero-car.jpg') }}')"></div>
    <div class="relative z-10 text-center px-4">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-4">خرید و فروش آسان خودرو</h1>
        <p class="text-xl opacity-90 mb-8 max-w-2xl mx-auto">معتبرترین پلتفرم خرید خودرو با تحویل فوری و شرایط اقساطی استثنایی</p>
        <div class="flex justify-center space-x-reverse space-x-4">
            <a href="{{ route('car') }}" class="bg-white text-blue-700 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition shadow-lg">مشاهده آگهی‌ها</a>
            <a href="#search" class="bg-blue-600 border border-white px-8 py-3 rounded-full font-bold hover:bg-blue-500 transition shadow-lg">جستجوی پیشرفته</a>
        </div>
    </div>
</section>

<!-- Filter Section -->
<section id="search" class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl mb-12 -mt-16 relative z-20 border border-gray-100 dark:border-gray-700">
    <form action="{{ route('car') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">برند خودرو</label>
            <select name="brand_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2 focus:ring-blue-500">
                <option value="">همه برندها</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand['id'] }}" {{ ($filters['brand_id'] ?? '') == $brand['id'] ? 'selected' : '' }}>{{ $brand['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">شهر</label>
            <input type="text" name="city" value="{{ $filters['city'] ?? '' }}" placeholder="مثلاً تهران" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">حداقل قیمت (تومان)</label>
            <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">سال ساخت</label>
            <input type="number" name="year" value="{{ $filters['year'] ?? '' }}" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg p-2 focus:ring-blue-500">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">اعمال فیلتر</button>
        </div>
    </form>
</section>

<!-- Latest Ads -->
<section class="mb-16">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold border-r-4 border-blue-600 pr-4">آخرین آگهی‌های خودرو</h2>
        <a href="{{ route('car') }}" class="text-blue-600 dark:text-blue-400 hover:underline">مشاهده همه &larr;</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach(array_slice($cars, 0, 6) as $car)
            <?php
            $photo_adapter = new \App\database\adapter\PhotoAdapter();
            $car_photo = $photo_adapter->find($car['photo_id'])['name'] ?? 'default-car.jpg';
            ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition group border border-gray-100 dark:border-gray-700 text-right" dir="rtl">
                <div class="relative overflow-hidden">
                    <img src="{{ show_img_user($car_photo) }}" alt="{{ $car['name'] }}" class="w-full h-56 object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-4 left-4 bg-blue-600 text-white text-xs px-3 py-1 rounded-full">{{ $car['year'] }}</div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">{{ $car['name'] }}</h3>
                    <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm mb-4 space-x-reverse space-x-4">
                        <span>📍 {{ $car['city'] }}</span>
                        <span>🛣️ {{ number_format($car['mileage']) }} کیلومتر</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t dark:border-gray-700">
                        <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ number_format((float)$car['price']) }} تومان</span>
                        <a href="{{ route("car/show/$car[id]") }}" class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-600 hover:text-white transition">جزئیات</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Blog Section -->
<section class="mb-16">
    <h2 class="text-3xl font-bold mb-8 text-right">آخرین مقالات آموزشی</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-right" dir="rtl">
        @foreach($latest_posts as $post)
            <?php
            $photo_adapter = new \App\database\adapter\PhotoAdapter();
            $post_photo = $photo_adapter->find($post['photo_id'])['name'] ?? 'blog-default.jpg';
            ?>
            <a href="{{ route("blog/show/$post[id]") }}" class="group">
                <article class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow transition hover:shadow-lg border border-gray-100 dark:border-gray-700">
                    <img src="{{ show_img_user($post_photo) }}" class="w-full h-48 object-cover group-hover:opacity-90 transition">
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 group-hover:text-blue-500 transition">{{ $post['title'] }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2">{{ mb_substr(strip_tags($post['body']), 0, 100) }}...</p>
                    </div>
                </article>
            </a>
        @endforeach
    </div>
</section>

@include('templates.footer')
