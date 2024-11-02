
<?php
include ("conn.php");
include ("support_functions.php");
include ("querys.php");

session_start ();
$user_in = user_logged_in($conn);
$errors = [];
if (!$user_in) {

    header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset ($_POST['new_item']) and isset ($_POST ['new_submit'])) {
        if (strlen ($_POST['new_item']) == 0) {
            $errors[''] = 'The item has to be at least 1 char long';
        }else {
            add_item($conn, $_POST['new_item']);
        }
    }elseif (isset ($_POST['delete']) and isset ($_POST['item_id'])) {
        delete_item($conn, $_POST['item_id']);
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
                <span><?php echo $item ["item_name"]; ?></span>
                <input type="hidden" value="<?php echo $item ['item_id']; ?>" name="item_id">
                <button type="submit" name="delete">delete</button>
            </form>
        <?php endforeach; ?>
    
        <br>

        <form action="" method="POST">
            <input type="text" name="new_item" >
            <button type="submit" name="new_submit">add</button>
        </form>
            
        
    
        
    </div>
    
</body>
</html>