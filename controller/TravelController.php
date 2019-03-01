<?php

namespace controller;


use model\dao\CarDao;
use model\dao\TravelDao;
use model\dao\UserDao;
use model\Travel;

class TravelController{

    public function viewAdd(){
        if($_SESSION["logged"]) {
            $cities = TravelDao::getAllCities();
            $cars = UserDao::getUserCars($_SESSION["username"]);
            require "view/addTravel.php";
        }
        else require "view/login.html";
    }

    public function add(){
        if($_SESSION["logged"]) {
            if (!isset($_POST["starting_destination"], $_POST["final_destination"], $_POST["date_of_travelling"], $_POST["free_places"], $_POST["price"])) {
                throw new \Exception("Sorry, invalid data! - isset");
            }

            $user_id = $_SESSION["user_id"];
            $starting_destination = $_POST["starting_destination"];
            $final_destination = $_POST["final_destination"];
            $date_of_travelling = $_POST["date_of_travelling"];
            $free_places = $_POST["free_places"];
            $price = $_POST["price"];

            if (empty($starting_destination) || empty($final_destination) || empty($date_of_travelling) || empty($free_places) || empty($price)) {
                throw new \Exception("Sorry, invalid data! - empty");
            }

            $travel = new Travel($starting_destination, $final_destination, $date_of_travelling, $free_places, $price);
            $travel->setUserId($user_id);


            if (TravelDao::addTravel($travel)) {
                require"view/home.php";
            } else {
                // TODO error header;
            }
        }
        else require "view/login.html";
    }

}