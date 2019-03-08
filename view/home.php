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

<header class="navHeader">
    <a href="index.php?target=User&action=viewHome"><h1 class="smallHeader">Nastop.bg</h1></a>
    <div id="nav">
        <ul>
            <li><a class="active" href="index.php?target=User&action=viewHome">Home</a></li>
            <li><a href="index.php?target=User&action=viewProfile">My Profile</a></li>
            <li><a href="index.php?target=User&action=viewHistory">My Shared Travels</a></li>
            <li><a href="index.php?target=User&action=viewEdit">Edit Profile</a></li>
            <li><a href="index.php?target=Car&action=ViewAdd">Add a Car</a></li>
            <li><a href="index.php?target=Travel&action=ViewAdd">Add a Travel</a></li>
            <li style="float:right"><a href="index.php?target=User&action=logout">Log out</a></li>
        </ul>
    </div>
</header>
<div style="width: 80%; margin:auto; height:160px;" class="search-panel">
    <div class="container">
        <div class="row">
            <div class="slogan">Connecting  <strong>drivers</strong> with free places and <strong>people</strong>, who wants to travel.</div>
            <div class="location">
                <h1 style="text-align: left">Find travel:</h1>
                <form method="POST" action="index.php?target=Travel&action=search">
                    <div id="from-location" style="text-align: left">
                        <input type="text" placeholder="From" name="from" id="from" class="from ui-autocomplete-input" autocomplete="off">
                        <input type="hidden" name="from_city_id">
                        <ul  class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-2" tabindex="0" style="display: none;"></ul></div>
                    <div id="to-location">
                        <input type="text" placeholder="To" name="to" id="to" class="to ui-autocomplete-input" autocomplete="off">
                        <input type="hidden" name="to_city_id">
                        <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-1" tabindex="0" style="display: none;"></ul></div>
                    <button type="submit" class="btn-momchi momchi-blue" name="searchButton">Search</button>
                </form>
                <div class="clearfix"></div>

            </div>
            <div  align="right" class="question hidden-xs hidden-sm">
                <p>
                    Sharing your travels,<br>
                    save money and find new friends!
                </p>
            <a href="index.php?target=Travel&action=ViewAdd" title="Wanna share a travel?">
                    <img src="https://i.pinimg.com/originals/2b/ec/f1/2becf13fe32fe57918319c7f93330e1e.png"
                         width="10%" height="100px" alt="Want to travel?">
                </a>

            </div>
        </div>
    </div>
</div>
<img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="80%" height="150px;">
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
    <h3 style="font-size: 20px;float:left; margin-left:25px;">Nastop.bg е място, където се срещат шофьори със свободни места и желаещи да пътуват.
        Вие сте шофьор: Не плащайте сам цялото гориво! Споделете този разход с други хора!
        Желате да пътувате: Возете се удобно в кола на по-ниска цена от билет за автобус.</h3>
    <img src="https://prevozvalnik.bg/img/bulgaria-footer.png" style="margin-right: 25px">
    <h3 style="font-size: 15px;margin-right:55px;">Copyright 2019 © Nastop.bg</h3>
</footer>

</body>
</html>
