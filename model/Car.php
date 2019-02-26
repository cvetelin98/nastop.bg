<?php

namespace model;


class Car extends JsonObject{

    private $car_id;
    private $user_id;
    private $car_name;
    private $car_image;
    private $car_color;
    private $car_places;


    public function __construct($user_id, $car_name, $car_image, $car_color, $car_places)
    {
        $this->user_id = $user_id;
        $this->car_name = $car_name;
        $this->car_image = $car_image;
        $this->car_color = $car_color;
        $this->car_places = $car_places;
    }

    /**
     * @return mixed
     */
    public function getCarId()
    {
        return $this->car_id;
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
    public function getCarName()
    {
        return $this->car_name;
    }

    /**
     * @return mixed
     */
    public function getCarImage()
    {
        return $this->car_image;
    }

    /**
     * @return mixed
     */
    public function getCarColor()
    {
        return $this->car_color;
    }

    /**
     * @return mixed
     */
    public function getCarPlaces()
    {
        return $this->car_places;
    }

    /**
     * @param mixed $car_id
     */
    public function setCarId($car_id)
    {
        $this->car_id = $car_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }



}