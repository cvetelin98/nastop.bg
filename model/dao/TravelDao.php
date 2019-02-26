<?php

namespace model\dao;

use model\Travel;

class TravelDao {

    public static function addTravel(Travel $travel){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("INSERT INTO travels (starting_destination,final_destination,date_of_travelling,free_places,price) 
                                        VALUES (?,?,?,?,?)");
        $stmt->execute([$travel->getStartingDestination(),$travel->getFinalDestination(),$travel->getDateOfTravelling(),$travel->getFreePlaces(),$travel->getPrice()]);
        $travel->setTravelId($pdo->lastInsertId());
    }

    public static function getAll(){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT travel_id,starting_destination,final_destination,date_of_travelling,free_places,price FROM travels");
        $stmt->execute();
        $travels = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $travel = new Travel($row->getStartingDestination(),$row->getFinalDestination(),$row->getDateOfTravelling(),$row->getFreePlaces(),$row->getPrice());
            $travel = $travel->setTravelId($row->travel_id);
            $travels[] = $travel;
        }
        return $travels;
    }

}

