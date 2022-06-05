<?php 
ob_start();  //This function will turn output buffering on
$active= 'reservations';
include 'includes/header.php';
include 'config/db_connect.php';

if(isset($_GET['edit'])){   // on edit icon click

  if($_GET['edit'] == 'new')
    include 'includes/reservation_new.php';   // create new reservation
  else
    include 'includes/reservation_edit.php';  // edit existing reservation

}else if(isset($_GET['dlt'])){  // on delete icon click

  // deleting from reservation table
  $sql2 = "DELETE FROM reservation WHERE id = ?";
  $query2 = $conn->prepare($sql2);
  $query2->execute([$_GET['dlt']]);

  // deleting from res_tab table
  $sql3 = "DELETE FROM res_tab WHERE rid = ?";
  $query3 = $conn->prepare($sql3);
  $query3->execute([$_GET['dlt']]);
  
  // redirect to all the reservations
  header('location: reservations.php');

}else if(isset($_GET['aprv'])){   // on approved icon click

  // change the status of selected reservation to approved
  $sql4 = "UPDATE reservation SET status = :status WHERE id = :rid";
  $query = $conn->prepare($sql4);
  $query->execute([
    ':status' => 'approved',
    ':rid' => $_GET['aprv']
  ]);

  // redirect to all the reservations
  header('location: reservations.php');

}else{
?>
    <!--Container Main start-->
    <div class="container py-3">
      <div class="row justify-content-between">
          <div class="col-auto">
          <h2>Reservations</h2>
          </div>
          <div class="col-auto">
            <a href="tables.php" class="btn btn-outline-primary ms-auto me-3">View Table</a>
            <a href="reservations.php?edit=new" class="btn btn-primary"><i class="bx bx-plus"></i></a>
          </div>
      </div>
      <hr>
      <?php

        $date = date("Y-m-d", strtotime("+1 day")); // set time to tomorrow
        $time = '%'; $status = '%'; $search = ''; $allDates='checked';

        if(isset($_POST['search-reservation'])){  // on filter search button click

          $dateInput = $_POST['date'];
          // convert to correct format for sql processing
          $date = date("Y-m-d", strtotime($dateInput));

          if(isset($_POST['allDates'])) // if checked
            $allDates = $_POST['allDates'];
          else
            unset($allDates);   // unset value if not checked

          $time = $_POST['time'];

          $status = $_POST['status'];

          if(isset($_POST['search'])) // if search textfield is filled
            $search = $_POST['search'];

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
            <label class="form-label">Search</label>
            <input type="text" class="form-control d-inline" name="search" placeholder="Search res." value="<?php echo $search ?>">
          </div>
          <div class="col-6 col-md-2"></div>
          <div class="col-12 col-md-2">
            <label class="form-label">Filter Search</label>
            <button type="submit" name="search-reservation" class="btn btn-secondary h-2rem pt-1 w-100" ><i class='bx bx-search'></i></button>
          </div>
        </div>
      </form>
      <div class="row g-5 mx-1">
        <?php 

          $tempDate = $date;
          if(isset($allDates))  // if checkbox checked
            $tempDate = '%';  // show all date
          
          // if input search blank var search is % i.e search for all
          $tempSearch = $search == '' ? '%' : $search; 

          // sql statement to get all details about reservation with filters
          // we want the exact phone number or id as in the textfield
          // in the order of booked, approved, check-in and finally check-out
          $sql = "SELECT * FROM reservation 
                  WHERE (id LIKE :search_exact 
                      OR uid = (SELECT id FROM users 
                                   WHERE id LIKE :search_exact 
                                   OR name LIKE :search 
                                   OR phone LIKE :search_exact))
                  AND date LIKE :date 
                  AND status LIKE :status 
                  AND time LIKE :time 
                  ORDER BY case when status = 'booked' then 1
                                when status = 'approved' then 2
                                when status = 'check-in' then 3
                                when status = 'check-out' then 4
                  else 5 end ASC, id DESC";
          $query = $conn->prepare($sql);
          $query->execute([
            ':search' => $search.'%',
            ':search_exact' => $tempSearch,
            ':date' => $tempDate,
            ':status' => $status,
            ':time' => $time
          ]);
          

          while($reservation = $query->fetch(PDO::FETCH_ASSOC)){

            // get user info for each reservation
            $sql2 = "SELECT * FROM users WHERE id = ?";
            $query2 = $conn->prepare($sql2);
            $query2->execute([$reservation['uid']]);
            $user = $query2->fetch(PDO::FETCH_ASSOC);
        ?>
          <div class="card bg-grey shadow rounded" style="border-left: 0.2rem solid 
          <?php 
          if($reservation['status'] == 'booked') echo 'var(--bs-info)';         // blue for booked
          if($reservation['status'] == 'approved') echo 'var(--bs-success)';    // green for approved
          if($reservation['status'] == 'check-in') echo 'var(--bs-light)';      // white for check-in
          if($reservation['status'] == 'check-out') echo 'var(--bs-secondary)'; // grey for check-out
          ?>;">
            <div class="card-body">
                <table class="table table-borderless nowrap">
                  <thead>
                    <tr>
                      <td scope="col">Reservation ID <?php echo $reservation['id'] ?></th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <th scope="col" >Date</th>
                    <th scope="col" >Time</th>
                    <th scope="col" >Booker</th>
                    <th scope="col" >Phone</th>
                    <th scope="col" >Guest</th>
                    <th scope="col" >Status</th>
                    <th scope="col" >Tables</th>
                    <th scope="col" class="text-center">Action</th>
                  </tr>
                  <tr> 
                    <!-- Date -->
                    <td><?php echo date("D, d M Y", strtotime($reservation['date'])) ?></td>
                    <!-- Time -->
                    <td><?php echo $reservation['time'].'pm' ?></td>
                    <!-- Name of booker -->
                    <td><?php echo $user['name'] ?></td>
                    <!-- Phone number of booker -->
                    <td><?php echo $user['phone'] ?></td>
                    <!-- Number of guest -->
                    <td class="ps-4"><?php echo $reservation['party_size'] ?></td>
                    <!-- Status of reservation -->
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
                    <!-- View table -->
                    <td class="ps-4">
                      <a href="tables.php?rid=<?php echo $reservation['id'] ?>" title='View table'><i class='bx bx-link-external'></i></a>
                    </td>
                    <!-- Action (Approve, Edit, Delete) -->
                    <td class="text-center">
                      <a href="reservations.php?aprv=<?php echo $reservation['id'] ?>" title='Approve'><i class='bx bx-check-square px-1' style="font-size:larger; color: var(--bs-success)"></i></a>
                      <a href="reservations.php?edit=<?php echo $reservation['id'] ?>" title='Edit'><i class='bx bxs-edit px-1' style="font-size:larger"></i></a>
                      <a href="reservations.php?dlt=<?php echo $reservation['id'] ?>" title='Delete'><i class='bx bxs-trash px-1' style="font-size:large; color: var(--bs-danger)"></i></a>
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
    
<?php } 
include 'includes/footer.php'; 
$conn==null; 
ob_end_flush(); // Flush (send) the output buffer and turn off output buffering
?>