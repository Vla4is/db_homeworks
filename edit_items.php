
<?php
include ("conn.php");
include ("support_functions.php");


session_start ();
$user_in = user_logged_in($conn);
$errors = [];
$action_result = "";
if (!$user_in) {

    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset ($_POST['new_item']) and isset ($_POST ['new_submit'])) {
        if (strlen ($_POST['new_item']) == 0) {
            $errors[''] = 'The item has to be at least 1 char long';
        }else {
            add_item($conn, $_POST['new_item']);
            $new_item = $_POST['new_item'];
            $action_result = "<b>$new_item</b> added succesfully";

        }
    }elseif (isset ($_POST['delete']) and isset ($_POST['item_id'])) {
        delete_item($conn, $_POST['item_id']);
        $action_result = "Deleted succesfully";

    }
    elseif (isset ($_POST['edit']) and isset ($_POST['item_id'])) {
        

        if (strlen ($_POST['item_name']) == 0) {
            $errors[''] = 'The item has to be at least 1 char long';
        }else {
            update_item ($conn, $_POST['item_name'], $_POST['item_id']);
            $item_name = $_POST['item_name'];
            $action_result = "Item <b>$item_name</b> updated succesfully";
        }


    }

}

$items = get_all_items($conn);


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
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="main">
        <?php foreach ($items as $item): ?>
            <form action="" method="POST">
                
                <input type="hidden" value="<?php echo $item ['item_id']; ?>" name="item_id">
                <input type="text" name="item_name" value = "<?php echo $item ["item_name"]; ?>">
                <button name="edit" type="submit">edit</button>
                <button type="submit" name="delete">delete</button>
            </form>
        <?php endforeach; ?>
    
        <br>

        <form action="" method="POST">
            <input type="text" name="new_item" >
            <button type="submit" name="new_submit">add</button>
        </form>
        <div><?php echo $action_result ?></div>
        
    
        
    </div>
    
</body>
</html>