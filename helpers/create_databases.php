
<?php

function create_databases ($conn, $database_name) {
    
    $conn->query("CREATE DATABASE `$database_name`;"); 
    mysqli_select_db($conn, $database_name);
    create_users_table($conn);
    create_items_table ($conn);
    create_cart_table ($conn);
    create_item_history ($conn);
    create_orders_table ($conn);
    create_full_orders_view ($conn);

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

function create_item_history ($conn) {
    $sql = "CREATE TABLE items_history (record_id INT AUTO_INCREMENT PRIMARY KEY, item_id INT, FOREIGN KEY (item_id) REFERENCES items (item_id), item_name VARCHAR (100) NOT NULL, price FLOAT DEFAULT 0, item_description VARCHAR (300), active BOOLEAN, edit_date DATETIME);";
    $conn->query($sql);
}

function create_orders_table ($conn) {
    $sql = "CREATE TABLE orders (order_id INT, user_id INT ,FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE ,quantity INT, record_id INT, FOREIGN KEY (record_id) REFERENCES items_history (record_id));";
    $conn->query ($sql);
    $sql = "INSERT INTO orders (order_id) VALUES (1002);";
    $conn->query ($sql);

}

function create_full_orders_view ($conn) {
        // get the order id from order table
        // get the user id from orders
        // get the item name from history
        // get the price paid from history
        // calculate the total price here
        // get the quantity from the orders
        // total two tables, orders and order_history
    $sql = "CREATE VIEW order_details 
    AS SELECT 
    o.order_id, o.user_id ,h.item_name, h.price, (h.price*o.quantity) total_price, o.quantity
    FROM orders o
    JOIN items_history h
        ON h.record_id = o.record_id;
     ";
    $conn->query ($sql);
}

function create_cart_table ($conn) {
    $sql = "CREATE TABLE carts (item_id INT ,FOREIGN KEY (item_id) REFERENCES items(item_id) ON DELETE CASCADE, user_id INT ,FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE, quantity INT);";
    $conn->query ($sql);
}




function create_triggers ($conn) {
    $sql = "CREATE TRIGGER delete_cart_items AFTER UPDATE ON items FOR EACH ROW BEGIN IF NEW.active = 0 THEN DELETE FROM carts WHERE item_id = OLD.item_id; END IF; END";
    $conn->query ($sql);
     //trigger of item history
    $sql = "CREATE TRIGGER add_to_history_update AFTER UPDATE ON items FOR EACH ROW BEGIN IF OLD.item_id != NEW.item_id OR OLD.item_name!=NEW.item_name OR OLD.price!=NEW.price OR OLD.item_description!=NEW.item_description OR OLD.active!=NEW.active THEN INSERT INTO items_history (item_id, item_name, price , item_description, active, edit_date) VALUES (NEW.item_id, NEW.item_name, NEW.price, NEW.item_description, NEW.active, CURRENT_TIMESTAMP); END IF; END";
    $conn->query($sql);
    //add the record automatically to the history
    $sql = "CREATE TRIGGER add_to_history_insert AFTER INSERT ON items FOR EACH ROW BEGIN INSERT INTO items_history (item_id, item_name, price , item_description, active, edit_date) VALUES (NEW.item_id, NEW.item_name, NEW.price, NEW.item_description, NEW.active, CURRENT_TIMESTAMP); END";
    $conn->query($sql);

}

 ?>