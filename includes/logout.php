<?php
session_start();
session_destroy();
header("location: /dinasadmin/login.php");
die();
?>