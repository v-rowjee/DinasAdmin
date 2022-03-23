<?php 
ob_start();
$active= 'reservations';
include 'includes/header.php';
include 'includes/db_connect.php';

if(isset($_GET['edit'])){
  if($_GET['edit'] == 'new')
    include 'includes/reservation_new.php';
  else
    include 'includes/reservation_edit.php';

}else if(isset($_GET['dlt'])){

  $sql2 = "DELETE FROM reservation WHERE id = ?";
  $query2 = $conn->prepare($sql2);
  $query2->execute([$_GET['dlt']]);

  $sql3 = "DELETE FROM res_tab WHERE rid = ?";
  $query3 = $conn->prepare($sql3);
  $query3->execute([$_GET['dlt']]);
  
  header('location: reservations.php');

}else{
?>
    <!--Container Main start-->
    <div class="container py-3">
      <div class="row justify-content-between">
          <div class="col-auto">
          <h2>Reservations</h2>
          </div>
          <div class="col-auto text-end">
            <a href="tables.php" class="btn btn-outline-primary ms-auto me-3">View Table</a>
            <a href="reservations.php?edit=new" class="btn btn-primary"><i class="bx bx-plus"></i></a>
          </div>
      </div>
      <hr>
      <?php

        $date = date("Y-m-d"); $time = '%'; $status = '%'; $search = ''; $search_res='';$allDates='checked';

        if(isset($_POST['search-reservation'])){

          $dateInput = $_POST['date'];
          $date = date("Y-m-d", strtotime($dateInput));

          if(isset($_POST['allDates']))
            $allDates = $_POST['allDates'];
          else
            unset($allDates);

          $time = $_POST['time'];

          $status = $_POST['status'];

          $search = $_POST['search'];

          $search_res = $_POST['search-res'];

        }
      ?>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="d-inline" >
        <div class="row mb-5">
          <div class="col-12 col-md-2 pe-1">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" name="date" value="<?php echo $date ?>">
            <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" name="allDates" value="checked" <?php if(isset($allDates))echo 'checked' ?>>
            <label class="form-check-label">Show all date</label>
          </div>
          </div>
          <div class="col-12 col-md-2">
            <label class="form-label">Time</label>
            <select class="form-select" name="time">
              <option value="%" <?php if($time == '%') echo 'selected' ?>>View All</option>
              <option value="5" <?php if($time == '5') echo 'selected' ?>>5pm</option>
              <option value="6" <?php if($time == '6') echo 'selected' ?>>6pm</option>
              <option value="7" <?php if($time == '7') echo 'selected' ?>>7pm</option>
              <option value="8" <?php if($time == '8') echo 'selected' ?>>8pm</option>
              <option value="9" <?php if($time == '9') echo 'selected' ?>>9pm</option>
              <option value="10" <?php if($time == '10') echo 'selected' ?>>10pm</option>
            </select>
          </div>
          <div class="col-12 col-md-2">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
              <option value="%" <?php if($status == '%') echo 'selected' ?>>&#x2630; View All</option>
              <option value="booked" <?php if($status == 'booked') echo 'selected' ?>>&#x2691; Booked</option>
              <option value="approved" <?php if($status == 'approved') echo 'selected' ?>>&#x2714; Approved</option>
              <option value="check-in" <?php if($status == 'check-in') echo 'selected' ?>>&#x21e5; Check In</option>
              <option value="check-out" <?php if($status == 'check-out') echo 'selected' ?>>&#x21a4; Check Out</option>
            </select>
          </div>
          <div class="col-6 col-md-2">
            <label class="form-label">Res. ID</label>
            <input type="number" class="form-control d-inline" name="search-res" value="<?php echo $search_res ?>">
          </div>
          <div class="col-6 col-md-2">
            <label class="form-label">User ID</label>
            <input type="number" class="form-control d-inline" name="search" value="<?php echo $search ?>">
          </div>
          <!-- <div class="col-12 col-md-0"></div> -->
          <div class="col-12 col-md-2">
            <label class="form-label">Filter Search</label>
            <button type="submit" name="search-reservation" class="btn btn-secondary h-2rem pt-1 w-100" ><i class='bx bx-search'></i></button>
          </div>
        </div>
      </form>
      <div class="row g-5 mx-1">
        <?php 

          $tempDate = $date;
          if(isset($allDates))
            $tempDate = '%';

          $sql = "SELECT * FROM reservation WHERE id LIKE :search_res AND uid LIKE :search AND date LIKE :date AND status LIKE :status AND time LIKE :time ORDER BY status";
          $query = $conn->prepare($sql);
          $query->execute([
            ':search_res' => $search_res.'%',
            ':search' => $search.'%',
            ':date' => $tempDate,
            ':status' => $status,
            ':time' => $time
          ]);
          

          while($reservation = $query->fetch(PDO::FETCH_ASSOC)){
            $sql2 = "SELECT * FROM users WHERE id = ?";
            $query2 = $conn->prepare($sql2);
            $query2->execute([$reservation['uid']]);
            $user = $query2->fetch(PDO::FETCH_ASSOC);
        ?>
          <div class="card bg-dark shadow rounded" style="border-left: 0.3rem solid 
          <?php 
          if($reservation['status'] == 'booked') echo 'var(--bs-info)';
          if($reservation['status'] == 'approved') echo 'var(--bs-success)';
          if($reservation['status'] == 'check-in') echo 'var(--bs-light)';
          if($reservation['status'] == 'check-out') echo 'var(--bs-secondary)';
          ?>;">
            <div class="card-body">
                <table class="table table-borderless nowrap">
                  <thead class="card-header">
                    <tr>
                      <td scope="col">Reservation ID <?php echo $reservation['id'] ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <th scope="col" class="col-3x">Date</th>
                    <th scope="col" class="col-1x">Time</th>
                    <th scope="col" class="col-2x">Booker</th>
                    <th scope="col" class="col-2x">Phone</th>
                    <th scope="col" class="col-1x">Guest</th>
                    <th scope="col" class="col-2x">Status</th>
                    <th scope="col" class="col-3x">Action</th>
                  </tr>
                  <tr>
                    <td><?php echo date("D, d M Y", strtotime($reservation['date'])) ?></td>
                    <td><?php echo $reservation['time'].'pm' ?></td>
                    <td><?php echo $user['name'] ?></td>
                    <td><?php echo $user['phone'] ?></td>
                    <td><?php echo $reservation['party_size'] ?></td>
                    <td>
                      <span class="text-capitalize text-dark
                      <?php 
                        if($reservation['status'] == 'booked') echo 'badge bg-info';
                        if($reservation['status'] == 'approved') echo 'badge bg-success';
                        if($reservation['status'] == 'check-in') echo 'badge bg-light';
                        if($reservation['status'] == 'check-out') echo 'badge bg-secondary';
                      ?>">
                      <?php echo $reservation['status'] ?>
                      </span>
                    </td>
                    <td>
                      <a href="reservations.php?edit=<?php echo $reservation['id'] ?>"><i class='bx bxs-edit pe-2' style="font-size:larger"></i></a>
                      <a href="reservations.php?dlt=<?php echo $reservation['id'] ?>"><i class='bx bxs-trash' style="font-size:larger; color: var(--bs-danger)"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        <?php } ?>
      </div>
      
    </div>
    <!--Container Main end-->
    
<?php } include 'includes/footer.php'; $conn==null; ob_end_flush(); ?>