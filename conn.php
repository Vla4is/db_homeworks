<?php
include("create_databases.php");
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

    }
    else {
        $conn = new mysqli($servername, $username, $password, $database_name);
    }

}

?>