
<?php
include ("helpers/conn.php");
// include ("helpers/support_functions.php");


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
            $description = $_POST ["description"];
            $price = $_POST ["price"];
            update_item ($conn, $_POST['item_name'], $_POST['item_id'], $_POST ["price"], $_POST ["description"]);
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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    
    <?php require "header.php";?>

    <div class="body center">
    <div><?php echo $action_result ?></div>
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    
        <?php foreach ($items as $i=> $item): ?>
            <form action="" method="POST">
                <div class="edit_item_name">
                <input type="hidden" value="<?php echo $i; ?>" name="item_id">
                    <table>
                        <tr>
                            <td colspan="2" class="edit_item"><?php echo $item[0]; ?></td>
                        </tr>
                        <tr>
                            <td>Edit name:</td>
                            <td><input type="text" name="item_name" value = "<?php echo $item[0]; ?>">  </td>

                        </tr>
                        <tr>
                            <td>Item price:</td>
                            <td><input type="text" name="price" value = "<?php echo $item[1]; ?>">  </td>

                        </tr>

                        <tr>
                            <td colspan="2">Item description</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea name="description" rows="4" cols="50"  ><?php echo $item[2]; ?></textarea>
                            </td>
                        </tr>
                    
                    <tr>
                    <td colspan="2">
                        <div>
                            <button name="edit" type="submit" >Edit</button>
                            <button name="delete">Delete</button>
                        </div>
                    
                    </td>
                    
                    </tr> 
                    
                    </table>
                
                
                </div>

                
            </form>
        <?php endforeach; ?>
    
        <br>

        <form action="" method="POST">
            <table>
                <tr>
                    <td colspan="2" class="textcenter">
                        <h3>Add a new item</h3>
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="new_item" style="width: 400px" ></td>
                    <td><button type="submit" name="new_submit">add</button></td>
                </tr>
            </table>
            
            
        </form>
        
        
    
        
    

    </div>

    <?php require "footer.php";?>
</body>
</html>