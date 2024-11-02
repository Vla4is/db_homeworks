<?php
include("create_databases.php");
include ("querys.php");
$servername = "localhost";
$username = "root";
$password = ""; 

$conn = new mysqli($servername, $username, $password);
if ($conn) {
    $database_name = "pizza";
    $sql = "SHOW DATABASES LIKE '$database_name';";
    $result = $conn->query($sql);
    if ($result && $result->num_rows == 0) {
        create_databases ($conn, $database_name);
        $conn = new mysqli($servername, $username, $password, $database_name);
        register_user ($conn, "admin", "admin");
        set_admin($conn, 1);
        

    }
    else {
        $conn = new mysqli($servername, $username, $password, $database_name);
    }

}

?>