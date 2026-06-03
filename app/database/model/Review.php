<?php

namespace App\database\model;

class Review
{
    private $id;
    private $car_id;
    private $user_id;
    private $comment;
    private $rating_condition;
    private $rating_price;
    private $created_at;

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getCarId() { return $this->car_id; }
    public function setCarId($car_id) { $this->car_id = $car_id; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }

    public function getComment() { return $this->comment; }
    public function setComment($comment) { $this->comment = $comment; }

    public function getRatingCondition() { return $this->rating_condition; }
    public function setRatingCondition($rating_condition) { $this->rating_condition = $rating_condition; }

    public function getRatingPrice() { return $this->rating_price; }
    public function setRatingPrice($rating_price) { $this->rating_price = $rating_price; }

    public function getCreatedAt() { return $this->created_at; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
}
