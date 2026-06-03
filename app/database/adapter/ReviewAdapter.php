<?php

namespace App\database\adapter;

use App\database\DatabaseConnection;
use App\database\model\Review;

class ReviewAdapter extends DatabaseConnection
{
    public function get_reviews_by_car_id($car_id)
    {
        $sql = "SELECT r.*, u.full_name FROM `reviews` r
                JOIN `users` u ON r.user_id = u.id
                WHERE r.car_id = ? ORDER BY r.created_at DESC";
        $db = $this->databaseConnection->prepare($sql);
        if ($db->execute([$car_id])) {
            return $db->fetchAll(2);
        }
        return [];
    }

    public function insert(Review $review)
    {
        $sql = "INSERT INTO `reviews` (`car_id`, `user_id`, `comment`, `rating_condition`, `rating_price`, `created_at`)
                VALUES (?, ?, ?, ?, ?, ?)";
        $db = $this->databaseConnection->prepare($sql);
        return $db->execute([
            $review->getCarId(),
            $review->getUserId(),
            $review->getComment(),
            $review->getRatingCondition(),
            $review->getRatingPrice(),
            time()
        ]);
    }

    public function get_average_ratings($car_id)
    {
        $sql = "SELECT AVG(rating_condition) as avg_condition, AVG(rating_price) as avg_price FROM `reviews` WHERE car_id = ?";
        $db = $this->databaseConnection->prepare($sql);
        $db->execute([$car_id]);
        return $db->fetch(2);
    }

    public function all()
    {
        $sql = "SELECT r.*, u.full_name, c.name as car_name FROM `reviews` r
                JOIN `users` u ON r.user_id = u.id
                JOIN `car` c ON r.car_id = c.id
                ORDER BY r.created_at DESC";
        $db = $this->databaseConnection->prepare($sql);
        $db->execute();
        return $db->fetchAll(2);
    }

    public function delete($id)
    {
        $db = $this->databaseConnection->prepare("DELETE FROM `reviews` WHERE id = ?");
        return $db->execute([$id]);
    }
}
