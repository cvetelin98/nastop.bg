<?php

namespace model\dao;

use model\User;

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
        $stmt = $pdo->prepare("SELECT user_id,first_name,last_name,gender,age,email,password,GSM,user_image
                                        FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $user = new User($username,$row->first_name,$row->last_name,$row->gender,$row->age,$row->email,$row->password,$row->GSM,$row->user_image);
            $user->setUserId($row->user_id);
            return $user;
        }
        else{
            return null;
        }
    }

    public static function getAll(){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
        $stmt = $pdo->prepare("SELECT user_id,username,first_name,last_name,gender,age,email,password,GSM,user_image,total_voted,rating FROM users");
        $stmt->execute();
        $users = [];
        while($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $user = new User($row->username,$row->first_name,$row->last_name,$row->gender,$row->age,$row->email,$row->password,$row->GSM,$row->user_image);
            $user = $user->setUserId($row->user_id);
            /** @var User $user */
            $user = $user->setTotalVoted($row->total_voted);
            $user = $user->setRating($row->rating);
            $user->removePass();
            $users[] = $user;
        }
        return $users;
    }

    public static function updateUser(User $user){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];

        $query = "UPDATE users SET GSM = ?, password = ?, user_image = ? WHERE user_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user->getGsm(), $user->getPassword(), $user->getUserImage(), $_SESSION["user_id"]]);

        if($stmt->rowCount() != 0){
            echo "success update";
        }else{
            echo "fail update";
        }
    }
}

