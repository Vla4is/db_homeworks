<?php
session_start ();

include ("helpers/conn.php");
$message = "";


if (!$user_in) {
    header ("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    if (isset ($_POST ['order_id'])){
        delete_order ($conn, $_POST ['order_id']);
        $message = "Order ".$_POST ['order_id']." deleted succesfully";
    }else {
        $show_all = 1;
    }
}

if (isset ($show_all)) {
    $orders = get_all_user_orders ($conn, $_SESSION ['user_id'], true);
    
}else {
    $orders = get_all_user_orders ($conn, $_SESSION ['user_id']);
}
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
    
    <?php require "header.php";?>

    <div class="body center">
        <?php if ($user_in==2) {?>
         <form method="POST">
            <button name="show_all">Show all orders</button>
         </form>
        <?php } ?>
        <div><?php echo $message; ?></div>
        <?php if (count ($orders) < 1) { ?>
            <h3>No orders yet, rush to buy!</h3>
            
        <?php } ?>
        <div class="my_orders">
        <?php foreach ($orders as $order_id) {?>
        <form method="POST" class="my_orders_item" onclick="showthebeer_waitasec_andgo ('order_placed.php?id='+<?php echo $order_id ?>)"><input type="hidden" name="order_id" value="<?php echo $order_id ?>"> <span >Order #<?php echo $order_id ?> </span> <?php if ($user_in==2) {?> <button name="delete">delete</button> <?php }?></form>
        <?php }?>
        </div>

    </div>
    <?php require "footer.php";?>
</body>
</html>