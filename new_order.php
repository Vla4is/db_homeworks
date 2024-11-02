<?php
include ("conn.php");
include ("support_functions.php");
include ("querys.php");
session_start();
$user_in = user_logged_in($conn);

if (!$user_in) {
    header("Location: index.php");
}
$bottom_message = "";
$items = get_all_items($conn);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order']) && isset($_POST['item_id'])) {
        $new_order_id = new_order ($conn, $_POST['item_id']);
        $bottom_message = "New order with id: $new_order_id placed succesfully";
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
<a href="index.php"><button>Back home</button></a>

    <div class="main">
    <?php foreach ($items as $item): ?>
        <form method="POST">
            <span><?php echo $item['item_name'];?></span>
            <input type="hidden" name="item_id" value = "<?php echo $item['item_id'];?>">
            <button type="submit" name="order">Order</button>
        </form>
    <?php endforeach; ?>
    <div style="color: green;"><?php echo $bottom_message ?></div>
    </div>
</body>
</html>