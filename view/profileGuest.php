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
<header id="mainHeader">
    <a href="index.php"><h1 id="mainName">Nastop.bg</h1></a>
    <div id="mainLinks">
        <a href="index.php?target=User&action=viewLogin">Login</a>
        |
        <a href="index.php?target=User&action=viewRegister">Register</a>
        <a href="index.php?target=User&action=viewRegister"><span id="addTravel">
            &nbsp+ Wanna share a travel?
        </span></a>
    </div>
</header>
<img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="80%" height="250px;">
<main id="logMain">

    <div class="card">
        <img width="30%" height="212vh" src="<?php echo $user->getUserImage()?>">
        <div class="container">
            <h4><b>Name: <?php echo $user->getFirstName()." ".$user->getLastName(); ?></b></h4>
            <p>Username: <?php echo $user->getUsername(); ?></p>
            <p>Age: <?php echo $user->getAge(); ?></p>
            <p>GSM: <?php echo $user->getGsm(); ?></p>
            <p>Gender: <?php echo $user->getGender(); ?></p>
            <p>Rating: <?php if($user->getRating() > 1) { echo $user->getRating(); }
            else { echo "Not Voted Yet!"; }?></p>
        </div>
    </div>
    <?php if(\model\dao\UserDao::checkUserCars($user->getUsername())) {?>
<br>
    <h1 style="text-align: left; font-size: 3vw;"><?php echo $user->getUsername(); ?>'s cars:</h1>
    <div id="carsScroll">
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
            <?php }
            else { ?>
                <br>
                <h1 style="text-align: left; font-size: 3vw;">User don't have cars!</h1>
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

</body>
</html>

