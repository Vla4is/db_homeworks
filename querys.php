<?php
function add_items (){
    
}
function register_user ($conn, $username, $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password');";
    $result = $conn->query($sql);
    return $result;
}

function login_user ($conn, $username, $password) {
    $sql = "SELECT password FROM users WHERE username = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // "s" means the database expects a string
    $stmt->execute();
    $hashed_password = "";
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();
    if (password_verify($password, $hashed_password)) {
        //generate token
        $randomBytes = random_bytes(32);
        $token = bin2hex($randomBytes);
        $sql = "UPDATE users SET token ='$token' WHERE username='$username';";
        $conn->query($sql);
        $_SESSION ["token"] = $token;
        $_SESSION ["username"] = $username;

    }
   
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
            JOIN items i ON o.item_id = i.item_id"; 

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



?>