<?php
session_start ();

include ("helpers/conn.php");

$verify_user = false;
$order_id = $_GET ["id"];

if($user_in) {
    $admin = false;
    $user_in == 2?$admin=true:null;
    $verify_user = verify_user_order ($conn, $_SESSION ['user_id'], $order_id, $admin);
    $order = get_details_order ($conn, $order_id);
    $total = 0;
}
// print_r($order);

// [$row ['item_name'], $row ['price'], $row ['quantity']]

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
    
    <?php require "header.php";?>


    <div class="body center">
        <?php if ($user_in && $verify_user&& count($order) > 0) { ?>
        <div class="centeralrow">
            <img class="checkmark" src="img/checkmark.png" alt="">
            <span class="">You order <?php echo $order_id; ?> placed successfully</span>
        </div>
        <div class="centralrow">
            <div>Here are the detailes:</div>
            <table class="table">
                <tr>
                    <td>Item name</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    <td>Total</td>


                </tr>
            <?php foreach ($order as $item): ?>
                <tr>
                    <td><?php echo $item[0]; ?></td>
                    <td><?php echo $item[2]; ?></td>
                    <td><?php echo $item[1]; ?></td>
                    <td><?php echo $k = $item[1]*$item[2]; $total += $k; ?></td>

                </tr>
            <?php endforeach;?>
            <tr>
                <td colspan="2">Total</td>
                <td colspan="2"><?php echo $total; ?></td>
            </tr>
            </table>
        </div>
        <?php }else { ?>
            <h3>Something went wrong</h3>
        <?php } ?>


        

    </div>
    <?php require "footer.php";?>
</body>
</html>