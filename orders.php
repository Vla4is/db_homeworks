
<?php
include ("conn.php");
include ("support_functions.php");


session_start ();
$user_in = user_logged_in($conn);

if (!$user_in) {

    header("Location: index.php");
}


$action_result = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id']) and isset($_POST['delete'])) {
        delete_order($conn, $_POST['order_id']);
        $action_result = 'Order deleted successfully';
        
    }
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
           <form method="POST" action ="">
                <span><?php echo $order ["order_id"]; ?></span>
                <span><?php echo $order ['item_name']; ?></span>
                <input type="hidden" name="order_id" value="<?php echo $order ["order_id"]; ?>">
                <button name="delete" type="submit">delete</button>
            </form>
        <?php endforeach; ?>
    
            
        <div><?php echo $action_result ?></div>
        
    </div>
    
</body>
</html>