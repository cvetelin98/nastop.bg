<?php

namespace controller;

use model\dao\UserDao;
use model\User;

class UserController {

    public function register(){

    }

    public function login(){
        if (isset($_POST["logButton"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            /** @var User $user */
            $user = UserDao::getByUsername($username);
            if ($user == null) {
//                echo "KYDE SME? NQMA POTREBITEL";
                header("HTTP/1.1 401 Wrong Credentials");
                die();
                //include "../View/register.html";
            } else {
                if (!password_verify($user->getPassword(), $password)) {
                    $user = null;
//                    echo "KYDE SME? GRESHNA PAROLA";
                    header("HTTP/1.1 401 Wrong Credentials");
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
}