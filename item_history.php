
<?php
include ("helpers/conn.php");
// include ("helpers/support_functions.php");


session_start ();
$user_in = user_logged_in($conn);
// $errors = [];
$action_result = "";
if ($user_in !=2 || !isset($_GET ['item_id'])) {
    header("Location: index.php");
}


$items = get_item_history($conn, $_GET ['item_id']);



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse; 
    }
</style>
</head>
<body>
    <?php require "header.php";?>
    <div class="body center">
        <table>
            <tr>
                <th class="size-big">Item name</th>
                <th class="size-big">item description</th>
                <th class="size-big">Item price</th>
                <th class="size-big">Item active</th>
                <th class="size-big">Edit date and time</th>
            </tr>

                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo $item['item_name'] ?></td>
                        <td><?php echo $item['item_description'] ?></td>
                        <td><?php echo $item['price'] ?></td>
                        <td><?php echo $item['active'] ?></td>
                        <td><?php echo $item['edit_date'] ?></td>
                    </tr>
                <?php endforeach; ?>
        </table>
        <button onclick="showthebeer_waitasec_andgo ('items_history.php')">Go to history</button>
    </div>
    <?php require "footer.php";?>
</body>
</html>