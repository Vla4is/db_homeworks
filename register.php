<script src="script.js"></script>
<?php
// Start session to store user data
include ('querys.php');
include ("conn.php");
session_start();


$username = $password = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);


    if (empty($username)) {
        $errors[] = "Username is required.";
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
    $check_sql = "SELECT username FROM users WHERE username='$username';";
    $result = $conn->query($check_sql);
    if ($result && $result->num_rows > 0) {
        $errors[] = "User with this username already exists";
    }

    elseif (empty($errors)) {
        
        if (register_user ($conn, $username, $password)){
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
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    
</head>
<body>

<h2>Register</h2>


<?php if (!empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<div class="main">
<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>"><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"><br><br>
    <label for="confirm_password">Confirm password:</label>
    <input type="password" id="confirm_password" name="confirm_password"><br><br>
    <input type="submit" value="Register">
</form>

</div>

</body>
</html>
