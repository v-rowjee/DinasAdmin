<?php
if(isset($_GET['dlt'])){
    include 'db_connect.php';

    $sql = "DELETE FROM tables WHERE id = ?";
    $query = $conn->prepare($sql);
    $query->execute([$_GET['dlt']]);

    header('location: ../tables.php');
}