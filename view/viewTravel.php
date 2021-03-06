<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>nastop</title>
    <link rel="stylesheet" href="Style/style.css">
    <link rel="icon" href="http://pngimg.com/uploads/road/road_PNG48.png">
</head>
<body>
<header class="navHeader">
    <a href="index.php?target=User&action=viewHome"><h1 class="smallHeader">Nastop.bg</h1></a>
    <div id="nav">
        <ul>
            <li><a href="index.php?target=User&action=viewHome">Home</a></li>
            <li><a href="index.php?target=User&action=viewProfile">My Profile</a></li>
            <li><a href="index.php?target=User&action=viewHistory">My Shared Travels</a></li>
            <li><a href="index.php?target=User&action=viewEdit">Edit Profile</a></li>
            <li><a href="index.php?target=Car&action=ViewAdd">Add a Car</a></li>
            <li><a href="index.php?target=Travel&action=ViewAdd">Add a Travel</a></li>
            <li style="float:right"><a href="index.php?target=User&action=logout">Log out</a></li>
        </ul>
    </div>
</header>
<img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="80%" height="150px;">
<main id="viewMain">

    <table id="carTable" style="margin-top:2%; height: 50vh;">
        <tr>
            <td><?php echo $travel->getStartingDestination(); ?> ➟ <?php echo $travel->getFinalDestination(); ?></td>
        </tr>
        <tr>
            <td>(<?php echo $travel->getDateOfTravelling(); ?>)</td>
        </tr>
        <tr>
            <td>By: <?php echo $travel->username; ?></td>
            <td><form method="post" action="index.php?target=User&action=viewProfileUser">
                    <input type=hidden name="username" value="<?php echo $travel->username; ?>">
                    <input type="submit" value="See Profile" name="view_profile">
                </form></td>
        </tr>
        <tr>
            <td>From: <?php echo $travel->getStartingDestination(); ?></td>
        </tr>
        <tr>
            <td>To: <?php echo $travel->getFinalDestination(); ?></td>
        </tr>
        <tr>
            <td>On: <?php echo $travel->getDateOfTravelling(); ?></td>
        </tr>
        <tr>
            <td>Price: <?php echo $travel->getPrice(); ?> BGN</td>
        </tr>
        <?php if($travel->getFreePlaces() > 0) {?>
        <tr>
            <td id="places">Free Places: <?php echo $travel->getFreePlaces(); ?></td>
        </tr>
        <?php }
        else { ?>
        <tr>
            <td>Free Places: ☹</td>
        </tr>
        <?php } ?>
        <?php if($_SESSION["user_id"] ==  $travel->getUserId()){ ?>
            <td id="no_book">You are the driver!</td>
        <?php }
        else if (in_array($travel->getTravelId(),$user_travels)){ ?>
            <td id="no_book">Already Booked!</td>
            <?php }
            else { ?>
            <?php if($travel->getFreePlaces() > 0) {?>
                <tr>
                    <td><button id="book" onclick="book(<?php echo $travel->getTravelId(); ?>)">Book</button></td>
                </tr>
            <?php }
            else { ?>
            <tr>
                <td id="no_book">No Free Places!</td>
            </tr>
            <?php } ?>
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

<script>

    function book(travel_id) {
            fetch("index.php?target=Travel&action=book",
                {
                    method: "POST",
                    headers: {'Content-type': 'application/x-www-form-urlencoded'},
                    body: "travel_id=" + travel_id
                })
                .then(function (response) {
                    return response.json();
                })
                .then(function (myJson) {
                    var answer = myJson.answer;
                    var new_places = myJson.new_places;
                    if(answer === true){
                        var places = document.getElementById("places");

                        var button = document.getElementById("book");
                        var table = document.getElementById("carTable");
                        var row = table.insertRow(-1);
                        var cell = row.insertCell(-1);

                        if(new_places > 0) {
                            places.innerHTML = "Free Places: " + new_places;
                            button.outerText = "";

                            cell.innerHTML = "Already Booked";
                            cell.id = "no_book";

                        }
                        else {
                            places.innerHTML = "Free Places: ☹";
                            button.outerText = "";

                            cell.innerHTML = "Already Booked";
                            cell.id = "no_book";
                        }
                    }
                })
                .catch(function (e) {
                    alert(e.message);
                })
    }

</script>

</body>
</html>
