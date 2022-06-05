<?php

function setMenuJson(){
    include 'config/db_connect.php';
    $sql = "SELECT * FROM menu";
    $query = $conn->prepare($sql);
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($data);
    $filename = 'json/menu.json';
    file_put_contents($filename,$json);
}