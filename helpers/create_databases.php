
<?php

function create_databases ($conn, $database_name) {
    
    $conn->query("CREATE DATABASE `$database_name`;"); 
    mysqli_select_db($conn, $database_name);
    create_users_table($conn);
    create_items_table ($conn);
    create_orders_table ($conn);
    create_cart_table ($conn);
    create_full_orders_view ($conn);
    create_item_history ($conn);
    create_triggers($conn);
}

function create_users_table ($conn) {
    $sql = "CREATE TABLE users (user_id INT AUTO_INCREMENT PRIMARY KEY,  email VARCHAR (255) UNIQUE NOT NULL ,  password VARCHAR (255), token VARCHAR (255), is_admin BOOLEAN);";
    $conn->query ($sql);
}

function create_items_table ($conn) {
    $sql = "CREATE TABLE items (item_id INT AUTO_INCREMENT PRIMARY KEY, item_name VARCHAR (100) NOT NULL, price FLOAT DEFAULT 0, item_description VARCHAR (300), active BOOLEAN DEFAULT 1 );";
    $conn->query ($sql);
}

function create_orders_table ($conn) {
    $sql = "CREATE TABLE orders (order_id INT, item_id INT ,FOREIGN KEY (item_id) REFERENCES items(item_id) ON DELETE CASCADE, user_id INT ,FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ,quantity INT, price_paid INT, total_price INT);";
    $conn->query ($sql);
    $sql = "INSERT INTO orders (order_id) VALUES (1002);";
    $conn->query ($sql);

}

function create_cart_table ($conn) {
    $sql = "CREATE TABLE carts (item_id INT ,FOREIGN KEY (item_id) REFERENCES items(item_id) ON DELETE CASCADE, user_id INT ,FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE, quantity INT);";
    $conn->query ($sql);
}

function create_full_orders_view ($conn) {
    $sql ="CREATE VIEW order_details AS SELECT o.order_id, o.user_id ,i.item_name, o.price_paid AS price, o.total_price, o.quantity FROM orders o JOIN items i ON o.item_id = i.item_id;";
    $conn->query ($sql);
}

function create_item_history ($conn) {
    $sql = "CREATE TABLE items_history (item_id INT, FOREIGN KEY (item_id) REFERENCES items (item_id), item_name VARCHAR (100) NOT NULL, price FLOAT DEFAULT 0, item_description VARCHAR (300), active BOOLEAN, edit_date DATETIME);";
    $conn->query($sql);
}
function create_triggers ($conn) {
    $sql = "CREATE TRIGGER calculate_total_price BEFORE INSERT ON orders FOR EACH ROW SET NEW.total_price = NEW.quantity * NEW.price_paid;";
    $conn->query ($sql);
    $sql = "CREATE TRIGGER delete_cart_items AFTER UPDATE ON items FOR EACH ROW BEGIN IF NEW.active = 0 THEN DELETE FROM carts WHERE item_id = OLD.item_id; END IF; END";
    $conn->query ($sql);
     //trigger of item history
    $sql = "CREATE TRIGGER add_to_history AFTER UPDATE ON items FOR EACH ROW BEGIN IF OLD.item_id != NEW.item_id OR OLD.item_name!=NEW.item_name OR OLD.price!=NEW.price OR OLD.item_description!=NEW.item_description OR OLD.active!=NEW.active THEN INSERT INTO items_history (item_id, item_name, price , item_description, active, edit_date) VALUES (OLD.item_id, OLD.item_name, OLD.price, OLD.item_description, OLD.active, CURRENT_TIMESTAMP); END IF; END";
    $conn->query($sql);
}

 ?>