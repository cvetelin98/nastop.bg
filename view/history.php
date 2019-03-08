<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>nastop</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body">
<header class="navHeader">
    <a href="index.php?target=User&action=viewHome"><h1 class="smallHeader">Nastop.bg</h1></a>
    <div id="nav">
        <ul>
            <li><a href="index.php?target=User&action=viewHome">Home</a></li>
            <li><a href="index.php?target=User&action=viewProfile">My Profile</a></li>
            <li><a class="active" href="index.php?target=User&action=viewHistory">My Shared Travels</a></li>
            <li><a href="index.php?target=User&action=viewEdit">Edit Profile</a></li>
            <li><a href="index.php?target=Car&action=ViewAdd">Add a Car</a></li>
            <li><a href="index.php?target=Travel&action=ViewAdd">Add a Travel</a></li>
            <li style="float:right"><a href="index.php?target=User&action=logout">Log out</a></li>
        </ul>
    </div>
</header>
<img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="80%" height="150px;">
<main id="logMain">

    <br>
    <span id="mainSpan" style="margin-left: 39%">&nbsp My Past Travels:</span>
    <div id="historyScroll">
        <table id="showTable">
            <tr>
                <th>Starting Point</th>
                <th>Final Point</th>
                <th>Date</th>
                <th>Car</th>
                <th>User</th>
                <th>Price</th>
            </tr>
            <?php if(count($my_travels) > 0) {
                foreach ($my_travels as $my_travel) { ?>
                    <tr>
                        <td><?php echo \model\dao\TravelDao::getCityName($my_travel->getStartingDestination()); ?></td>
                        <td><?php echo \model\dao\TravelDao::getCityName($my_travel->getFinalDestination()); ?></td>
                        <td><?php echo $my_travel->getDateOfTravelling(); ?></td>
                        <td><img src="<?php echo $my_travel->car_image ?>" width="15%"></td>
                        <td><?php echo \model\dao\UserDao::getUsernameById($my_travel->getUserId()); ?></td>
                        <td><?php echo $my_travel->getPrice(); ?> BGN</td>
                    </tr>
                <?php }
            }
            else { ?> <tr><td colspan="5" style="font-size: 30px"> <?php echo "&nbspNo data available"; ?></td></tr> <?php } ?>
        </table>
    </div>
    <hr style="color: red;">
    <span id="mainSpan" style="margin-left: 38%">&nbsp My Guest Travels:</span>
    <div id="historyScroll">
        <table id="showTable">
            <tr>
                <th>Starting Point</th>
                <th>Final Point</th>
                <th>Date</th>
                <th>Car</th>
                <th>User</th>
                <th>Price</th>
            </tr>
            <?php if(count($guest_travels) > 0) {
                foreach ($guest_travels as $guest_travel) { ?>
                    <tr>
                        <td><?php echo \model\dao\TravelDao::getCityName($guest_travel->getStartingDestination()); ?></td>
                        <td><?php echo \model\dao\TravelDao::getCityName($guest_travel->getFinalDestination()); ?></td>
                        <td><?php echo $guest_travel->getDateOfTravelling(); ?></td>
                        <td><img src="<?php echo $my_travel->car_image ?>" width="15%"></td>
                        <td><?php echo \model\dao\UserDao::getUsernameById($guest_travel->getUserId()); ?></td>
                        <td><?php echo $guest_travel->getPrice(); ?> BGN</td>
                    </tr>
                <?php }
            }
            else { ?> <tr><td colspan="5" style="font-size: 30px"> <?php echo "&nbspNo data available"; ?></td></tr> <?php } ?>
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
<script>

</script>

</html>
