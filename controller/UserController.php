<?php

namespace controller;

use model\dao\UserDao;
use model\User;

class UserController {

    public function register(){
        if (!isset($_POST["username"], $_POST["firstName"], $_POST["lastName"], $_POST["password"], $_POST["repass"],
            $_POST["age"], $_POST["gender"], $_POST["email"], $_POST["GSM"])) {
            throw new \Exception("Sorry, invalid data! - isset");
        }

        $username = $_POST["username"];
        $first_name = $_POST["firstName"];
        $last_name = $_POST["lastName"];
        $password = $_POST["password"];
        $password2 = $_POST["repass"];
        $age = $_POST["age"];
        $gender = $_POST["gender"];
        $email = $_POST["email"];
        $GSM = $_POST["GSM"];
        $temp_name = $_FILES["pic"]["tmp_name"];

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


        if (empty($username) || empty($first_name) || empty($last_name) || empty($password) || empty($password2)
            || empty($age) || empty($gender) || empty($email) || empty($GSM)) {
            throw new \Exception("Sorry, invalid data! - empty");
        }
        $user = new User($username, $first_name, $last_name, $gender, $age, $email, password_hash($password, PASSWORD_BCRYPT),
            $GSM, $image_url);

        $userDB = UserDao::getByUsername($username);
        if ($userDB != null) {
            throw new \Exception("User already exists!");
        } else {
            if ($password !== $password2) {
                throw new \Exception("Password mismatch");
            }
            if ($age < 16) {
                throw new \Exception("Invalid data - age");
            }
            UserDao::addUser($user);
        }
        var_dump($user);
    }

    public function login(){
        if (isset($_POST["logButton"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            /** @var User $user */
            $user = UserDao::getByUsername($username);
            if ($user == null) {
                echo "KYDE SME? NQMA POTREBITEL";
//                header("HTTP/1.1 401 Wrong Credentials");
                die();
                //include "../View/register.html";
            } else {
                if (!password_verify($password,$user->getPassword())) {
                   echo "KYDE SME? GRESHNA PAROLA";
//                    header("HTTP/1.1 401 Wrong Credentials");
                    die();
                    //include "../View/login.html";
                } else {
                    $_SESSION["user"] = $user;
                    $_SESSION["logged"] = true;
                    echo "Successful login - welcome, " . $user->getUsername();
                }
            }
        }
    }

    public function all(){
        $users = UserDao::getAll();
        echo json_encode($users);
    }

    public function edit(){


    }
}