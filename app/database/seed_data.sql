-- CPM - سامانه خرید و فروش خودرو
-- بروزرسانی ساختار جداول و داده‌های اولیه

-- حذف جداول در صورت وجود (برای اجرای مجدد بدون خطا)
-- DROP TABLE IF EXISTS `reviews`;

-- بروزرسانی جدول خودروها
ALTER TABLE `car` ADD COLUMN `province` VARCHAR(100) DEFAULT NULL AFTER `description`;
ALTER TABLE `car` ADD COLUMN `city` VARCHAR(100) DEFAULT NULL AFTER `province`;
ALTER TABLE `car` ADD COLUMN `mileage` INT(11) DEFAULT 0 AFTER `city`;
ALTER TABLE `car` ADD COLUMN `year` INT(4) DEFAULT NULL AFTER `mileage`;
ALTER TABLE `car` ADD COLUMN `is_approved` TINYINT(1) DEFAULT 0 AFTER `is_car_open_for_sell`;

-- ساخت جدول نظرات و امتیازدهی
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `car_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `comment` TEXT COLLATE utf8mb4_persian_ci NOT NULL,
  `rating_condition` TINYINT(1) NOT NULL DEFAULT 0,
  `rating_price` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `car_id` (`car_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_persian_ci;

-- درج کاربران فرضی
INSERT INTO `users` (`full_name`, `password`, `email`, `phone_number`, `created_date`, `email_confrimed`, `phone_confrimed`) VALUES
('احمد محمدی', 'e10adc3949ba59abbe56e057f20f883e', 'ahmad@example.com', '09121112233', 1672531200, 1, 1),
('سارا علوی', 'e10adc3949ba59abbe56e057f20f883e', 'sara@example.com', '09122223344', 1672617600, 1, 1);

-- درج خودروهای فرضی با جزئیات جدید
INSERT INTO `car` (`brand_id`, `condition_id`, `photo_id`, `name`, `description`, `province`, `city`, `mileage`, `year`, `price`, `is_car_open_for_sell`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'پژو ۲۰۶ تیپ ۵', 'فنی کاملاً سالم، بدون رنگ، لاستیک‌ها نو', 'تهران', 'تهران', 45000, 1398, '۴۵۰۰۰۰۰۰۰', 1, 1, 1672704000, 1672704000),
(2, 1, 2, 'تویوتا کمری ۲۰۱۸', 'فول آپشن، بسیار تمیز، سرویس‌ها منظم انجام شده', 'فارس', 'شیراز', 30000, 2018, '۳۲۰۰۰۰۰۰۰۰', 1, 1, 1672790400, 1672790400),
(1, 2, 3, 'سمند LX', 'کارکرد بالا، نیاز به سرویس جزئی، قیمت مناسب', 'اصفهان', 'اصفهان', 120000, 1395, '۲۸۰۰۰۰۰۰۰', 1, 0, 1672876800, 1672876800);

-- درج نظرات و امتیازها
INSERT INTO `reviews` (`car_id`, `user_id`, `comment`, `rating_condition`, `rating_price`, `created_at`) VALUES
(1, 1, 'خودروی بسیار تمیزی بود، واقعاً راضی هستم.', 5, 4, 1672963200),
(1, 2, 'قیمت کمی بالاست ولی وضعیت خودرو عالی است.', 5, 3, 1673049600),
(2, 1, 'رویای من! کیفیت ساخت عالی.', 5, 5, 1673136000);
