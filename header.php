<?php
// global $user_in ;
// $user_in = user_logged_in($conn);
?>

<img id ="beer"src="img/loading.gif" alt="">
    <div class="header center">
        <h1>Welcome to the best pizzeria in the universe</h1>
        <img src="img/shoppingcart.png" class="carticon"alt="" onclick="showthebeer_waitasec_andgo ('cart.php')">
    </div>
 
    <div class="navbar">
        <span onclick="showthebeer_waitasec_andgo ('index.php')">Home</span>
        <span onclick="showthebeer_waitasec_andgo ('new_order.php')">Order a pizza</span>
        <?php if ($user_in) { ?>
            <span onclick="showthebeer_waitasec_andgo ('my_orders.php')">My orders</span>

            <span onclick="showthebeer_waitasec_andgo ('logout.php')">Logout</span>
        <?php } else {?>
            <span onclick="showthebeer_waitasec_andgo ('login.php')">Login </span>
            <span onclick="showthebeer_waitasec_andgo ('register.php')">Register </span>
            <?php }?>
        <?php if ($user_in == 2) { ?>
            <span onclick="showthebeer_waitasec_andgo ('manage_users.php')">Manage users</span>
            <span onclick="showthebeer_waitasec_andgo ('edit_items.php')">Edit items</span>
        <?php }?>

    </div>