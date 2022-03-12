<?php 
$active= 'reservations';
include 'includes/header.php';
include 'includes/db_connect.php';
?>
    <!--Container Main start-->
    <div class="container py-3">
      <div class="row justify-content-between">
          <div class="col-auto">
          <h2>Reservations</h2>
          </div>
          <div class="col-auto col-md-3 text-end">
            <a href="" class="btn btn-primary my-auto me-2" title="Export"><i class='bx bxs-download'></i></a>
            <a href="/dinas/reservation.php" class="btn btn-primary my-auto">New Reservation</a>
          </div>
      </div>
      <hr>
      <?php

        $date = date("Y-m-d"); $time = 'all'; $status = 'booked';

        if(isset($_POST['search-reservation'])){

          $dateInput = $_POST['date'];
          $date = date("Y-m-d", strtotime($dateInput));

          $time = $_POST['time'];

          $status = $_POST['status'];

        }


      ?>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="d-inline">
        <div class="row mb-5">
          <div class="col-12 col-md-2">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" name="date" id="datepicker">
          </div>
          <div class="col-12 col-md-2">
            <label class="form-label">Time</label>
            <select class="form-select" name="time">
              <option <?php if($time == 'all') echo 'selected' ?>>View All</option>
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
              <option value="all" <?php if($status == 'all') echo 'selected' ?>>&#x2630; View All</option>
              <option value="booked" <?php if($status == 'booked') echo 'selected' ?>>&#x2691; Booked</option>
              <option value="approved" <?php if($status == 'approved') echo 'selected' ?>>&#x2714; Approved</option>
              <option value="check-in" <?php if($status == 'check-in') echo 'selected' ?>>&#x21e5; Check In</option>
              <option value="check-out" <?php if($status == 'check-out') echo 'selected' ?>>&#x21a4; Check Out</option>
              <option value="cancelled" <?php if($status == 'cancelled') echo 'selected' ?>>&#x292B; Cancelled</option>
            </select>
          </div>
          <div class="col-12 col-md-3"></div>
          <div class="col-12 col-md-3">
            <label class="form-label">Search</label>
            <div class="input-group mb-3 w-100">
              <input type="text" class="form-control d-inline" name="search">
              <button type="submit" name="search-reservation" class="input-group-text" title="Search">
                <i class='bx bx-search'></i>
              </button>
            </div>
          </div>
        </div>
      </form>
      <div class="row g-5">
        <?php 
          $whereDate =''; 

          if($time != 'all')
            $whereTime = ' AND time = '.$time;
          else 
            $whereTime = '';
          
          if($status != 'all')
            $whereStatus = ' AND status = '.$status;
          else 
            $whereStatus = '';

          $sql1 = "SELECT * FROM reservation r INNER JOIN users u ON u.id = r.uid WHERE date = :date".$whereTime.$whereStatus;
          $query1 = $conn->prepare($sql1);
          $query1->execute([
            ':status' => $status,
            ':date' => $date
          ]);

          while($reservation = $query1->fetch(PDO::FETCH_ASSOC)){
        ?>
          <div class="card bg-dark shadow rounded">
            <div class="card-body">
                <table class="table table-borderless">
                  <thead class="card-header">
                    <tr>
                      <td scope="col">Reservation ID <?php echo $reservation['id'] ?></th>
                      <td scope="col"></td>
                    </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <th scope="col" class="col-2">Date</th>
                      <th scope="col" class="col-2">Time</th>
                      <th scope="col" class="col-2">Booker</th>
                      <th scope="col" class="col-2">Phone</th>
                      <th scope="col" class="col-2">Guest</th>
                      <th scope="col" class="col-2">Status</th>
                    </tr>
                  <tr> 
                    <td><?php echo date("D, d M Y", strtotime($reservation['date'])) ?></td>
                    <td><?php echo $reservation['time'].'pm' ?></td>
                    <td><?php echo $reservation['name'] ?></td>
                    <td><?php echo $reservation['phone'] ?></td>
                    <td><?php echo $reservation['party_size'] ?></td>
                    <td>
                    <select class="form-select" style="width: 10rem;" <?php if($reservation['status'] == 'cancelled') echo 'disabled' ?>>
                      <option value="booked" <?php if($reservation['status'] == 'booked') echo 'selected' ?>>Booked</option>
                      <option value="approved" <?php if($reservation['status'] == 'approved') echo 'selected' ?>>Approved</option>
                      <option value="checked-in" <?php if($reservation['status'] == 'checked-in') echo 'selected' ?>>Checked In</option>
                      <option value="checked-out" <?php if($reservation['status'] == 'checked-out') echo 'selected' ?>>Checked Out</option>
                      <option value="cancelled" <?php if($reservation['status'] == 'cancelled') echo 'selected' ?>>Cancelled</option>
                    </select>
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
    
<?php include 'includes/footer.php' ?>