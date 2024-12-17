
<?php
include ("helpers/conn.php");
// include ("helpers/support_functions.php");
session_start ();
$user_in = user_logged_in($conn);
// $errors = [];
$action_result = "";
if ($user_in != 2) {
    header("Location: index.php");
}

$items = get_items_for_history($conn);
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
    <!-- <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?> -->
    
 <table>
    <tr >
        <th class="size-big">ID</th>
        <th class="size-big">Name</th>
    </tr>
        <?php foreach ($items as $item): 
        $background ="";
        $for_title = "";
            if (!$item [2]) {
                $background = "background_grey";
                $for_title = "title='Inactive'";
            }else {
                $background = "active_item";
            }
            ?>
            
                
            <tr onclick ="showthebeer_waitasec_andgo ('item_history.php?item_id=<?php echo $item[0];?>')" <?php echo $for_title;?> class="pointer edit_item_name <?php echo $background;?>">  
                    <td><?php echo $item[0];?></td>
                    <td><?php echo $item[1];?></td>
                     
                    
        </tr>

        <?php endforeach; ?>
        </table>

    </div>

    <?php require "footer.php";?>
</body>
</html>