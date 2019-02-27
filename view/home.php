<?php

//$travels = TravelDao::getAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>nastop</title>
    <link rel="stylesheet" href="../Style/style.css">
</head>
<body>
<!--<img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="80%" height="100px;">-->
<header class="navHeader">
    <h1 class="smallHeader">Nastop.bg</h1>
    <div id="nav">
        <ul>
            <li><a class="active" href="home.php">Home</a></li>
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="history.html">My Shared Travels</a></li>
            <li><a href="edit.php">Edit Profile</a></li>
            <li><a href="addCar.html">Add a Car</a></li>
            <li><a href="addTravel.html">Add a Travel</a></li>
            <li style="float:right"><a href="../index.php?target=User&action=logout">Log out</a></li>
            <!--TODO FIX LOGOUT EVERYWHERE!-->
        </ul>
    </div>
</header>
<img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="80%" height="150px;">
<main id="mainInMain">
    <br>
    <p style="font-size: 30px;">&nbsp Selected Travels for sharing:</p>
    <table>
        <?php if(count($travels) > 0) {
            foreach ($travels as $travel) { ?>
                <tr>
                    <td><?php echo $travel["starting_destination"] ?></td>
                    <td><?php echo $travel["final_destination"] ?></td>
                    <td><?php echo $travel["date_of_travelling"] ?></td>
                    <td><?php echo $travel["price"] ?></td>
                    <td><?php echo $travel["description"] ?></td>
                </tr>
            <?php }
        }
        else { ?> <tr><td colspan="5" style="font-size: 30px"> <?php echo "No data available"; ?></td></tr> <?php } ?>
    </table>

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
