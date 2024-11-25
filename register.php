<script src="script.js"></script>
<?php
session_start ();
include ("helpers/conn.php");



$email = $password = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);


    if (empty($email)) {
        $errors[] = "Email is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if (empty($confirm_password)) {
        $errors [] = "Please confirm the password";
    }
    elseif ($confirm_password != $password) {
        $errors[] = "The passwords doesnt match";
    }
    
    //check if username exists
    $check_sql = "SELECT email FROM users WHERE email='$email';";
    $result = $conn->query($check_sql);
    if ($result && $result->num_rows > 0) {
        $errors[] = "User with this email already exists";
    }

    elseif (empty($errors)) {
        
        if (register_user ($conn, $email, $password)){
            echo "<p>Registration successful! Please log in</p>";
            echo "<script>redirect_after_one_sec()</script>";     
        }
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
    <h2>Register</h2>


<?php if (!empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<div class="main">
<!-- <form method="post" action="">
    <label for="email">Email:</label>
    <input type="text" id="username" name="email" value="<?= htmlspecialchars($email) ?>"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <label for="confirm_password">Confirm password:</label>
    <input type="password" id="confirm_password" name="confirm_password"><br><br>
    <input type="submit" value="Register">
</form> -->

<form method="post" action="">
    <table>
        <tr>
            <td><label for="username">Email: </label></td>
            <td><input type="text" id="username" name="email" value="<?= htmlspecialchars($email) ?>"></td>
        </tr>
        <tr>
            <td><label for="password">Password:</label></td>
            <td><input type="password" id="password" name="password"></td>
        </tr>
        <tr>
            <td><label for="confirm_password">Confirm Password: </label></td>
            <td><input type="password" id="confirm_password" name="confirm_password"></td>
        </tr>
    </table>
    <input type="submit" value="Register">
</form>




</div>

    </div>
    <?php require "footer.php";
    ?>
</body>
</html>