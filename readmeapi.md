# مستندات فنی سامانه خرید و فروش خودرو CPM

این سند شامل جزئیات معماری داخلی و ساختار پایگاه داده پروژه CPM است.

## معماری پروژه
پروژه بر پایه معماری MVC (Model-View-Controller) بومی پیاده‌سازی شده است. هیچ فریم‌ورک خارجی برای بخش بک‌آند استفاده نشده است.

### ساختار پوشه‌ها
- **app/core**: هسته اصلی سیستم شامل کلاس‌های مسیردهی (Routing)، کنترلر پایه و مدیریت ویوها.
- **app/controller**: شامل منطق برنامه و پردازش درخواست‌ها.
- **app/database/model**: تعریف موجودیت‌های دیتابیس.
- **app/database/adapter**: لایه ارتباط با دیتابیس و اجرای کوئری‌ها با استفاده از PDO و Prepared Statements.
- **app/views**: قالب‌های فرانت‌آند (استفاده از موتور Blade محلی).
- **public/assets**: فایل‌های استاتیک شامل CSS، JS و تصاویر.

## ساختار پایگاه داده و روابط

### جدول کاربران (users)
ذخیره اطلاعات کاربران و ادمین‌ها.
- id (PK)
- full_name
- email
- password (MD5)
- phone_number
- created_date
- email_confrimed
- phone_confrimed

### جدول خودروها (car)
ذخیره اطلاعات آگهی‌های خودرو.
- id (PK)
- brand_id (FK)
- condition_id (FK)
- photo_id (FK)
- name
- description
- province (استان)
- city (شهر)
- mileage (کارکرد)
- year (سال ساخت)
- price
- is_car_open_for_sell
- is_approved (تایید مدیر)
- created_at
- updated_at

### جدول نظرات (reviews)
ثبت بازخورد کاربران برای هر خودرو.
- id (PK)
- car_id (FK -> car.id)
- user_id (FK -> users.id)
- comment (متن نظر)
- rating_condition (امتیاز فنی)
- rating_price (امتیاز قیمت)
- created_at

## مسیردهی (Routing)
مسیرهای سیستم در فایل `app/routes/web.php` تعریف شده‌اند. کلاس `App\core\Route` وظیفه مپ کردن URL به متد مربوطه در کنترلر را بر عهده دارد. تمامی درخواست‌ها ابتدا به `index.php` در پوشه public ارسال شده و سپس توسط روتور هدایت می‌شوند.

## امنیت
- تمامی ورودی‌ها در لایه مدل و آداپتور با استفاده از PDO تصفیه می‌شوند تا از SQL Injection جلوگیری شود.
- خروجی‌ها در ویوها جهت جلوگیری از XSS با استفاده از توابع تصفیه نمایش داده می‌شوند.
- سیستم تایید آگهی (Approval) جهت نظارت بر محتوای ورودی به سامانه تعبیه شده است.
