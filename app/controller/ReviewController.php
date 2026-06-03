<?php

namespace App\controller;

use App\database\adapter\ReviewAdapter;
use App\database\model\Review;

class ReviewController
{
    public function store($car_id)
    {
        if (!authUser()) {
            set_message('برای ثبت نظر ابتدا باید وارد شوید', 'danger', false, true);
            redirect(route("car/show/$car_id"));
        }

        $comment = $_POST['comment'] ?? '';
        $rating_condition = $_POST['rating_condition'] ?? 0;
        $rating_price = $_POST['rating_price'] ?? 0;

        if (empty($comment)) {
            set_message('متن نظر نمی‌تواند خالی باشد', 'danger', false, true);
            redirect(route("car/show/$car_id"));
        }

        $review = new Review();
        $review->setCarId($car_id);
        $review->setUserId(authUser()['id']);
        $review->setComment(htmlspecialchars($comment));
        $review->setRatingCondition((int)$rating_condition);
        $review->setRatingPrice((int)$rating_price);

        $adapter = new ReviewAdapter();
        if ($adapter->insert($review)) {
            set_message('نظر شما با موفقیت ثبت شد', 'success', false, true);
        } else {
            set_message('خطا در ثبت نظر', 'danger', false, true);
        }

        redirect(route("car/show/$car_id"));
    }
}
