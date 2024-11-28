<?php
include 'helpers/conn.php';

session_start();
$bottom_message = "";
$user_in = user_logged_in($conn);
if ($user_in != 2) {
    header("Location: index.php");
}

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete"])) {
        if ($_SESSION['user_id'] == $_POST ['user_id']) {
            $errors[] = 'You cannot remove yourself';
        }else {
            delete_user ($conn, $_POST ['user_id']);
            $bottom_message = "User deleted successfully";
        }

    }elseif (isset($_POST["edit"])) {
        if (strlen($_POST ["new_password"]) < 6 ) {
//throw error
        $errors[] = "The new password should be at least 6 characters long";
        }
        else {
            change_user_password ($conn, $_POST ['user_id'], $_POST ['new_password']);
            $bottom_message = "Password changed successfully";

        }
    }elseif (isset($_POST['set_admin'])) {
        set_admin ($conn, $_POST ['user_id']);
        $bottom_message = "Admin set successfully";

    }elseif (isset($_POST['remove_admin'])) {

        if ($_POST ['user_id'] == $_SESSION ['user_id']) {
            $errors[] = 'You cannot remove the admin of yourself';
        }else {
            remove_admin ($conn, $_POST ['user_id']);
            $bottom_message = "Admin removed successfully";
        }
        

    }
   
}


$users = get_all_users($conn);
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
        
    <ul style="color: red;">
        <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>

    <table>
        <tr class="textcenter">
            <td>User ID</td>
            <td>Email</td>
            <td>New password</td>
            <td>Delete</td>
            <td>Admin</td>
            
        </tr>
    <?php foreach ($users as $user): ?>
            <tr>
            <form action="manage_users.php" method="POST" style="margin: 10px">
                
                <input type="hidden" value="<?php echo $user ['user_id']; ?>" name="user_id">
                <td><?php echo $user ['user_id'] ;?></td>
                <td> <?php echo $user ['email'] ;?></td>
                <td><input type="text" name="new_password" placeholder="New password">
                <button name="edit" type="submit">Change password</button></td>
                <td><button type="submit" name="delete">Delete user</button></td>
                <td>
                <?php if ($user['is_admin'] == 1) { ?>
                <button type="sumbit" name="remove_admin" style="color: red;">Remove admin</button>
                <?php }else { ?>
                <button type="sumbit" name="set_admin">Set admin</button>
                <?php } ?>
                </td>

            </form>
            </tr>
        <?php endforeach; ?>
        </table>
            <div style="color: green;"><?php echo $bottom_message ?></div>
        

    </div>
    <?php require "footer.php";?>
</body>
</html>