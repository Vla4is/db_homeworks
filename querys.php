<?php
function add_items (){
    
}
function register_user ($conn, $username, $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password');";
    $result = $conn->query($sql);
    return $result;
}

function login_user ($conn, $user_id, $password) {
    $sql = "SELECT password FROM users WHERE user_id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id); // "s" means the database expects a string
    $stmt->execute();
    $hashed_password = "";
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();
    if (password_verify($password, $hashed_password)) {
        //generate token
        $randomBytes = random_bytes(32);
        $token = bin2hex($randomBytes);
        $sql = "UPDATE users SET token ='$token' WHERE user_id='$user_id';";
        $conn->query($sql);
        $_SESSION ["token"] = $token;
        $_SESSION ["user_id"] = $user_id;
        return true;
    }
    return false;
   
    // $result = $conn->query($sql);
    // if ($result && $result->num_rows > 0) {

    //     password_verify($enteredPassword, $hashedPasswordFromDB
    // }
}

function add_item ($conn, $item_name) {
    $sql = "INSERT INTO items (item_name) VALUES ('$item_name');";
    $conn->query ($sql);
    return true;
}

function get_all_items($conn) {
    $sql = "SELECT item_name, item_id FROM items";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = [
                'item_name' => $row['item_name'],
                'item_id' => $row['item_id']
            ];
        }

        return $items;
    } else {
        return [];
    }
}

function delete_item ( $conn, $item_id ) {
    $sql = "DELETE FROM items WHERE item_id = '$item_id';";
    $conn->query ($sql);
}

function update_item ($conn, $name, $item_id) {
    $sql = "UPDATE items SET item_name = '$name' WHERE item_id = '$item_id';";
    $conn->query ($sql);
}

function new_order ($conn, $item_id) {
    $sql = "INSERT INTO orders (item_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    return $conn->insert_id;
}

function get_all_orders($conn) {
    $sql = "SELECT o.order_id, i.item_name 
            FROM orders o
            JOIN items i ON o.item_id = i.item_id 
            ORDER BY o.order_id";

    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = [
                'order_id' => $row['order_id'],
                'item_name' => $row['item_name']
            ];
        }

        return $orders;
    } else {
        return [];
    }
}

function delete_order ($conn, $order_id) {
    $sql = "DELETE FROM orders WHERE order_id = '$order_id';";
    $conn->query ($sql);
}


function delete_user ($conn, $user_id) {
    $sql = "DELETE FROM users WHERE user_id = '$user_id';";
    $conn->query ($sql);
}

function change_user_password ($conn, $user_id, $new_password) {
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password= '$new_hashed_password' WHERE user_id = '$user_id';";
    $conn->query ($sql);

}

function get_all_users($conn) {
    $sql = "SELECT user_id, username, is_admin FROM users";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = [
                'user_id' => $row['user_id'],
                'username' => $row['username'],
                'is_admin' => $row['is_admin'],

            ];
        }

        return $users;
    } else {
        return [];
    }
}

function set_admin ($conn, $user_id) {
    $SQL = "UPDATE users SET is_admin=true WHERE user_id = '$user_id';";
    $conn->query ($SQL);
}
function remove_admin ($conn, $user_id) {
    $SQL = "UPDATE users SET is_admin=false WHERE user_id = '$user_id';";
    $conn->query ($SQL);
}

function get_user_id ($conn, $username) {
    $sql = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user_id = null;
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
    if ($user_id !== null) {
        return $user_id;
    } else {
        return false;
    }

}

?>