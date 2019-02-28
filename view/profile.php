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
            <li><a class="active" href="profile.php">My Profile</a></li>
            <li><a href="history.php">My Shared Travels</a></li>
            <li><a href="edit.php">Edit Profile</a></li>
            <li><a href="addCar.html">Add a Car</a></li>
            <li><a href="addTravel.html">Add a Travel</a></li>
            <li style="float:right"><a href="../index.php?target=User&action=logout">Log out</a></li>
            <!--TODO FIX LOGOUT !-->
        </ul>
    </div>
</header>
<img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="80%" height="150px;">
<!--TODO TABLE WITH MY TRAVELS !-->
<main id="logMain">

    <table id="proTable">
        <tr>
            <td>
                <img width="450px"  src="../<?php echo $_SESSION["user_image"]?>"">
            </td>
        </tr>
        <tr>
            <td>Username: <?php echo $_SESSION["username"]; ?></td>
        </tr>
        <tr>
            <td>Name: <?php echo $_SESSION["first_name"]." ".$_SESSION["last_name"]; ?></td>
        </tr>
        <tr>
            <td>Age: <?php echo $_SESSION["age"]; ?></td>
        </tr>
        <tr>
            <td>GSM: <?php echo $_SESSION["gsm"]; ?></td>
        </tr>
        <tr>
            <td>Gender: <?php echo $_SESSION["gender"]; ?></td>
        </tr>
        <tr>
            <td>Rating: <?php echo $_SESSION["rating"]; ?></td>
        </tr>
    </table>

    <form method="post">
        <div id="comment">
            <table>
                <tr>
        <td><textarea name="comment" rows="4" cols="35" placeholder="add a comment ?" style="text-align:center;"></textarea></td>
                </tr>
                    <tr>
                    <td><input type="submit" name="sendComment" value="Comment"></td>
                </tr>
            </table>
        </div>
    </form>

</body>
</html>

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

