<?php 
session_start();
if($_SESSION['is_admin'] != 'yes'){ header('location: /dinas/index.php'); die();}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />

    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

    <!-- Snackbar -->
    <link ref="stylesheet" type="text/css" href="css/snackbar.min.css" />
    
    <!-- My Styles -->
    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/sidenav.css" />
    <link rel="stylesheet" href="css/styles1.css">

    <?php if($active == 'menu') echo '<link rel="stylesheet" href="css/menu.css" />' ?>
    
  </head>

<?php if($active != 'login' || $active != 'register') include 'sidenav.php'; ?>