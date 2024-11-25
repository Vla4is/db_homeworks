<?php
session_start ();

include ("helpers/conn.php");


$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $errors [] = "Please enter email";
    }
    if (empty($_POST["password"])) {
        $errors [] = "Please enter password";
    }
    $user_id = get_user_id($conn,$_POST["email"]);
    if ($user_id) {
        $login_usr = login_user ($conn , $user_id, $_POST["password"]);
        if (!$login_usr) {
            $errors [] = "Wrong credentials";
        }else {
            header("Location: index.php");
        }
    }else {
        $errors [] = "Wrong credentials";
    }
   
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    
    <?php require "header.php";
    
    
    ?>

    <div class="body center">
    <form method="post" action="">
        <table>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" id="email" name="email" value=""></td>
            </tr>
            <tr>
                <td><label for="password">Password:</label></td>
                <td><input type="password" id="password" name="password"></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">Submit</button>
                </td>
            </tr>
        </table>
    </form>

    </div>
    <?php require "footer.php";
    ?>
</body>
</html>