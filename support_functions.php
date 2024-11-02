<?php
function user_logged_in($conn) {
    
    if (!empty ($_SESSION) && isset ($_SESSION["user_id"]) && $_SESSION ['token']) {
        $user_id = $_SESSION  ['user_id'];
        $sql = "SELECT token, is_admin FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_id); 
        $stmt->execute();
        $token = "";
        $is_admin = 0;
        $stmt->bind_result($token, $is_admin);
        $stmt->fetch();
        $stmt->close();
        if ($token == $_SESSION ["token"]) {
            return $is_admin ? 2 : 1;
        }
    }else {
        return 0;
    }
}

?>