<?php


namespace App\database\model;


class ApplyCar
{
    private $id;
    private $user_id;
    private $car_id;
    private $condition_id;
    private $msg;
    private $n_code;
    private $status;
    private $account_number;

    /**
     * @return mixed
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    /**
     * @param mixed $account_number
     */
    public function setAccountNumber($account_number)
    {
        $this->account_number = $account_number;
    }
    private $created_at;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getCarId()
    {
        return $this->car_id;
    }

    /**
     * @param mixed $car_id
     */
    public function setCarId($car_id)
    {
        $this->car_id = $car_id;
    }

    /**
     * @return mixed
     */
    public function getConditionId()
    {
        return $this->condition_id;
    }

    /**
     * @param mixed $condition_id
     */
    public function setConditionId($condition_id)
    {
        $this->condition_id = $condition_id;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getNCode()
    {
        return $this->n_code;
    }

    /**
     * @param mixed $n_code
     */
    public function setNCode($n_code)
    {
        $this->n_code = $n_code;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

}