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

    public static function addTravel(Travel $travel){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("INSERT INTO travels (user_id,starting_destination,final_destination,date_of_travelling,free_places,price)
                                        VALUES (?,?,?,?,?,?)");
        $stmt->execute([
            $travel->getUserId(),
            self::getCityId($travel->getStartingDestination()),
            self::getCityId($travel->getFinalDestination()),
            $travel->getDateOfTravelling(),
            $travel->getFreePlaces(),
            $travel->getPrice()]);
        $travel->setTravelId($pdo->lastInsertId());
    }

    public static function getAll(){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT travel_id,user_id,starting_destination,final_destination,date_of_travelling,free_places,price FROM travels");
        $stmt->execute();
        $travels = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $travel = new Travel($row->getStartingDestination(),$row->getFinalDestination(),$row->getDateOfTravelling(),$row->getFreePlaces(),$row->getPrice());
            $travel = $travel->setTravelId($row->travel_id);
            $travels[] = $travel;
        }
        return $travels;
    }

    public static function getAllByUser($username){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT travel_id,starting_destination,final_destination,date_of_travelling,free_places,price FROM travels as t 
                                          JOIN users as u ON t.user_id = u.user_id WHERE u.username = ?");
        $stmt->execute(array($username));
        $travels = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $travel = new Travel($row->getStartingDestination(),$row->getFinalDestination(),$row->getDateOfTravelling(),$row->getFreePlaces(),$row->getPrice());
            $travel = $travel->setTravelId($row->travel_id);
            $travels[] = $travel;
        }
        return $travels;
    }

}

