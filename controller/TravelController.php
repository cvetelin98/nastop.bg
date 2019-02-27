<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 26.2.2019 г.
 * Time: 15:44
 */

namespace controller;

use model\dao\TravelDao;
use model\Travel;

class TravelController{

    public function add(){
        if (!isset($_POST["starting_destination"], $_POST["final_destination"],$_POST["date_of_travelling"],$_POST["free_places"],$_POST["price"])) {
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

        $travel = new Travel($user_id,$starting_destination, $final_destination, $date_of_travelling, $free_places,$price);

        TravelDao::addTravel($travel);
    }


}