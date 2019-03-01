<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit</title>
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
            <li><a class="active" href="edit.php">Edit Profile</a></li>
            <li><a href="addCar.html">Add a Car</a></li>
            <li><a href="addTravel.php">Add a Travel</a></li>
            <li style="float:right"><a href="../index.php?target=User&action=logout">Log out</a></li>
            <!--TODO FIX LOGOUT EVERYWHERE!-->
        </ul>
    </div>
</header>
<img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="80%" height="150px;">
<main id="logMain">
<div>
    <h1 style="font-size: 5vh; text-align: center;">Edit your profile:</h1>
    <br>
    <form action="../index.php?target=User&action=edit" method="post" enctype="multipart/form-data">
        <table id="regTable">
            <tr>
                <td>GSM:</td>
                <td><input type="number" value="<?php echo $_SESSION["gsm"] ?>" name="GSM" value="" style="width: 50%;"></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td>Current password:</td>
                <td><input type="password" name="cur_pass" style="width: 50%;"></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td>New password:</td>
                <td><input type="password"  name="new_pass" style="width: 50%;"></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td>Confirm password:</td>
                <td><input type="password"  name="new_conf" style="width: 50%;"></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td>Profile picture:</td>
                <td><input type="file"  name="pic" style="width: 50%;"></td>
            </tr>
            <tr>
                <td><input type="submit" id="submit" name="save" value="Save changes" style="width: 50%;"></td>
            </tr>
        </table>
</div>
</main>

<footer id="mainFooter">
    <h3 style="font-size: 30px;float:left;margin-left:55px;">You can always go nastop!</h3>
    <h3 style="font-size: 20px;float:left; margin-left:25px;">Nastop.bg е място, където се срещат шофьори със свободни места и желаещи да пътуват.
        Вие сте шофьор: Не плащайте сам цялото гориво! Споделете този разход с други хора!
        Желате да пътувате: Возете се удобно в кола на по-ниска цена от билет за автобус.</h3>
    <img src="https://prevozvalnik.bg/img/bulgaria-footer.png" style="margin-right: 25px">
    <h3 style="font-size: 15px;margin-right:55px;">Copyright 2019 © Nastop.bg</h3>
</footer>

</body>
</html>