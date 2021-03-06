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
<header class="navHeader">
    <a href="index.php?target=User&action=viewHome"><h1 class="smallHeader">Nastop.bg</h1></a>
    <div id="nav">
        <ul>
            <li><a href="index.php?target=User&action=viewHome">Home</a></li>
            <li><a href="index.php?target=User&action=viewProfile">My Profile</a></li>
            <li><a href="index.php?target=User&action=viewHistory">My Shared Travels</a></li>
            <li><a href="index.php?target=User&action=viewEdit">Edit Profile</a></li>
            <li><a href="index.php?target=Car&action=ViewAdd">Add a Car</a></li>
            <li><a class="active" href="index.php?target=Travel&action=ViewAdd">Add a Travel</a></li>
            <li style="float:right"><a href="index.php?target=User&action=logout">Log out</a></li>
        </ul>
    </div>
</header>
<img id="mainCover" src="https://static1.squarespace.com/static/55c1d8bce4b081fdca9dc5fd/t/573c76938259b5b384b45f7e/1463580310514/Individuals.jpg?format=1500w" width="80%" height="150px;">

<main id="viewMain">
    <br>
    <span id="mainSpan" style="margin-left: 43%; margin-top:1.5%;">&nbsp Add travel:&nbsp</span>
    <?php if($checkCars){ ?>
    <form action="index.php?target=Travel&action=add" method="post" onsubmit="return validation()">
        <table id="travelTable">
            <tr>
                <td>Start:</td>
                <td><select name="starting_destination" id="starting_destination" required>
                        <?php foreach ($cities as $city) {?>
                        <option value="<?php echo $city["id"] ?>"><?php echo $city["name"] ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td>Final:</td>
                <td><select name="final_destination" id="final_destination" required>
                        <?php foreach ($cities as $city) {?>
                            <option value="<?php echo $city["id"] ?>"><?php echo $city["name"] ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td>Date:</td>
                <td><input type="date" name="date_of_travelling" id="date_of_travelling" required></td>
            </tr>
            <tr>
                <td>Free places:</td>
                <td><input type="number" name="free_places" id="free_places" onfocus="this.value=''"required></td>
            </tr>
            <tr>
                <td>Price:</td>
                <td><input type="number" name="price" id="price" required></td>
            </tr>
            <tr>
                <td>Car:</td>
                <td><select name="car" id="car" onchange="checkPlace();" required>
                        <?php foreach ($cars as $car) {?>
                            <option value="<?php echo $car->getCarId(); ?>"><?php echo $car->getCarName(); ?></option>
                        <?php } ?>
                    </select></td>
            </tr>
            <tr>
                <td colspan="3"><input type="submit" name="addButton" id="submit" value="Add"></td>
            </tr>
        </table>
    </form>
        <input type="hidden" id="check-place-value" value="true">
    <?php }
    else { ?>
        <div id="noCars">
    <h1 style="font-size: 3vw;";>You don't have car for sharing ! Sorry :( </h1>
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

    function validation(){
        var check = document.getElementById("check-place-value").value;
        if(check == "false"){
            alert("Not so many places in the car!");
        }
        if(validDest() && validDate() && validPlaceAndPrice() && (check == "true")){
                return true;
        }
        else return false;
    }

    function validDest(){
        var start,final;
        start = document.getElementById("starting_destination").value;
        final = document.getElementById("final_destination").value;
        if(start == final){
            alert("Destinations must be different!");
            return false;
        }
        else return true;
    }

    function validDate(){
            var selectedText = document.getElementById('date_of_travelling').value;
            var selectedDate = new Date(selectedText);
            var now = new Date();
            if (selectedDate < now) {
                alert("Date must be in the future!");
                return false;
        }
        else return true;
    }

    function validPlaceAndPrice(){
        var places,price;
        places = document.getElementById("free_places").value;
        price = document.getElementById("price").value;
        if(places <= 0 || price <= 0){
            if(places <= 0) {
                alert("Places must be positive number!");
                return false;
            }
            if(price <= 0) {
                alert("Price must be positive number! If you want to win something?");
                return false;
            }
        }

        else return validPlaces();
    }

    function validPlaces(){
        places = document.getElementById("free_places").value;
        if (places > 32) {
            alert("Places limit is 32!");
            return false;
        }
        else return true;
    }

    async function checkPlace() {
        var entered_places = document.getElementById("free_places").value;
        var car = document.getElementById("car").value;

        var response = await fetch("index.php?target=Car&action=getPlaces",
            {
                method: "POST",
                headers: {'Content-type': 'application/x-www-form-urlencoded'},
                body: "car=" + car
            });
        var myJson = await response.json();
        var real_places = myJson.real_places;
        var result = null;
        if(real_places < entered_places){
            alert("Not so many places in the car!");
            result = false;
        }
        else {
            result = true;
        }
        document.getElementById("check-place-value").value = result;
        return result;
     }

</script>

</body>
</html>