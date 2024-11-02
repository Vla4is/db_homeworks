<?php
include 'conn.php';

include 'support_functions.php';
session_start();
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $errors [] = "Please enter username";
    }
    if (empty($_POST["password"])) {
        $errors [] = "Please enter password";
    }
    $user_id = get_user_id($conn,$_POST["username"]);
    if ($user_id) {
        $login_usr = login_user ($conn , $user_id, $_POST["password"]);
        if (!$login_usr) {
            $errors [] = "Wrong credentials";
        }
    }else {
        $errors [] = "Wrong credentials";
    }
   
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
    <img src="img/logo.webp" alt="Moving Image" id="movable-image">
    <?php if ($user_in) {?>
        <button onclick="showthebeer_waitasec_andgo ('new_order.php')">New order</button>
        <button onclick="showthebeer_waitasec_andgo ('orders.php')">Previous orders</button>
        <button onclick="showthebeer_waitasec_andgo ('edit_items.php')">Edit items</button>
        <?php if ($user_in == 2) { ?> <button onclick="showthebeer_waitasec_andgo ('manage_users.php')">Manage users</button> <?php }?>

        <img src="img/loading.gif" alt="" style="width: 50px; height:auto; margin-top: 10px; display: none;" id="beer">

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

    <script src="script.js"></script>
</body>


<script>
const logout = () => {
    window.location.href = 'logout.php';
};
</script>

</html>