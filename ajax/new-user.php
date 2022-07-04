<?php
include '../config/db_connect.php';

if(isset($_POST['username']) &&  isset($_POST['password'])){

    $username = strtolower($_POST['username']);
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'] == '' ? NULL : $_POST['phone'];

    $sql_s = "SELECT * FROM users WHERE username = ?";
    $query_s = $conn->prepare($sql_s);
    $query_s->execute([$username]);
    
    if($query_s->rowCount() == 0){

        $sql = "INSERT INTO users(username,password,name,email,phone,is_admin) VALUES(:username,:password,:name,:email,:phone,:isAdmin)";
        $query = $conn->prepare($sql);
        $query->execute([
            ':username' => $username,
            ':password' => $password,
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':isAdmin' => 'no'
        ]);

        echo 0;
        exit;

    }else{

        echo 1;
        exit;
    }
}
exit;
?>