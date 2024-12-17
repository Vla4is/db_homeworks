<?php
function add_items (){
    
}
function register_user ($conn, $email, $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password');";
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
    $sql = "SELECT item_name, item_id, price, item_description FROM items WHERE active=1";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[$row['item_id']] = [$row['item_name'], $row['price'], $row ['item_description']];
            
        }

        return $items;
    } else {
        return [];
    }
}

function get_items_for_history ($conn) {
    $sql = "SELECT item_name, item_id, active FROM items;";
    $result = $conn->query ($sql);
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[$row['item_id']] = [$row['item_id'], $row['item_name'], $row ['active']];
    }
    return $items;
}

function get_item_history ($conn, $item_id) {
    $sql = "SELECT item_name, price, item_description, active, edit_date FROM items_history WHERE item_id='$item_id';";
    $result=$conn->query ($sql);
    if ($result->num_rows > 0) {
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        return $rows;
    } else {
        return []; // No results found
    }
}

function delete_item ( $conn, $item_id ) {
    // $sql = "DELETE FROM items WHERE item_id = '$item_id';";
    $sql ="UPDATE items SET active = 0 WHERE item_id = $item_id;";
    $conn->query ($sql);
}

function update_item ($conn, $name, $item_id, $price, $item_description) {
    $sql = "UPDATE items SET item_name = '$name', price='$price', item_description='$item_description' WHERE item_id = '$item_id';";
    $conn->query ($sql);
}

function new_order ($conn, $user_id, $cart ) {
    echo $user_id;
    $max_id = get_max_orders($conn);
    $order_id = $max_id-1;
    increase_max_orders($conn, $max_id);
    foreach ($cart as $i=>$item) {
        $item_id=$i;
        $quantity = $item [0];
        $sql = "INSERT INTO orders (order_id, item_id, user_id, quantity, price_paid) VALUES ($order_id, $item_id, $user_id, $quantity, (SELECT price FROM items WHERE item_id=$item_id));";
        $conn->query ($sql);
        
    }
    return $order_id;
       
}

function get_max_orders ($conn) {
    $sql = "SELECT max(order_id) AS max_item_id from orders;";
     $result = $conn->query ($sql);
    $row = $result->fetch_assoc();
    return $row['max_item_id'];
}
function increase_max_orders ($conn, $max_id) {
    // echo $max_id;
    $new = $max_id+1;
    $sql = "UPDATE orders SET order_id = $new WHERE order_id=$max_id; ";
    $conn->query ($sql);
}

function verify_user_order($conn, $user_id, $order_id, $is_admin) {
    $sql = "SELECT order_id FROM orders WHERE order_id = $order_id AND user_id = $user_id;";
    if ($is_admin) { $sql = "SELECT order_id FROM orders WHERE order_id = $order_id;";}
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return true; 
    }
    return false;
}

function get_all_user_orders ($conn, $user_id, $all=false) {
    !$all ? $sql = "SELECT DISTINCT order_id FROM orders WHERE user_id = $user_id;":$sql = "SELECT DISTINCT order_id FROM orders WHERE user_id IS NOT NULL";
    $result = $conn->query ($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row["order_id"];
    }
    return $data;
}


function delete_order ($conn, $order_id) {
    $sql = "DELETE FROM orders WHERE order_id = '$order_id';";
    $conn->query ($sql);
}

function get_details_order( $conn, $order_id ) {
$sql ="SELECT item_name, price, quantity, total_price FROM order_details WHERE order_id = $order_id;";
$result = $conn->query ($sql);
$order = [];
while ($row = $result->fetch_assoc()) {
    $order[]=[$row ['item_name'], $row ['price'], $row ['quantity'], $row ['total_price']];
}
return $order;

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
    $sql = "SELECT user_id, email, is_admin FROM users";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = [
                'user_id' => $row['user_id'],
                'email' => $row['email'],
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

function get_user_id ($conn, $email) {
    $sql = "SELECT user_id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
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


function clear_cart ($conn, $user_id) { 
$sql = "DELETE FROM carts WHERE user_id = '$user_id';";
$conn ->query ($sql);
}

function get_cart ( $conn, $user_id ) {
    $sql = "SELECT carts.item_id, carts.quantity, items.price, items.item_name FROM carts JOIN items ON items.item_id=carts.item_id WHERE user_id = $user_id;";
    $result = $conn->query($sql);

    if ($result === false) {
        return [];
    }

    $cart = [];
    while ($row = $result->fetch_assoc()) {
        $cart[$row['item_id']] = [$row['quantity'], $row['price'], $row ['item_name']];
    }

    return $cart;
}

function add_item_cart ($conn, $item_id, $user_id) {
$sql = "INSERT INTO carts (item_id, user_id, quantity) VALUES ($item_id, $user_id, 1);";
$conn -> query($sql);
}
function quantity_counter_cart ($conn, $item_id, $user_id, $value) {
$sql = "UPDATE carts  SET quantity = quantity+$value WHERE user_id= $user_id AND item_id=$item_id;";
$conn -> query($sql);
}



function delete_from_cart ($conn, $user_id, $item_id) {
    $sql = "DELETE FROM carts WHERE item_id = $item_id AND user_id =  $user_id;";
    $conn -> query($sql);
}

?>