-- CPM - سامانه خرید و فروش خودرو
-- بروزرسانی ساختار جداول و داده‌های اولیه

-- ساخت جدول برندها (اگر وجود نداشته باشد)
CREATE TABLE IF NOT EXISTS `brand` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `photo_id` INTEGER DEFAULT NULL,
  `name` TEXT NOT NULL,
  `description` TEXT,
  `created_at` INTEGER NOT NULL
);

-- ساخت جدول شرایط (اگر وجود نداشته باشد)
CREATE TABLE IF NOT EXISTS `conditions` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` TEXT NOT NULL,
  `description` TEXT,
  `created_at` INTEGER NOT NULL
);

-- ساخت جدول ادمین‌ها
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `full_name` TEXT NOT NULL,
  `username` TEXT NOT NULL,
  `password` TEXT NOT NULL,
  `phone_number` TEXT,
  `remmber_token` TEXT,
  `created_date` INTEGER NOT NULL
);

-- ساخت جدول کاربران
CREATE TABLE IF NOT EXISTS `users` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `full_name` TEXT NOT NULL,
  `password` TEXT NOT NULL,
  `email` TEXT NOT NULL,
  `phone_number` TEXT,
  `created_date` INTEGER NOT NULL,
  `email_confrimed` INTEGER DEFAULT 0,
  `phone_confrimed` INTEGER DEFAULT 0,
  `photo_id` INTEGER DEFAULT NULL,
  `remmber_token` TEXT,
  `validate_token` TEXT,
  `forget_pass_token` TEXT
);

-- ساخت جدول خودروها
CREATE TABLE IF NOT EXISTS `car` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `brand_id` INTEGER NOT NULL,
  `condition_id` INTEGER NOT NULL,
  `photo_id` INTEGER DEFAULT NULL,
  `name` TEXT NOT NULL,
  `description` TEXT,
  `province` TEXT,
  `city` TEXT,
  `mileage` INTEGER DEFAULT 0,
  `year` INTEGER,
  `price` TEXT,
  `is_car_open_for_sell` INTEGER DEFAULT 1,
  `is_approved` INTEGER DEFAULT 0,
  `created_at` INTEGER NOT NULL,
  `updated_at` INTEGER NOT NULL
);

-- ساخت جدول نظرات و امتیازدهی
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `car_id` INTEGER NOT NULL,
  `user_id` INTEGER NOT NULL,
  `comment` TEXT NOT NULL,
  `rating_condition` INTEGER DEFAULT 0,
  `rating_price` INTEGER DEFAULT 0,
  `created_at` INTEGER NOT NULL
);

-- ساخت جدول تصاویر
CREATE TABLE IF NOT EXISTS `photo` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` TEXT NOT NULL,
  `created_at` INTEGER NOT NULL
);

-- ساخت جدول تنظیمات
CREATE TABLE IF NOT EXISTS `site_setting` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `site_name` TEXT,
  `site_description` TEXT,
  `format_date` TEXT DEFAULT 'fa'
);

-- ساخت جدول بازدیدها
CREATE TABLE IF NOT EXISTS `website_views` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `ip` TEXT NOT NULL,
  `count_of_visit` INTEGER DEFAULT 1,
  `created_at` INTEGER NOT NULL
);

-- ساخت جدول بلاگ
CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `title` TEXT NOT NULL,
  `body` TEXT NOT NULL,
  `photo_id` INTEGER,
  `category_id` INTEGER,
  `created_at` INTEGER NOT NULL
);

-- درج داده‌های پایه
INSERT INTO `site_setting` (`site_name`, `site_description`, `format_date`) VALUES ('CPM - سامانه خودرو', 'بهترین پلتفرم خرید و فروش خودرو', 'fa');

INSERT INTO `brand` (`name`, `description`, `created_at`) VALUES
('پژو', 'خودروهای خانواده پژو فرانسه', 1672531200),
('تویوتا', 'برند ژاپنی با کیفیت جهانی', 1672531200);

INSERT INTO `conditions` (`name`, `description`, `created_at`) VALUES
('نقدی', 'پرداخت کامل در هنگام معامله', 1672531200),
('اقساطی', 'شرایط متنوع ۱۲ تا ۳۶ ماهه', 1672531200);

INSERT INTO `photo` (`name`, `created_at`) VALUES
('206.jpg', 1672531200),
('camry.jpg', 1672531200),
('samand.jpg', 1672531200);

-- درج ادمین فرضی
INSERT INTO `admins` (`full_name`, `username`, `password`, `created_date`) VALUES
('مدیر سیستم', 'admin', 'admin', 1672531200);

-- درج کاربران فرضی
INSERT INTO `users` (`full_name`, `password`, `email`, `phone_number`, `created_date`, `email_confrimed`, `phone_confrimed`) VALUES
('احمد محمدی', 'e10adc3949ba59abbe56e057f20f883e', 'ahmad@example.com', '09121112233', 1672531200, 1, 1),
('سارا علوی', 'e10adc3949ba59abbe56e057f20f883e', 'sara@example.com', '09122223344', 1672617600, 1, 1);

-- درج خودروهای فرضی
INSERT INTO `car` (`brand_id`, `condition_id`, `photo_id`, `name`, `description`, `province`, `city`, `mileage`, `year`, `price`, `is_car_open_for_sell`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'پژو ۲۰۶ تیپ ۵', 'فنی کاملاً سالم، بدون رنگ، لاستیک‌ها نو', 'تهران', 'تهران', 45000, 1398, '450000000', 1, 1, 1672704000, 1672704000),
(2, 2, 2, 'تویوتا کمری ۲۰۱۸', 'فول آپشن، بسیار تمیز، سرویس‌ها منظم انجام شده', 'فارس', 'شیراز', 30000, 2018, '3200000000', 1, 1, 1672790400, 1672790400),
(1, 2, 3, 'سمند LX', 'کارکرد بالا، نیاز به سرویس جزئی، قیمت مناسب', 'اصفهان', 'اصفهان', 120000, 1395, '280000000', 1, 0, 1672876800, 1672876800);

-- درج نظرات
INSERT INTO `reviews` (`car_id`, `user_id`, `comment`, `rating_condition`, `rating_price`, `created_at`) VALUES
(1, 1, 'خودروی بسیار تمیزی بود، واقعاً راضی هستم.', 5, 4, 1672963200),
(1, 2, 'قیمت کمی بالاست ولی وضعیت خودرو عالی است.', 5, 3, 1673049600),
(2, 1, 'رویای من! کیفیت ساخت عالی.', 5, 5, 1673136000);

-- درج پست بلاگ
INSERT INTO `blog_posts` (`title`, `body`, `photo_id`, `created_at`) VALUES
('راهنمای خرید خودرو کارکرده', 'در این مقاله به بررسی نکات مهم در هنگام خرید خودروی دست دوم می‌پردازیم...', 1, 1673222400);
