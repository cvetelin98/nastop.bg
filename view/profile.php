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
    <h1 class="smallHeader">Nastop.bg</h1>
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
<!--TODO TABLE WITH MY TRAVELS !-->
<main id="logMain">

    <div class="card">
        <img width="30%" height="212vh" src="<?php echo $_SESSION["user_image"]?>">
        <div class="container">
            <h4><b>Name: <?php echo $_SESSION["first_name"]." ".$_SESSION["last_name"]; ?></b></h4>
            <p>Username: <?php echo $_SESSION["username"]; ?></p>
            <p>Age: <?php echo $_SESSION["age"]; ?></p>
            <p>GSM: <?php echo $_SESSION["gsm"]; ?></p>
            <p>Gender: <?php echo $_SESSION["gender"]; ?></p>
            <p>Rating: <?php echo $_SESSION["rating"]; ?></p>
        </div>
    </div>
    <h1 style="text-align: left; font-size: 3vw;">Your cars:</h1>
<!--    --><?php //foreach($cars as $car) { ?>
<!--    <div class="card">-->
<!--        <img width="35%"  src="--><?php //echo $car->getCarImage(); ?><!--">-->
<!--        <div class="container">-->
<!--            <h4><b>Name: --><?php //echo $car->getCarName(); ?><!--</b></h4>-->
<!--            <p>Color: --><?php //echo $car->getCarColor(); ?><!--</p>-->
<!--            <p>Places: --><?php //echo $car->getCarPlaces(); ?><!--</p>-->
<!--        </div>-->
<!--    </div>-->
<!--    --><?php //} ?>
    <table id="carShow">
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

