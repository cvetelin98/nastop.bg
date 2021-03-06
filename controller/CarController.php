<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 26.2.2019 г.
 * Time: 15:44
 */

namespace controller;

use model\Car;
use model\dao\CarDao;

class CarController{

    public function viewAdd(){
        if($_SESSION["logged"]) {
            require "view/addCar.html";
        }
        else require "view/login.html";
    }

    public function add(){
        if($_SESSION["logged"]) {
            if (!isset($_POST["brand"], $_POST["color"])) {
                throw new \Exception("Sorry, invalid data! - isset");
            }

            $brand = $_POST["brand"];
            $color = $_POST["color"];
            $places = $_POST["car_places"];
            $user_id = $_SESSION["user_id"];
            $temp_name = $_FILES["car_image"]["tmp_name"];

            if (is_uploaded_file($temp_name)) {
                $filename = time();
                if (move_uploaded_file($temp_name, "images/$filename")) {
                    $image_url = "images/$filename";
                } else {
                    throw new \Exception("File is not moved!");
                }
            } else {
                throw new \Exception("File is not upload!");
            }

            if (empty($brand) || empty($color) || empty($image_url)) {
                throw new \Exception("Sorry, invalid data! - empty");
            }
            if(is_int($brand) || is_int($color)){
                throw new \Exception("The field - brand/color is invalid");
            }
            if(strlen($brand) > 15 || strlen($color) > 10){
                throw new \Exception("The field - brand/color is too long");
            }
            if(strlen($brand) < 3 || strlen($color) > 3){
                throw new \Exception("The field - brand/color is too short");
            }

            $car = new Car($user_id, $brand, $image_url, $color, $places);

            CarDao::add($car);
            header("Location: index.php?target=User&action=viewProfile");
        }
        else require "view/login.html";
    }

    public function getPlaces(){
        $car = $_POST["car"];
        $answer["real_places"] = CarDao::getPlaces($car);
        echo json_encode($answer);
    }

}