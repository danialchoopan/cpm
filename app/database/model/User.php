<?php


namespace App\database\model;


class User extends DataModel
{
    private $id;
    private $full_name;
    private $password;
    private $email;
    private $phone_number;
    private $created_date;
    private $remmber_token;
    private $validate_token;
    private $forget_pass_token;
    private $email_confrimed;
    private $phone_confrimed;

    /**
     * User constructor.
     * @param $id
     * @param $full_name
     * @param $password
     * @param $email
     * @param $phone_number
     * @param $created_date
     * @param $remmber_token
     * @param $validate_token
     * @param $forget_pass_token
     * @param $email_confrimed
     * @param $phone_confrimed
     */


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
    public function getFullName()
    {
        return $this->full_name;
    }

    /**
     * @param mixed $full_name
     */
    public function setFullName($full_name)
    {
        $this->full_name = $full_name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * @param mixed $phone_number
     */
    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return mixed
     */
    public function getCreatedDate()
    {
        return $this->created_date;
    }

    /**
     * @param mixed $created_date
     */
    public function setCreatedDate($created_date)
    {
        $this->created_date = $created_date;
    }

    /**
     * @return mixed
     */
    public function getRemmberToken()
    {
        return $this->remmber_token;
    }

    /**
     * @param mixed $remmber_token
     */
    public function setRemmberToken($remmber_token)
    {
        $this->remmber_token = $remmber_token;
    }

    /**
     * @return mixed
     */
    public function getValidateToken()
    {
        return $this->validate_token;
    }

    /**
     * @param mixed $validate_token
     */
    public function setValidateToken($validate_token)
    {
        $this->validate_token = $validate_token;
    }

    /**
     * @return mixed
     */
    public function getForgetPassToken()
    {
        return $this->forget_pass_token;
    }

    /**
     * @param mixed $forget_pass_token
     */
    public function setForgetPassToken($forget_pass_token)
    {
        $this->forget_pass_token = $forget_pass_token;
    }

    /**
     * @return mixed
     */
    public function getEmailConfrimed()
    {
        return $this->email_confrimed;
    }

    /**
     * @param mixed $email_confrimed
     */
    public function setEmailConfrimed($email_confrimed)
    {
        $this->email_confrimed = $email_confrimed;
    }

    /**
     * @return mixed
     */
    public function getPhoneConfrimed()
    {
        return $this->phone_confrimed;
    }

    /**
     * @param mixed $phone_confrimed
     */
    public function setPhoneConfrimed($phone_confrimed)
    {
        $this->phone_confrimed = $phone_confrimed;
    }


}