<?php

namespace controller;

use model\dao\CarDao;
use model\dao\TravelDao;
use model\dao\UserDao;
use model\User;

class UserController
{

    public function addInSession(User $user)
    {

        $_SESSION["username"] = $user->getUsername();
        $_SESSION["user_id"] = $user->getUserId();
        $_SESSION["first_name"] = $user->getFirstName();
        $_SESSION["last_name"] = $user->getLastName();
        $_SESSION["gender"] = $user->getGender();
        $_SESSION["age"] = $user->getAge();
        $_SESSION["gsm"] = $user->getGsm();
        $_SESSION["user_image"] = $user->getUserImage();
        $_SESSION["total_voted"] = $user->getTotalVoted();
        $_SESSION["rating"] = $user->getRating();
        $_SESSION["logged"] = true;
        $validReg = true;
    }


    public function viewLogin()
    {
        require "view/login.html";
    }

    public function viewRegister()
    {
        require "view/register.html";
    }

    public function viewHistory()
    {
        $my_travels = TravelDao::getAllByUser($_SESSION["user_id"]);
        $guest_travels = TravelDao::getShared($_SESSION["user_id"]);
        if ($_SESSION["logged"]) {
            require "view/history.php";
        } else require "view/login.html";
    }

    public function viewHome()
    {
        $travels = TravelDao::getAll();
        $cities = TravelDao::getAllCities();
        if ($_SESSION["logged"]) {
            require "view/home.php";
        } else require "view/login.html";
    }

    public function viewProfile()
    {
        $cars = UserDao::getUserCars($_SESSION["username"]);
        $comments = UserDao::getCommentsToUser($_SESSION["username"]);
        $checkCars = UserDao::checkUserCars($_SESSION["username"]);
        $user_rating = UserDao::getRatingById($_SESSION["user_id"]);
        if ($_SESSION["logged"]) {
            require "view/profile.php";
        } else require "view/login.html";
    }

    public function viewProfileUser()
    {
        if (!isset($_POST["username"])) {
            require "view/pageNotFound.html";
        } else {
            $username = $_POST["username"];
            $user = UserDao::getByUsername($username);
            $user_id = $user->getUserId();
            $user_rating = UserDao::getRatingById($user_id);
            $cars = UserDao::getUserCars($username);
            $comments = UserDao::getCommentsToUser($username);
            $checkCars = UserDao::checkUserCars($username);
            if ($_SESSION["logged"]) {
                require "view/profileUser.php";
            } else {
                require "view/profileGuest.php";
            }
        }
    }

    public function viewEdit()
    {
        if ($_SESSION["logged"]) {
            require "view/edit.php";
        } else require "view/login.html";
    }

    public function register()
    {

        $validReg = false;
        if (!isset($_POST["username"], $_POST["firstName"], $_POST["lastName"], $_POST["password"], $_POST["repass"],
            $_POST["age"], $_POST["gender"], $_POST["email"], $_POST["GSM"])) {
            throw new \Exception("Sorry, invalid data! - isset");
        }

        $username = trim($_POST["username"]);
        $first_name = trim($_POST["firstName"]);
        $last_name = trim($_POST["lastName"]);
        $password = trim($_POST["password"]);
        $password2 = trim($_POST["repass"]);
        $age = trim($_POST["age"]);
        $gender = trim($_POST["gender"]);
        $email = trim($_POST["email"]);
        $GSM = trim($_POST["GSM"]);
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
            if(strlen($username) < 6 || strlen($username) > 15){
                throw new \Exception("Sorry, username is too short or too long!");
            }
            if ($password !== $password2 || strlen($password) < 6 || strlen($password) > 17)  {
                throw new \Exception("Password mismatch/too short/too long");
            }
            if ($age < 16 && !(is_int($age)) || $age > 105) {
                throw new \Exception("Invalid data - age");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception("Invalid data - email");
            }
            if (strlen($GSM) < 10 || strlen($GSM) > 15) {
                throw new \Exception("Invalid data - gsm");
            }
            UserDao::addUser($user);
            self::addInSession($user);

            $travels = TravelDao::getAll();

            header("Location: index.php?target=User&action=viewHome");
        }
        if (!$validReg) {
            require "view/register.html";

        }
    }

    public function login()
    {
        if (isset($_POST["logButton"])) {
            if (!empty($_POST["username"] && !empty($_POST["password"]))) {
                $username = $_POST["username"];
                $password = $_POST["password"];


                /** @var User $user */
                $user = UserDao::getByUsername($username);
                if ($user == null) {
//                    echo "KYDE SME? NQMA POTREBITEL";
                header("HTTP/1.1 401 Wrong Credentials");
                    die();
                    //include "../View/register.html";
                } else {
                    if (!password_verify($password, $user->getPassword())) {
//                        echo "KYDE SME? GRESHNA PAROLA";
                    header("HTTP/1.1 401 Wrong Credentials");
                        die();
                        //include "../View/login.html";
                    } else {
                        self::addInSession($user);
//                    echo "Successful login - welcome, " . $user->getUsername();
                        $travels = TravelDao::getAll();
//                    require "view/home.php";
                        header("Location: index.php?target=User&action=viewHome");
                    }
                }
            }
        } else {
            require "view/login.html";
        }
    }

    public function edit()
    {
        if ($_SESSION["logged"]) {
            /** @var User $user */
            $user = UserDao::getByUsername($_SESSION["username"]);
            if (isset($_POST["GSM"])) {
                $gsm = $_POST["GSM"];
                if(!(empty($gsm))){
                    if(strlen($gsm) < 10 || strlen($gsm) > 15){
                        throw new \Exception("Soryy, invalid phone number!");
                    }else{
                        $user->setGsm($_POST["GSM"]);
                    }
                }
            }

            if (isset($_POST["cur_pass"], $_POST["new_pass"], $_POST["new_conf"])) {
                $cur_pass = $_POST["cur_pass"];
                $new_pass = $_POST["new_pass"];
                $new_conf = $_POST["new_conf"];
                $pass_db = $user->getPassword();

                if (!(empty($cur_pass) || empty($new_pass) || empty($new_conf))) {
                    if (!password_verify($cur_pass, $pass_db)) {
                        throw new \Exception("Sorry, invalid password!");
                    }
                    if ($new_pass !== $new_conf || strlen($new_pass) < 6 || strlen($new_pass) > 17) {
                        throw new \Exception("Sorry, new passwords - mismatch!");
                    } else {
                        $new_pass = password_hash($new_pass, PASSWORD_BCRYPT);
                        $user->setPassword($new_pass);
                    }
                }
            }

            if (isset($_FILES["pic"])) {
                $temp_name = $_FILES["pic"]["tmp_name"];

                if (is_uploaded_file($temp_name)) {
                    $filename = time();
                    if (move_uploaded_file($temp_name, "images/$filename")) {
                        $image_url = "images/$filename";
                        $user->setImage($image_url);

                    } else {
                        throw new \Exception("File is not moved!");
                    }
                }
            }

            UserDao::updateUser($user);
            $_SESSION["gsm"] = $user->getGsm();
            $_SESSION["user_image"] = $user->getUserImage();
            header("Location: index.php?target=User&action=viewProfile");
        } else require "view/login.html";
    }

    public function logout()
    {
        session_destroy();
        $travels = TravelDao::getAll();
        require "view/main.php";
    }

    public function comment()
    {
        if (isset($_POST["comment"], $_POST["to_user"])) {
            $comment = $_POST["comment"];
            $to_user = $_POST["to_user"];

            if (!empty($comment) && !empty($to_user)) {
                $result["answer"] = UserDao::sendComment($comment, $to_user);
                $result["new_comments"] = UserDao::getComments(UserDao::getUsernameById($to_user));
                $result["from_user"] = $_SESSION["username"];
            } else {
                $result["answer"] = false;
            }
        } else {
            $result["answer"] = false;
        }
        echo json_encode($result);
    }

    public function rateUser()
    {

        if (isset($_POST["user_id"], $_POST["rate"])) {
            $to_user = $_POST["user_id"];
            $rate = $_POST["rate"];
            $from_user = $_SESSION["user_id"];
            $voted = UserDao::getVoteById($to_user, $from_user);

            if (!$voted) {
                if (!empty($to_user) && !empty($rate)) {
                    $result["answer"] = UserDao::addRate($from_user, $to_user, $rate);
                    $result["new_rating"] = UserDao::getRatingById($to_user);
                } else {
                    $result["answer"] = false;
                }
            }else {
                $result["answer"] = false;
            }
        } else {
            $result["answer"] = false;
        }
        echo json_encode($result);
    }


}


