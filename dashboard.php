<?php 
$active= 'dashboard'; 
include_once 'includes/header.php';
include 'config/db_connect.php';

$sql = "SELECT * FROM users";
$query = $conn->prepare($sql);
$query->execute();
$num_of_users = $query->rowCount();

$sql2 = "SELECT * FROM menu";
$query2 = $conn->prepare($sql2);
$query2->execute();
$num_of_menus = $query2->rowCount();

$sql3 = "SELECT * FROM reservation WHERE date = CURDATE()";
$query3 = $conn->prepare($sql3);
$query3->execute();
$num_of_reservations = $query3->rowCount();


?>
    <!--Container Main start-->
    <div class="container py-3">
      <div class="row">
        <div class="col">
          <h2>Dashboard</h2>
        </div>
        <div class="col mt-2">
          <a href="/dinas/index.php" target="_blank" class="text-reset opacity-75 float-end">
            <span>Go to Homepage</span>
          </a>
        </div>
      </div>
      <div class="row mt-2 g-5">
        <div class="col-12 col-sm-6 col-md-4">
          <a href="users.php" title="Users" class="text-reset card bg-grey shadow p-4">
            <div class="card-header">
            <h5>Number of <br> Users</h5>
            </div>
            <div class="card-body overflow-x-hidden">
              <h5 class="display-5 opacity-100"><?php echo $num_of_users ?></h5>
            </div>
          </a>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <a href="menu.php" title="Menu" class="text-reset card bg-grey shadow p-4">
            <div class="card-header">
              <h5>Number of <br> items on Menu</h5>
            </div>
            <div class="card-body overflow-x-hidden">
              <h5 class="display-5 opacity-100"><?php echo $num_of_menus ?></h5>
            </div>
          </a>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <a href="reservations.php" title="Reservations" class="text-reset card bg-grey shadow p-4">
            <div class="card-header">
              <h5>Number of <br> Reservations today</h5>
            </div>
            <div class="card-body overflow-x-hidden">
              <h5 class="display-5 opacity-100"><?php echo $num_of_reservations ?></h5>
            </div>
          </a>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
          <a href="https://www.tidio.com/panel/conversations" target="_blank" title="Tidio Chat Bot" class="text-reset card bg-grey shadow p-4">
            <div class="card-header">
              <h5>Tido <br> Panel Conversations</h5>
            </div>
            <div class="card-body overflow-x-hidden">
              <h5 class="opacity-25">https://www.tidio.com/panel/conversations</h5>
            </div>
          </a>
        </div>
      </div>
  </div>
    <!--Container Main end-->
<?php include 'includes/footer.php' ?>
