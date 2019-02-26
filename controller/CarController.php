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

    public function add(){
        if (!isset($_POST["brand"], $_POST["color"])) {
            throw new \Exception("Sorry, invalid data! - isset");
        }

        $brand = $_POST["brand"];
        $color = $_POST["color"];
        $places = $_POST["car_places"];
        $user_id = $_SESSION["user"]->getUserId();
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

        $car = new Car($user_id, $brand, $image_url, $color, $places);

        CarDao::add($car);
    }


}