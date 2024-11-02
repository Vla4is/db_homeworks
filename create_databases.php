
<!-- 
include 'conn.php';

function create_databases($conn) {
    $database_name = "pizza";
    $sql = "SHOW DATABASES LIKE '$database_name';";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows == 0) {
        $conn->query("CREATE DATABASE `$database_name`;"); 
        echo "Database created";
    } else if ($result && $result->num_rows > 0) {
        echo "Database already exists";
    } else {
        echo "Error checking database: " . $conn->error;
    }
} -->


<?php

function create_databases ($conn, $database_name) {
    
    $conn->query("CREATE DATABASE `$database_name`;"); 
    mysqli_select_db($conn, $database_name);
    create_users_table($conn);
    create_items_table ($conn);
    create_orders_table ($conn);
    
}

function create_users_table ($conn) {
    $sql = "CREATE TABLE users (user_id INT AUTO_INCREMENT PRIMARY KEY,  username VARCHAR (100) UNIQUE NOT NULL ,  password VARCHAR (255), token VARCHAR (255));";
    $conn->query ($sql);
}

function create_items_table ($conn) {
    $sql = "CREATE TABLE items (item_id INT AUTO_INCREMENT PRIMARY KEY, item_name VARCHAR (100) NOT NULL, item_description VARCHAR (300), is_parent BOOLEAN DEFAULT TRUE, parent_id INT, FOREIGN KEY (parent_id) REFERENCES items(item_id) ON DELETE SET NULL );";
    $conn->query ($sql);
}

function create_orders_table ($conn) {
    $sql = "CREATE TABLE orders (order_id INT AUTO_INCREMENT PRIMARY KEY, item_id INT ,FOREIGN KEY (item_id) REFERENCES items(item_id) ON DELETE CASCADE, quantity INT, cashier INT,  FOREIGN KEY (cashier) REFERENCES users(user_id) ON DELETE CASCADE );";
    $conn->query ($sql);
}

 ?>