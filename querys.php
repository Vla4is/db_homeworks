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


?>