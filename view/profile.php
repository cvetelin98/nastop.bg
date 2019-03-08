<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>nastop</title>
    <link rel="stylesheet" href="Style/style.css">
</head>
<body>
<header class="navHeader">
    <a href="index.php?target=User&action=viewHome"><h1 class="smallHeader">Nastop.bg</h1></a>
    <div id="nav">
        <ul>
            <li><a href="index.php?target=User&action=viewHome">Home</a></li>
            <li><a class="active" href="index.php?target=User&action=viewProfile">My Profile</a></li>
            <li><a href="index.php?target=User&action=viewHistory">My Shared Travels</a></li>
            <li><a href="index.php?target=User&action=viewEdit">Edit Profile</a></li>
            <li><a href="index.php?target=Car&action=ViewAdd">Add a Car</a></li>
            <li><a href="index.php?target=Travel&action=ViewAdd">Add a Travel</a></li>
            <li style="float:right"><a href="index.php?target=User&action=logout">Log out</a></li>
        </ul>
    </div>
</header>
<img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="80%" height="150px;">
<main id="logMain">

    <div class="card">
        <img width="20%" height="200vh" margin="auto" src="<?php echo $_SESSION["user_image"]?>">
        <div class="container">
            <h4><b>Name: <?php echo $_SESSION["first_name"]." ".$_SESSION["last_name"]; ?></b></h4>
            <p>Username: <?php echo $_SESSION["username"]; ?></p>
            <p>Age: <?php echo $_SESSION["age"]; ?></p>
            <p>GSM: <?php echo $_SESSION["gsm"]; ?></p>
            <p>Gender: <?php echo $_SESSION["gender"]; ?></p>
            <div>
                <p>Rating:<?php
                            echo (\model\dao\UserDao::getRatingById($_SESSION["user_id"]) >= 1) ? ' '.\model\dao\UserDao::getRatingById($_SESSION["user_id"]) : " Not Voted Yet!";
                    echo "<button class='star' onclick='noVote();'><img src='https://image.flaticon.com/icons/png/512/56/56786.png' width='25px' height='25px''></button>";
                            ?>
                </p>
            </div>
        </div>
    </div>
    <?php if(\model\dao\UserDao::checkUserCars($_SESSION["username"])) {?>
    <br>
    <h1 id="mainSpan" style="margin-left: 41%;">&nbspYour car/s:&nbsp</h1>
    <div id="carsScroll">
<!--        <table id="carShow">-->
        <table id="mainDiv" style="margin-left: 34%;">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Color</th>
                <th>Places</th>
            </tr>
        <?php foreach($cars as $car) { ?>
            <tr>
                <td><img width="65%"  src="<?php echo $car->getCarImage(); ?>"></td>
                <td><?php echo $car->getCarName(); ?></td>
                <td><?php echo $car->getCarColor(); ?></td>
                <td><?php echo $car->getCarPlaces(); ?></td>
            </tr>
        <?php } ?>
            <?php }
            else { ?>
                <br>
                <h1 id="mainSpan" style="text-align: left; font-size: 3vw;">If you have a car,you can add it from <a href="index.php?target=Car&action=ViewAdd" id="addCarLink">here</a> !</h1>
            <?php } ?>
        </table>
    </div>

    <?php if(count($comments) > 0){ ?>
    <div id="commentScroll">
        <table id="commentShow">
            <tr>
                <th>From</th>
                <th>Comment</th>
            </tr>
            <?php foreach($comments as $comment) { ?>
            <tr>
                <td><?php echo $comment["from_user"]; ?></td>
                <td><?php echo $comment["comment"] ?></td>
            </tr>
            <?php } ?>

        </table>
    <?php } ?>
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

<script>

    function noVote(){
        alert("You can't rate yourself!")
    }

</script>

</body>
</html>

