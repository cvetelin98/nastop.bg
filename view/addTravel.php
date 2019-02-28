<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>nastop</title>
    <link rel="stylesheet" href="../Style/style.css">
</head>
<body>
<header class="navHeader">
    <h1 class="smallHeader">Nastop.bg</h1>
    <div id="nav">
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="history.php">My Shared Travels</a></li>
            <li><a href="edit.php">Edit Profile</a></li>
            <li><a href="addCar.html">Add a Car</a></li>
            <li><a class="active" href="addTravel.php">Add a Travel</a></li>
            <li style="float:right"><a href="../index.php?target=User&action=logout">Log out</a></li>
            <!--TODO FIX LOGOUT EVERYWHERE!-->
        </ul>
    </div>
    <img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="100%" height="150px;">
</header>

<main id="logMain">
<!--    --><?php //if(UserDao::checkUs  erCars($_SESSION["username"])){ ?>
    <form action="../index.php?target=Travel&action=add" method="post" onsubmit="return validation()">
        <table id="loginTable">
            <tr>
                <td>Start:</td>
                <td><input type="text" name="starting_destination" id="starting_destination" required></td>
            </tr>
            <tr>
                <td>Final:</td>
                <td><input type="text" name="final_destination" id="final_destination" required></td>
            </tr>
            <tr>
                <td>Date:</td>
                <td><input type="date" name="date_of_travelling" id="date_of_travelling" required></td>
            </tr>
            <tr>
                <td>Free Places:</td>
                <td><input type="number" name="free_places" id="free_places" required></td>
            </tr>
            <tr>
                <td>Price:</td>
                <td><input type="number" name="price" id="price" required></td>
            </tr>
            <tr>
                <td colspan="3"><input type="submit" name="addButton" id="submit" value="Add"></td>
            </tr>
        </table>
    </form>
<!--    --><?php //}
//    else { ?>
<!--    <h1>You don't have car for sharing ! Sorry :( </h1>-->
<!--    --><?php //} ?>
</main>
<footer id="mainFooter">
    <h3 style="font-size: 30px;float:left;margin-left:55px;">You can always go nastop!</h3>
    <h3 style="font-size: 20px;float:left; margin-left:25px;">Nastop.bg е място, където се срещат шофьори със свободни места и желаещи да пътуват.
        Вие сте шофьор: Не плащайте сам цялото гориво! Споделете този разход с други хора!
        Желате да пътувате: Возете се удобно в кола на по-ниска цена от билет за автобус.</h3>
    <img src="https://prevozvalnik.bg/img/bulgaria-footer.png" style="margin-right: 25px">
    <h3 style="font-size: 15px;margin-right:55px;">Copyright 2019 © Nastop.bg</h3>
</footer>

<script>

    function validation(){
        if(validDest() && validDate() && validPlaceAndPrice()){
            return true;
        }
        else return false;

    }

    function validDest(){
        var start,final;
        start = document.getElementById("starting_destination").value;
        final = document.getElementById("final_destination").value;
        if(start == final){
            alert("Destinations must be different!");
            return false;
        }
        else return true;
    }

    function validDate(){
            var selectedText = document.getElementById('date_of_travelling').value;
            var selectedDate = new Date(selectedText);
            var now = new Date();
            if (selectedDate < now) {
                alert("Date must be in the future");
                return false;
        }
        else return true;
    }

    function validPlaceAndPrice(){
        var places,price;
        places = document.getElementById("free_places").value;
        price = document.getElementById("price").value;
        if(places < 0 || price < 0){
            if(places < 0) {
                alert("Places must be positive number!");
                return false;
            }
            if(price < 0) {
                alert("Price must be positive number! If you want to win something?");
                return false;
            }
        }
        else return true;
    }

</script>

</body>
</html>