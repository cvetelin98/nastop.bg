<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>nastop</title>
    <link rel="stylesheet" href="style/style.css">
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
                &nbsp
        </span></a>
    </div>
</header>
<img id="mainCover"
     src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w"
     width="80%" height="250px;">
<main id="mainInMain">
    <br>
    <span id="mainSpan">&nbsp Selected Travels for sharing:</span>
    <div id="travelScroll">
            <tr>
                <?php if (count($travels) > 0) {
                foreach ($travels as $travel) {
                if ($travel->getFreePlaces() > 0) { ?>
                <div id="mainDiv">
                    <table style="text-align: center">
                        <tr><td><p>From: </td><td><?php echo $travel->getStartingDestination(); ?></p></td></tr>
                        <tr><td><p>To: </td><td><?php echo $travel->getFinalDestination(); ?></p></td></tr>
                        <tr><td><p>Date: </td><td><?php echo $travel->getDateOfTravelling(); ?></p></td></tr>
                        <tr><td><p>Free places: </td><td><?php echo $travel->getFreePlaces(); ?></p></td></tr>
                        <tr><td><p>Price: </td><td><?php echo $travel->getPrice(); ?> BGN</p></td></tr>
                        <tr><td colspan="2"><form method="post" action="index.php?target=Travel&action=ViewTravel" style="margin-left:20%">
                        <input type=hidden name="travel_id" value="<?php echo $travel->getTravelId(); ?>">
                        <input type="submit" id="infoButton" value="See More" name="travelSubmit"></td></tr>
                    </form>
                    </p>
                    </table>
                </div>
            </tr>
            <?php } ?>
            <?php }
            }
            else { ?>
                <tr>
                    <td colspan="5" style="font-size: 30px"> <?php echo "No data available"; ?></td>
                </tr> <?php } ?>
    </div>

</main>
<footer id="mainFooter">
    <h3 style="font-size: 30px;float:left;margin-left:55px;">You can always go nastop!</h3>
    <h3 style="font-size: 20px;float:left; margin-left:25px;">Nastop.bg е място, където се срещат шофьори със свободни
        места и желаещи да пътуват.
        Вие сте шофьор: Не плащайте сам цялото гориво! Споделете този разход с други хора!
        Желате да пътувате: Возете се удобно в кола на по-ниска цена от билет за автобус.</h3>
    <img src="https://prevozvalnik.bg/img/bulgaria-footer.png" style="margin-right: 25px">
    <h3 style="font-size: 15px;margin-right:55px;">Copyright 2019 © Nastop.bg</h3>
</footer>

</body>
</html>
