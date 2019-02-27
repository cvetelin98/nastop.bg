<?php

namespace model;

class User extends JsonObject {

    private $user_id;
    private $username;
    private $first_name;
    private $last_name;
    private $gender;
    private $age;
    private $email;
    private $password;
    private $gsm;
    private $user_image;
    private $total_voted;
    private $rating;

    /**
     * User constructor.
     * @param $username
     * @param $first_name
     * @param $last_name
     * @param $gender
     * @param $age
     * @param $email
     * @param $password
     * @param $gsm
     * @param $user_image
     */
    public function __construct($username, $first_name, $last_name, $gender, $age, $email, $password, $gsm, $user_image)
    {
        $this->username = $username;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->gender = $gender;
        $this->age = $age;
        $this->email = $email;
        $this->password = $password;
        $this->gsm = $gsm;
        $this->user_image = $user_image;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getGsm()
    {
        return $this->gsm;
    }

    /**
     * @return mixed
     */
    public function getUserImage()
    {
        return $this->user_image;
    }

    /**
     * @return mixed
     */
    public function getTotalVoted()
    {
        return $this->total_voted;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param mixed $total_voted
     */
    public function setTotalVoted($total_voted)
    {
        $this->total_voted = $total_voted;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
 * @param mixed $gsm
 */
    public function setGsm($gsm)
    {
        $this->gsm = $gsm;
    }

    /**
     * @param mixed $user_image
     */
    public function setImage($user_image)
    {
        $this->user_image = $user_image;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }



    public function removePass(){
        unset($this->password);
    }

}
