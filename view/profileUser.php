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
<main id="logMain">

    <div class="card">
        <img width="30%" height="212vh" src="<?php echo $user->getUserImage()?>">
        <div class="container">
            <h4><b>Name: <?php echo $user->getFirstName()." ".$user->getLastName(); ?></b></h4>
            <p>Username: <?php echo $user->getUsername(); ?></p>
            <p>Age: <?php echo $user->getAge(); ?></p>
            <p>GSM: <?php echo $user->getGsm(); ?></p>
            <p>Gender: <?php echo $user->getGender(); ?></p>
            <div>
                <p>Rating:<?php
                    for($i = 1 ; $i <= 5 ; $i++){
                        echo "<button id='". $i."' onclick='rate(".$user_id.",".$i.")' value='".$i."' >".$i."</button>";
                    }
                    ?>
                <?php if($user_rating >= 1){ ?>
                <div id="rating"><?php echo $user_rating ?></div>
                <?php } else {?>
                <div id="rating">Not Voted Yet!</div>
                <?php } ?>
                </p>
            </div>
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

    <?php if($user_id != $_SESSION["user_id"]) { ?>

    <div id="comment-section">
        <textarea placeholder="Comment Here!" rows="5" cols="50" id="comment"></textarea>
        <input type="hidden" value="<?php echo $user_id ?>" id="to_user">
        <button onclick="sendComment()">Comment</button>
    </div>

    <?php } ?>

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

    function sendComment() {
        var comment = document.getElementById("comment").value;
        var to_user = document.getElementById("to_user").value;

        fetch("index.php?target=User&action=comment",
            {
                method: "POST",
                headers: {'Content-type': 'application/x-www-form-urlencoded'},
                body: "comment=" + comment + "&to_user=" + to_user
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (myJson) {
                var answer = myJson.answer;
                var new_comments = myJson.new_comments;
                var from_user = myJson.from_user;

                if(answer === true){
                    var table = document.getElementById("commentShow");
                    var row = table.insertRow(-1);
                    var cell_from_user = row.insertCell(-1);
                    var cell_comment = row.insertCell(-1);
                    var comment = document.getElementById("comment");
                    if(new_comments.length > 0) {

                        for(var i = 0; i < new_comments.length; i++) {
                            cell_from_user.innerHTML = from_user;
                            cell_comment.innerHTML = new_comments[i];
                            comment.value = "";
                        }
                    }
                    else {
                        alert("Try again!");
                    }
                }
    })
    .catch(function (e) {
        alert(e.message);
    })
    }

    function rate(user_id, rate_value){
        fetch("index.php?target=User&action=rateUser",
            {
                method: "POST",
                headers: {'Content-type': 'application/x-www-form-urlencoded'},
                body: "user_id=" + user_id + "&rate=" + rate_value
            })
            .then(function (response) {
                return response.json();
            })
            .then(function (myJson) {
                var answer = myJson.answer;
                var new_rating = myJson.new_rating;
                var rating = document.getElementById('rating');

                if(answer === true){
                    rating.innerHTML = new_rating;
                    }
                    else {
                        alert("You already voted!");
                    }
                })
            .catch(function (e) {
                alert(e.message);
            })
    }


</script>

</body>
</html>

