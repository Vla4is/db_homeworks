<?php
session_start ();
include ("helpers/conn.php");

if ($user_in) {
    

$items = get_all_items($conn);
$user_id = $_SESSION ["user_id"];
$cart = get_cart ( $conn, $user_id );
if ($_SERVER ["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST["item_id"];
    if (!isset ($cart [$item_id])) {
        add_item_cart( $conn, $item_id, $user_id);
        $cart [$item_id][0]=1;
    }else {
        quantity_counter_cart ($conn, $item_id, $user_id, 1);
        $cart [$item_id][0]++;
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
</head>
<body>
    <?php require "header.php";?>
    
    <div class="body center">
        <?php if ($user_in) {?>

            
        <h2>Our menu</h2>
        <table>
        <?php foreach ($items as $i => $item): ?>
        <form method="POST">
        
            

            <input name="item_id" type="hidden" value="<?php echo $i; ?>">
            

            
                <tr >
                    <td style="border-top: 1px solid green; padding-top: 10px; "><?php echo $item[0];?></td>

                    <td style="border-top: 1px solid green; padding-top: 10px;">
                    <?php if ( isset($cart[$i]) ) { ?>
            <img src="img/shoppingcart.png" alt="test" style="width: 20px;" title = 'Item in cart' onclick="showthebeer_waitasec_andgo ('cart.php')" >
            <span><?php echo $cart[$i][0] ?> </span>
            <?php }?>
                    </td>

                </tr>
                <tr>
                    <td>Price:</td>
                    <td><?php echo $item[1] ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="textcenter">Description:</td>
                    
                </tr>
                <tr><td style="textcenter"><?php echo $item[2] ?></td></tr>
                <tr>
                    <td colspan="2"><button type="submit">Add to the cart</button></td>
                </tr>

            
            
        </form>
        <?php endforeach;?>
            </table>
            <?php }else {?>
            <h2>To order you must be logged in!</h2>
        <?php }?>


    </div>
    
    <?php require "footer.php";?>
    
</body>
</html>