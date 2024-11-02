<?php
include 'conn.php'; // Replace 'filename.php' with the path to your file
include 'querys.php';
include 'support_functions.php';
session_start();
// $session ["username"] = 'Vlad';
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $errors [] = "Please enter username";
    }
    if (empty($_POST["password"])) {
        $errors [] = "Please enter password";
    }
     login_user ($conn , $_POST["username"], $_POST["password"]);
   
}

$user_in = user_logged_in($conn);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">


</head>
<body>
    <?php if ($user_in) {?>
        <button onclick="logout ()">logout</button>
        <?php }else { ?>
    <a href="register.php"><button onclick=" ">Register</button></a>
        <?php } ?>
    <?php if (!empty($errors)): ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
    <div class="main">
    <?php if ($user_in) {?>
        <button>New order</button>
        <button>Find order</button>
        <button>Recent orders</button>
    <?php } else {?>


    <form method="post" action="" >
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value=""><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br><br>
        <button>Submit</button>
    </form>
    <?php }?>
    </div>
    <span id = "for_php"></span>
</body>


<script>
const logout = () => {
    window.location.href = 'logout.php';
};
</script>

</html>