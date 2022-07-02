<?php
session_start();
include '../config/db_connect.php';

if(isset($_POST['username']) && isset($_POST['password'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $statement = $conn->prepare($sql);
    $statement->execute([$username]);

    $rowCount = $statement->rowCount();

    if($rowCount == 0){
        echo "Wrong credentials";
        exit;
    }

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if($user['is_admin'] == 'no'){
        echo "User is not an admin";
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
            $_SESSION['google_id'] = $user['google_id'];
            echo "OK";
            exit;

        } else{
            echo "Wrong Credential";    // invalid password
            exit;
        } 
    } else{
        echo "Wrong CredentialL";    // username does not exist
        exit;
    }

}

?>