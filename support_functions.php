<?php
function user_logged_in($conn) {
    
    if (!empty ($_SESSION) && isset ($_SESSION["username"]) && $_SESSION ['token']) {
        $username = $_SESSION  ['username'];
        $sql = "SELECT token FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username); 
        $stmt->execute();
        $token = "";
        $stmt->bind_result($token);
        $stmt->fetch();
        $stmt->close();
        if ($token == $_SESSION ["token"]) {
            return true;
        }
    }else {
        return false;
    }
}
?>