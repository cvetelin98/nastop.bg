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
<main id="viewMain">

    <table id="carTable" style="top:75%; height: 50vh;">
        <tr>
            <td><?php echo \model\dao\TravelDao::getCityName($travel->getStartingDestination()); ?> ➟ <?php echo \model\dao\TravelDao::getCityName($travel->getFinalDestination()); ?></td>
        </tr>
        <tr>
            <td>(<?php echo $travel->getDateOfTravelling(); ?>)</td>
        </tr>
        <tr>
            <td>From: <?php echo \model\dao\TravelDao::getCityName($travel->getStartingDestination()); ?></td>
        </tr>
        <tr>
            <td>By: <?php echo \model\dao\UserDao::getUsernameById($travel->getUserId()); ?></td>
            <td><form method="post" action="index.php?target=User&action=viewProfileUser">
                    <input type=hidden name="username" value="<?php echo \model\dao\UserDao::getUsernameById($travel->getUserId()); ?>">
                    <input type="submit" value="See Profile" name="view_profile">
                </form></td>
        </tr>
        <tr>
            <td>To: <?php echo \model\dao\TravelDao::getCityName($travel->getFinalDestination()); ?></td>
        </tr>
        <tr>
            <td>On: <?php echo $travel->getDateOfTravelling(); ?></td>
        </tr>
        <tr>
            <td>Price: <?php echo $travel->getPrice(); ?> BGN</td>
        </tr>
        <?php if($travel->getFreePlaces() > 0) {?>
            <tr>
                <td>Free Places: <?php echo $travel->getFreePlaces(); ?></td>
            </tr>
        <?php }
        else { ?>
            <tr>
                <td>Free Places: ☹</td>
            </tr>
        <?php } ?>
        <?php if($travel->getFreePlaces() > 0) {?>
        <tr>
            <td><a href="index.php?target=User&action=viewLogin"><button id="book">Book</button></a></td>
        </tr>
        <?php }
        else { ?>
        <tr>
            <td id="no_book">No Free Places!</td>
        </tr>
        <?php } ?>

    </table>

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



?>