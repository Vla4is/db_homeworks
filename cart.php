
<?php
session_start ();

include ("helpers/conn.php");
if (!$user_in) {
    header ("Location: index.php");
}
$user_id=$_SESSION ['user_id'];
$items =[];
$cart = get_cart ( $conn, $user_id );



if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
    isset ($_POST["item_id"]) ? $item_id = $_POST["item_id"]:null;
    if (isset($_POST["paynow"])) {
        $order_id = new_order ($conn, $user_id, $cart);
        clear_cart ($conn, $user_id);
        header("Location: order_placed.php?id=".$order_id);
    }
    elseif (isset($_POST['counter'])) {
        if ($_POST['counter'] == "1") {
            quantity_counter_cart ($conn, $item_id, $user_id, 1);
            $cart[$item_id][0]++;

        }else {
            quantity_counter_cart ($conn, $item_id, $user_id, -1);
            $cart[$item_id][0]--;
        }

        if ($cart[$item_id][0] < 1) {
            delete_from_cart( $conn, $user_id, $item_id );
            unset ($cart[$item_id]);
        }
    }
    
    else {
        delete_from_cart( $conn, $user_id, $item_id );
        unset ($cart[$item_id]);

    }
}
$total_price = 0;

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
    

    <div class="body center" id="upper">
        
        <?php if (count ($cart) > 0) { 
            foreach ($cart as $i =>$row): 
                
            ?>
        <form action="" method="POST">
                <div class="itemincart">
                <span><?php echo $row[2]; ?></span>
                <button class="counters" name="counter" value="0">-</button>
                <input type="hidden" name="item_id" value="<?php echo $i; ?>">
                <input class="counter" type="text" value="<?php echo $row[0]; ?>" disabled>
                <button class="counters" name="counter" value="1">+</button>

                <?php echo $price = $row[1]*$row[0]; $total_price+=$price?></span>
                <button name="delete" >delete</button>
                </div>
        </form>

        

        <?php  endforeach; ?>
        

        

        <div>
            <div>Total: <?php echo $total_price;?></div>
            <form method="POST">
                <button name="paynow" >Place order!</button>

            </form>

            <?php }else{ ?>
        <h3>Empty cart, hurry to add items!</h3>
            <?php }?>

        </div>
        


    </div>
                

            
        

        
    
        <?php require "footer.php";?>


</body>
</html>