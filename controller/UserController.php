<?php

namespace controller;

use model\dao\UserDao;
use model\User;

class UserController
{

    public function register()
    {

        $validReg = false;
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
            header("Location: view/home.php");
        }
        if (!$validReg) {
            header("Location: view/register.html");

        }
    }

    public function login()
    {
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
                if (!password_verify($password, $user->getPassword())) {
                    echo "KYDE SME? GRESHNA PAROLA";
//                    header("HTTP/1.1 401 Wrong Credentials");
                    die();
                    //include "../View/login.html";
                } else {
                    $_SESSION["username"] = $user->getUsername();
                    $_SESSION["user_id"] = $user->getUserId();
                    $_SESSION["first_name"] = $user->getFirstName();
                    $_SESSION["last_name"] = $user->getLastName();
                    $_SESSION["gender"] = $user->getGender();
                    $_SESSION["age"] = $user->getAge();
                    $_SESSION["user_image"] = $user->getUserImage();
                    $_SESSION["total_vodet"] = $user->getTotalVoted();
                    $_SESSION["rating"] = $user->getRating();
                    $_SESSION["gsm"] = $user->getGsm();
                    $_SESSION["logged"] = true;
//                    echo "Successful login - welcome, " . $user->getUsername();
                    header("Location: view/home.php");
                }
            }
        }
    }

    public function all()
    {
        $users = UserDao::getAll();
        echo json_encode($users);
    }


    public function edit()
    {
        /** @var User $user */
        $user = UserDao::getByUsername($_SESSION["username"]);
        if(isset($_POST["GSM"])){
            $user->setGsm($_POST["GSM"]);
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
                if ($new_pass !== $new_conf) {
                    throw new \Exception("Sorry, new passwords - mismatch!");
                } else {
                    $new_pass = password_hash($new_pass, PASSWORD_BCRYPT);
                    $user->setPassword($new_pass);
                }
            }
        }

        if(isset($_FILES["pic"])){
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
    }


    public function logout()
    {
        session_destroy();
        header("Location: view/main.php");
    }
}