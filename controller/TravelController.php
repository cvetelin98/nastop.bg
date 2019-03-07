<?php

namespace controller;


use model\dao\CarDao;
use model\dao\TravelDao;
use model\dao\UserDao;
use model\Travel;

class TravelController
{

    public function viewAdd()
    {
        if ($_SESSION["logged"]) {
            $cities = TravelDao::getAllCities();
            $cars = UserDao::getUserCars($_SESSION["username"]);
            require "view/addTravel.php";
        } else require "view/login.html";
    }

    public function viewTravel()
    {
        if ($_SESSION["logged"]) {
            $travel = TravelDao::getTravel($_POST["travel_id"]);
            require "view/viewTravel.php";
        } else require "view/login.html";
    }

    public function viewTravelGlobal()
    {
        $travel = TravelDao::getTravel($_POST["travel_id"]);
        require "view/viewTravelGlobal.php";
    }

    public function add()
    {
        if ($_SESSION["logged"]) {
            if (!isset($_POST["starting_destination"], $_POST["final_destination"], $_POST["date_of_travelling"], $_POST["free_places"], $_POST["price"], $_POST["car"])) {
                throw new \Exception("Sorry, invalid data! - isset");
            }

            $user_id = $_SESSION["user_id"];
            $starting_destination = $_POST["starting_destination"];
            $final_destination = $_POST["final_destination"];
            $date_of_travelling = $_POST["date_of_travelling"];
            $free_places = $_POST["free_places"];
            $price = $_POST["price"];
            $car_id = $_POST["car"];

            if (empty($starting_destination) || empty($final_destination) || empty($date_of_travelling) || empty($free_places) || empty($price) || empty($car_id)) {
                throw new \Exception("Sorry, invalid data! - empty");
            }

            $travel = new Travel($starting_destination, $final_destination, $date_of_travelling, $free_places, $price);
            $travel->setUserId($user_id);
            $travel->setCarId($car_id);


            if (TravelDao::addTravel($travel)) {
                header("Location: index.php?target=User&action=viewHome");
            } else {
                // TODO error header;
            }
        } else require "view/login.html";
    }

    public function book()
    {
        $travel_id = $_POST["travel_id"];

        $result["answer"] = TravelDao::bookTravel($travel_id);
        $result["new_places"] = TravelDao::getPlaces($travel_id);

        echo json_encode($result);
    }
    

    public function search()
    {
        if (isset($_POST["from"], $_POST["to"])) {
            $from = $_POST["from"];
            $to = $_POST["to"];

            if (empty($from) || empty($to)) {
                throw new \Exception("Invalid data - empty");
            } else {
                /** @var Travel $travel */
             $travels = TravelDao::getTravelFromSearch($from, $to);
             require "view/main.php";

            }
        }
    }

}