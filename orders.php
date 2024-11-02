
<?php
include ("conn.php");
include ("support_functions.php");
include ("querys.php");

session_start ();
$user_in = user_logged_in($conn);

if (!$user_in) {

    header("Location: index.php");
}


$orders = get_all_orders($conn);



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
<a href="index.php"><button>Back home</button></a>

    <div class="main">
        <?php foreach ($orders as $order): ?>
           <div>
                <span><?php echo $order ["order_id"]; ?></span>
                <span><?php echo $order ['item_name']; ?></span>
            </div>
        <?php endforeach; ?>
    
            
        
    </div>
    
</body>
</html>