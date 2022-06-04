<?php 
session_start();
if(isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 'no'){ header('location: /dinas/index.php'); die();}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | <?php if(isset($active)) echo ucfirst($active) ?> </title>

    <link rel="icon" type="image/x-icon" href="favicon.ico">
    
    <!-- JQueries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />

    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- My Styles -->
    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/sidenav.css" />
    <link rel="stylesheet" href="css/styles1.css">

    <?php if($active == 'menu') echo '<link rel="stylesheet" href="css/menu.css" />' ?>
    
  </head>

<?php if(($active != 'login') && ($active != 'register')) include 'sidenav.php'; ?>