<?php

namespace model\dao;

use model\User;
use model\Car;

class UserDao {

    public static function addUser(User $user){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("INSERT INTO users (username,first_name,last_name,gender,age,email,password,GSM,user_image) 
                                        VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$user->getUsername(),$user->getFirstName(),$user->getLastName(),$user->getGender(),$user->getAge(),$user->getEmail(),$user->getPassword(),$user->getGsm(),$user->getUserImage()]);
        $user->setUserId($pdo->lastInsertId());
    }

    public static function getByUsername($username){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT user_id,first_name,last_name,gender,age,email,password,GSM,user_image,rating
                                        FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $user = new User($username,$row->first_name,$row->last_name,$row->gender,$row->age,$row->email,$row->password,$row->GSM,$row->user_image);
            $user->setUserId($row->user_id);
            $user->setRating($row->rating);
            return $user;
        }
        else{
            return null;
        }
    }

    public static function getUsernameById($user_id){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT username FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        if($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            return $row->username;
        }
        else{
            return null;
        }
    }

    public static function updateUser(User $user){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];

        $query = "UPDATE users SET GSM = ?, password = ?, user_image = ? WHERE user_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user->getGsm(), $user->getPassword(), $user->getUserImage(), $_SESSION["user_id"]]);

    }

    public static function checkUserCars($username){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT car_id FROM cars as c JOIN users as u ON c.user_id = u.user_id 
                                        WHERE u.username = ?");
        $stmt->execute([$username]);
        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function getUserCars($username){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT car_id,c.user_id,car_name,car_image,car_color,car_places FROM cars as c JOIN users as u ON c.user_id = u.user_id 
                                        WHERE u.username = ?");
        $stmt->execute([$username]);
        $cars = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            /** @var Car $car */
            $car = new Car($row->user_id,$row->car_name,$row->car_image,$row->car_color,$row->car_places);
            $car->setCarId($row->car_id);
            $cars[] = $car;
        }
        return $cars;
    }

    public static function getCommentsToUser($username){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT comment,from_user FROM comments as c JOIN users as u ON c.to_user = u.user_id 
                                        WHERE u.username = ?");
        $stmt->execute([$username]);
        $comments = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $comment["comment"] = $row->comment;
            $comment["from_user"] = UserDao::getUsernameById($row->from_user);
            $comments[] = $comment;
        }
        return $comments;
    }

    public static function getComments($username){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT comment FROM comments as c JOIN users as u ON c.to_user = u.user_id 
                                        WHERE u.username = ?");
        $stmt->execute([$username]);
        $comments = [];
        while($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $comment = $row["comment"];
            $comments[] = $comment;
        }
        return $comments;
    }

    public function sendComment($comment,$to_user){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("INSERT INTO comments (comment,from_user,to_user) VALUES (?,?,?)");
        $from_user = self::getByUsername($_SESSION["username"]);
        $stmt->execute([$comment,$from_user->getUserId(),$to_user]);

        if($stmt->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public static function getUserTravels($user_id){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT t.travel_id FROM users as u JOIN history as h ON h.user_id = u.user_id JOIN travels as t ON h.travel_id = t.travel_id WHERE t.user_id <> u.user_id AND u.user_id = ?");
        $stmt->execute([$user_id]);
        $user_travels = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $user_travels[] = $row->travel_id;
        }
        return $user_travels;
    }

    public static function addRate($from_user, $to_user, $rate){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        try {
            $pdo->beginTransaction();
            $queryRate = "INSERT INTO rates(from_id, to_id, vote) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($queryRate);
            $stmt->execute([$from_user, $to_user, $rate]);

            $querySum = "SELECT SUM(vote) AS sum FROM rates WHERE to_id = ? ";
            $stmt = $pdo->prepare($querySum);
            $stmt->execute([$to_user]);

            if($stmt->rowCount() != 0){
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                $sum = $row["sum"];

                $queryVoted = "UPDATE users SET total_voted = total_voted + 1 WHERE user_id = ?";
                $stmt = $pdo->prepare($queryVoted);
                $stmt->execute([$to_user]);

                $query = "SELECT total_voted FROM users WHERE user_id = ?";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$to_user]);

                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                $total_voted = $row["total_voted"];

                if ($total_voted !== 0){
                    $rate = $sum/$total_voted;
                }

                $queryUpdate = "UPDATE users SET rating = ROUND(?, 2) WHERE user_id = ?";
                $stmt = $pdo->prepare($queryUpdate);
                $stmt->execute([$rate, $to_user]);

                $pdo->commit();
                return true;

            }

        }catch(\PDOException $e){
            echo "Error -> ".$e->getMessage();
            $pdo->rollBack();
            return false;
        }

    }

    public static function getRatingById($user_id){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];

        $query = "SELECT rating FROM users WHERE user_id = ?";
        $stmt= $pdo->prepare($query);
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        $rating = $row["rating"];
        return $rating;
    }

    public static function getVoteById($to_user, $from_user){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];

        $query = "SELECT vote FROM rates WHERE from_id = ? AND to_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$from_user, $to_user]);
        $stmt->fetch(\PDO::FETCH_ASSOC);

        if($stmt->rowCount() != 0){
            return true;
        }else{
            return false;
        }
    }



}

