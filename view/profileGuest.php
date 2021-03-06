<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>nastop</title>
    <link rel="stylesheet" href="Style/style.css">
    <link rel="icon" href="http://pngimg.com/uploads/road/road_PNG48.png">
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
        <img width="20%" height="200vh" margin="auto" src="<?php echo $user->getUserImage()?>">
        <div class="container">
            <h4><b>Name: <?php echo $user->getFirstName()." ".$user->getLastName(); ?></b></h4>
            <p>Username: <?php echo $user->getUsername(); ?></p>
            <p>Age: <?php echo $user->getAge(); ?></p>
            <p>GSM: <?php echo $user->getGsm(); ?></p>
            <p>Gender: <?php echo $user->getGender(); ?></p>
            <div>
                <p>Rating:<?php
                    for($i = 1 ; $i <= 5 ; $i++){
                        echo "<a href='index.php?target=User&action=viewLogin'><button class='star' id='". $i."' value='".$i."'><img src='https://image.flaticon.com/icons/png/512/56/56786.png' width='25px' height='25px'' id='star_".$i."' onmouseover='change(".$i.");''></button></a>";
                    }
                    echo ($user_rating >= 1) ? ' → '.$user_rating : " ☞ Not Voted Yet!";
                    ?>
                </p>
            </div>
        </div>
    </div>
    <?php if($checkCars) {?>
<br>
    <h1 id="mainSpan" style="margin-left:43%;  margin-top:3%"><?php echo $user->getUsername(); ?>'s car/s:</h1>
    <div id="carsScroll">
        <table id="mainDiv" style="margin-left:37%;  margin-top:1%; width:35%;">
            <tr>
                <th class="th_car">Image</th>
                <th class="th_car">Name</th>
                <th class="th_car">Color</th>
                <th class="th_car">Places</th>
            </tr>
            <?php foreach($cars as $car) { ?>
                <tr>
                    <td ><img width="65%"  src="<?php echo $car->getCarImage(); ?>"></td>
                    <td><?php echo $car->getCarName(); ?></td>
                    <td><?php echo $car->getCarColor(); ?></td>
                    <td><?php echo $car->getCarPlaces(); ?></td>
                </tr>
            <?php } ?>
            <?php }
            else { ?>
                <br>
                <h1 id="mainSpan" style="text-align: left; font-size: 3vw;">User don't have cars!</h1>
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

    function change(curr){
        var curr_star = document.getElementById("star_" + curr);
        if(curr_star.src == "https://image.flaticon.com/icons/png/512/56/56786.png") {
            for (var i = 1; i <= curr; i++) {
                var star = document.getElementById("star_" + i);
                star.src = "http://www.cliparthut.com/clip-arts/140/download-gold-star-png-image-hq-png-image-freepngimg-clipart-qGwzLj.png";
            }
        }
        else {
            for (var i = 5; i >= curr; i--) {
                var star = document.getElementById("star_" + i);
                star.src = "https://image.flaticon.com/icons/png/512/56/56786.png";
            }
        }
    }

</script>

</body>
</html>

