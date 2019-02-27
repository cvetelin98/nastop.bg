<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit</title>
    <link rel="stylesheet" href="../Style/style.css">
</head>
<body>
<div id="nav">
<ul>
    <li><a class="active" href="main.php">Home</a></li>
    <li><a href="#news">My shared travels</a></li>
    <li><a href="profile.php">Profile edit</a></li>
    <li><a href="addCar.html">Add car</a></li>
    <li style="float:right"><a href="#about">Log out</a></li>
</ul>
</div>
<div>
    <button><a href="publicProfile.php">Public profile</a></button>
    <h3>Edit your profile:</h3>
    <form action="../index.php?target=User&action=edit" method="post" enctype="multipart/form-data">
        <table id="regTable">
            <tr>
                <td>GSM:</td>
                <td><input type="number"  name="GSM" value="" style="width: 50%;"></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td>Current password:</td>
                <td><input type="password"  name="cur_pass" style="width: 50%;"></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td>New password:</td>
                <td><input type="password"  name="new_pass" style="width: 50%;"></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td>Confirm password:</td>
                <td><input type="password"  name="new_pass2" style="width: 50%;"></td>
            </tr>
            <tr><td><br></td></tr>
            <tr>
                <td>Profile picture:</td>
                <td><input type="file" required name="pic" style="width: 50%;"></td>
            </tr>
            <tr>
                <td><input type="submit" id="submit" name="save" value="Save changes" style="width: 50%;"></td>
            </tr>
        </table>
</div>



</body>
</html>