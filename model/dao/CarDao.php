<?php

namespace model\dao;
use model\Car;

class CarDao{

    public static function add(Car $car){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];

        $query = "INSERT INTO cars(user_id, car_name, car_image, car_color, car_places) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$car->getUserId(), $car->getCarName(), $car->getCarImage(), $car->getCarColor(), $car->getCarPlaces()]);
        $car->setUserId($pdo->lastInsertId());
        $car->setCarId($pdo->lastInsertId());
    }


}