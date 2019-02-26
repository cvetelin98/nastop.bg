<?php

namespace model;

class Travel extends JsonObject {

    private $travel_id;
    private $starting_destination;
    private $final_destination;
    private $date_of_travelling;
    private $free_places;
    private $price;

    /**
     * Travel constructor.
     * @param $starting_destination
     * @param $final_destination
     * @param $date_of_travelling
     * @param $free_places
     * @param $price
     */
    public function __construct($starting_destination, $final_destination, $date_of_travelling, $free_places, $price)
    {
        $this->starting_destination = $starting_destination;
        $this->final_destination = $final_destination;
        $this->date_of_travelling = $date_of_travelling;
        $this->free_places = $free_places;
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getTravelId()
    {
        return $this->travel_id;
    }

    /**
     * @return mixed
     */
    public function getStartingDestination()
    {
        return $this->starting_destination;
    }

    /**
     * @return mixed
     */
    public function getFinalDestination()
    {
        return $this->final_destination;
    }

    /**
     * @return mixed
     */
    public function getDateOfTravelling()
    {
        return $this->date_of_travelling;
    }

    /**
     * @return mixed
     */
    public function getFreePlaces()
    {
        return $this->free_places;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $travel_id
     */
    public function setTravelId($travel_id)
    {
        $this->travel_id = $travel_id;
    }

}