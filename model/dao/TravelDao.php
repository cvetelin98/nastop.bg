<?php

namespace model\dao;

use model\Travel;

class TravelDao {

    public static function getCityId($city_name){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];

        $stmt = $pdo->prepare("SELECT city_id FROM cities WHERE city_name = ?");
        $stmt->execute(array($city_name));
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row["city_id"];

    }

    public static function getCityName($city_id){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];

        $stmt = $pdo->prepare("SELECT city_name FROM cities WHERE city_id = ?");
        $stmt->execute(array($city_id));
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row["city_name"];

    }

    public static function addTravel(Travel $travel){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
            $stmt = $pdo->prepare("INSERT INTO travels (user_id,car_id,starting_destination,final_destination,date_of_travelling,free_places,price)
                                        VALUES (?,?,?,?,?,?,?)");
            $stmt->execute([
                $travel->getUserId(),
                $travel->getCarId(),
                self::getCityId($travel->getStartingDestination()),
                self::getCityId($travel->getFinalDestination()),
                $travel->getDateOfTravelling(),
                $travel->getFreePlaces(),
                $travel->getPrice()]);
            $travel->setTravelId($pdo->lastInsertId());

        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function getAll(){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT travel_id,user_id,car_id,start_c.city_name as starting_destination,final_c.city_name as final_destination,date_of_travelling,free_places,price 
                                          FROM travels as t 
                                          JOIN cities as start_c ON start_c.city_id = starting_destination
                                          JOIN cities as final_c ON final_c.city_id = final_destination");
        $stmt->execute();
        $travels = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $travel = new Travel($row->starting_destination,$row->final_destination,$row->date_of_travelling,$row->free_places,$row->price);
            $travel->setTravelId($row->travel_id);
            $travel->setCarId($row->car_id);
            $travels[] = $travel;
        }
        return $travels;
    }

    public static function getAllByUser($user_id){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT travel_id,t.user_id,t.car_id,starting_destination,final_destination,date_of_travelling,free_places,price,car_image FROM travels as t
										  JOIN cars as c ON c.user_id = t.user_id 
                                          JOIN users as u ON t.user_id = u.user_id WHERE u.user_id = ?");
        $stmt->execute(array($user_id));
        $travels = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $travel = new Travel($row->starting_destination,$row->final_destination,$row->date_of_travelling,$row->free_places,$row->price);
            $travel->setTravelId($row->travel_id);
            $travel->setUserId($row->user_id);
            $travel->setCarId($row->car_id);
            $travel->car_image = $row->car_image;
            $travels[] = $travel;
        }
        return $travels;
    }

    public static function getShared($user_id){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT t.travel_id,t.user_id,t.car_id,starting_destination,final_destination,date_of_travelling,free_places,price,car_image FROM users as u
                                          JOIN history as h ON h.user_id = u.user_id 
                                          JOIN travels as t ON h.travel_id = t.travel_id
                                          JOIN cars as c ON c.user_id = t.user_id
                                          WHERE t.user_id <> u.user_id AND u.user_id = ?");
        $stmt->execute(array($user_id));
        $travels = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $travel = new Travel($row->starting_destination,$row->final_destination,$row->date_of_travelling,$row->free_places,$row->price);
            $travel->setTravelId($row->travel_id);
            $travel->setUserId($row->user_id);
            $travel->setCarId($row->car_id);
            $travel->car_image = $row->car_image;
            $travels[] = $travel;
        }
        return $travels;
    }

    public static function getAllCities(){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT city_id,city_name FROM cities");
        $stmt->execute();
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $cities = [];
            foreach ($rows as $row) {
                $city["id"] = $row["city_id"];
                $city["name"] = $row["city_name"];
                $cities[] = $city;
        }
        return $cities;
    }

    public static function getTravel($travel_id){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];

        $stmt = $pdo->prepare("SELECT t.user_id,car_id,start_c.city_name as starting_destination,final_c.city_name as final_destination,date_of_travelling,free_places,price,username FROM travels as t 
                                          JOIN users as u ON t.user_id = u.user_id 
                                          JOIN cities as start_c ON start_c.city_id = starting_destination
                                          JOIN cities as final_c ON final_c.city_id = final_destination 
                                          WHERE travel_id =  ?");
        $stmt->execute(array($travel_id));
        $row = $stmt->fetch(\PDO::FETCH_OBJ);

        /** @var Travel $travel */
        $travel = new Travel($row->starting_destination,$row->final_destination,$row->date_of_travelling,$row->free_places,$row->price);
        $travel->setTravelId($travel_id);
        $travel->setUserId($row->user_id);
        $travel->setCarId($row->car_id);
        $travel->username = $row->username;

        return $travel;
    }

    public function bookTravel($travel_id){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("UPDATE travels SET free_places = free_places - 1 WHERE travel_id = ?");
            $stmt->execute([$travel_id]);
            $stmt = $pdo->prepare("INSERT INTO history (user_id,travel_id) VALUES (?,?);");
            $stmt->execute([$_SESSION["user_id"],$travel_id]);

            $pdo->commit();
            return true;
        }

        catch (\PDOException $e){
                echo "Problem - " . $e->getMessage();
                $pdo->rollBack();
                return false;
            }
    }

    public static function getPlaces($travel_id)
    {
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];

        $stmt = $pdo->prepare("SELECT free_places FROM travels WHERE travel_id = ?");
        $stmt->execute(array($travel_id));
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $row["free_places"];
    }

    public static function getTravelFromSearch($from, $to){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];

        try {
            $query = "SELECT travel_id,user_id,car_id,date_of_travelling,free_places,price 
                                          FROM travels as t 
                                          JOIN cities as start_c ON start_c.city_id = starting_destination
                                          JOIN cities as final_c ON final_c.city_id = final_destination WHERE start_c.city_name = ? AND final_c.city_name = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$from, $to]);
            $travels = [];
            while ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
                /** @var Travel $travel */
                $travel = new Travel($from, $to, $row->date_of_travelling, $row->free_places, $row->price);
                $travel->setCarId($row->car_id);
                $travel->setTravelId($row->travel_id);
                $travels[] = $travel;
            }

            return $travels;
        }
        catch(\PDOException $e){
            echo "Problem - " . $e->getMessage();
            $travels = [];
            return $travels;

        }
    }

    public static function getAllTo($to){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT travel_id,user_id,car_id,start_c.city_name as starting_destination,final_c.city_name as final_destination,date_of_travelling,free_places,price 
                                          FROM travels as t 
                                          JOIN cities as start_c ON start_c.city_id = starting_destination
                                          JOIN cities as final_c ON final_c.city_id = final_destination WHERE final_c.city_name = ?");
        $stmt->execute([$to]);
        $travels = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $travel = new Travel($row->starting_destination,$row->final_destination,$row->date_of_travelling,$row->free_places,$row->price);
            $travel->setTravelId($row->travel_id);
            $travel->setCarId($row->car_id);
            $travels[] = $travel;
        }
        return $travels;
    }

    public static function getAllFrom($from){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT travel_id,user_id,car_id,start_c.city_name as starting_destination,final_c.city_name as final_destination,date_of_travelling,free_places,price 
                                          FROM travels as t 
                                          JOIN cities as start_c ON start_c.city_id = starting_destination
                                          JOIN cities as final_c ON final_c.city_id = final_destination WHERE start_c.city_name = ?");
        $stmt->execute([$from]);
        $travels = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $travel = new Travel($row->starting_destination,$row->final_destination,$row->date_of_travelling,$row->free_places,$row->price);
            $travel->setTravelId($row->travel_id);
            $travel->setCarId($row->car_id);
            $travels[] = $travel;
        }
        return $travels;
    }

}