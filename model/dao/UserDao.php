<?php

namespace model\dao;

use model\User;

class UserDao {

    public static function addUser(User $user){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
//        $pdo = \DBConnection::getSingletonPDO();
        $stmt = $pdo->prepare("INSERT INTO users (username,first_name,last_name,gender,age,email,password,GSM,user_image) 
                                        VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$user->getUsername(),$user->getFirstName(),$user->getLastName(),$user->getGender(),$user->getAge(),$user->getEmail(),$user->getPassword(),$user->getGsm(),$user->getUserImage()]);
        $user->setUserId($pdo->lastInsertId());
    }

    public static function getByUsername($username){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
//        $pdo = \DBConnection::getSingletonPDO();
        $stmt = $pdo->prepare("SELECT user_id,first_name,last_name,gender,age,email,password,GSM,user_image
                                        FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
            $user = new User($username,$row->first_name,$row->last_name,$row->gender,$row->age,$row->email,$row->password,$row->GSM,$row->user_image);
            $user = $user->setUserId($row->user_id);
            return $user;
        }
        else{
            return null;
        }
    }

    public static function getAll(){
        /** @var \PDO $pdo */
        $pdo = $GLOBALS["PDO"];
//        $pdo = \DBConnection::getSingletonPDO();
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

}

