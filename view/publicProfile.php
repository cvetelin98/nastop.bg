<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Public profile</title>
</head>
<body>
<h3>Your public profile:</h3>
<table>
    <tr>
        <td>
            <img src='../images/<?php echo $_SESSION["user"]->getUserImage(); ?>'>
        </td>
    </tr>
    <tr>
        <td>Name: <?php echo $_SESSION["user"]->getFirstName(); ?></td>
        <td>Name: <?php echo $_SESSION["user"]->getLastName(); ?></td>
    </tr>
    <tr>
        <td>Age: <?php echo $_SESSION["user"]->getAge(); ?></td>
    </tr>
    <tr>
        <td>GSM: <?php echo $_SESSION["user"]->getGsm(); ?></td>
    </tr>
    <tr>
        <td>Gender: <?php echo $_SESSION["user"]->getGender(); ?></td>
    </tr>

</table>

</body>
</html>
