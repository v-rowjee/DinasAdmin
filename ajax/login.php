<?php
session_start();
include '../config/db_connect.php';

if(isset($_POST['username']) && isset($_POST['password'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $statement = $conn->prepare($sql);
    $statement->execute([$username]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if($user['is_admin'] == 'no'){
        echo "NOT-ADMIN";
        exit;
    }

    if (isset($user['username'])) {    // if username exist
        $hashed_password = $user['password'];

        if (password_verify($password,$hashed_password)) { // if password correct
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['is_admin'] = $user['is_admin'];
            echo "OK";
            exit;

        } else{
            echo "WRONG-CREDENTIAL";    // invalid password
            exit;
        } 
    } else{
        echo "WRONG-CREDENTIAL";    // username does not exist
        exit;
    }
}

?>