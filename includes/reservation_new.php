<?php
    include 'db_connect.php';

    $msg = ''; 
    $uid = ''; 
    $date = date("Y-m-d", strtotime("+1 day")); // set default date to tomorrow
    $time = '5'; // set default time to 5
    $guest = '2'; // set default party size to 2
    $status='approved'; // set default status to approved

    if(isset($_POST['create'])){

        $conn->beginTransaction();

        // getting user input from textfields
        $uid =$_POST['uid']; $date=$_POST['date'] ;$time=$_POST['time']; $guest=$_POST['guest']; $status=$_POST['status'];
        
        $sql = "SELECT * FROM reservation WHERE uid = :uid AND status <> :status";
        $query = $conn->prepare($sql);
        $query->execute([
            ':uid' => $uid,
            ':status' => 'check-out'
        ]);
        if($query->rowCount() > 0)
            $msg = 'User already has a reservation';
        else{
        

        ####    VALIDATION FOR GUEST   ####

        // get num of tables 
        $sql2 = "SELECT * FROM tables"; 
        $result2 = $conn->prepare($sql2); 
        $result2->execute(); 
        $num_of_tables = $result2->rowCount();
        $tot_res = $num_of_tables*2;
        
        // get num of reservation at input date and time
        $sql1 = "SELECT * FROM res_tab WHERE rid IN(SELECT id FROM reservation WHERE date = :date AND time = :time AND status <> :status)"; 
        $result1 = $conn->prepare($sql1); 
        $result1->execute([
            ':date' => $date,
            ':time' => $time,
            ':status' => 'check-out'
        ]); 
        $table_booked = $result1->rowCount(); // num of tables booked on same datetime
        $tables_available = $num_of_tables - $table_booked; // num of tables available
        $res_available = $tables_available*2;   // num of reservation available

        if($guest > $res_available) // if num of table not enough(restaurant full) when current reservation is added
            $msg = "Restaurant full at this time";
        else{
            $msg ='';
            // if table available, add a new reservation
            $sql5 = "INSERT INTO reservation (uid,party_size,date,time,status) VALUES (:uid,:size,:date,:time,:status)";
            $result5 = $conn->prepare($sql5);
            $result5->execute([
                ':uid' => $uid,
                ':size' => $guest,
                ':date' => $date,
                ':time' => $time,
                ':status' => $status
            ]);
            //  new rid
            $newRID = $conn->lastInsertId();
            // get num of tables needed from party size
            $tables_needed = ceil($guest / 2);

            $sql3 = "INSERT INTO res_tab (rid, tid) VALUES (:rid,:tid)";
            $result3 = $conn->prepare($sql3);
            
            
            for($i=1; $i <= $tables_needed; $i++){
                $result3->execute([
                    ':rid' => $newRID,
                    ':tid' => $table_booked+$i
                ]); 
            }

            $conn->commit();

            header('location: reservations.php');
        }
    }

    }
    if(isset($_POST['discard'])){
        header('location: reservations.php');
    }
?>

<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 align-self-center">
            <div class="card bg-grey shadow p-4"> 
            <div class="card-header">
                <h4 class="text-gold">Reservation ID <?php echo $_GET['edit'] ?></h4>
            </div>

            <form action="" method="post">
                <div class="card-body" style="overflow-x: hidden;">
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" value="<?php echo $date ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Time</label>
                            <select class="form-select" name="time">
                                <option value="5" <?php if($time == '5') echo 'selected' ?>>5pm</option>
                                <option value="6" <?php if($time == '6') echo 'selected' ?>>6pm</option>
                                <option value="7" <?php if($time == '7') echo 'selected' ?>>7pm</option>
                                <option value="8" <?php if($time == '8') echo 'selected' ?>>8pm</option>
                                <option value="9" <?php if($time == '9') echo 'selected' ?>>9pm</option>
                                <option value="10" <?php if($time == '10') echo 'selected' ?>>10pm</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-2">
                            <label class="form-label">Id</label>
                            <input type="text" name="uid" class="form-control" value="<?php echo $uid ?>">
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control bg-transparent" value="" disabled>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control bg-transparent" value="" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Guest</label>
                            <input type="number" name="guest" class="form-control" value="<?php echo $guest ?>" min=1>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="booked" <?php if($status == 'booked') echo 'selected' ?>>Booked</option>
                                <option value="approved" <?php if($status == 'approved') echo 'selected' ?>>Approved</option>
                                <option value="check-in" <?php if($status == 'check-in') echo 'selected' ?>>Check In</option>
                                <option value="check-out" <?php if($status == 'check-out') echo 'selected' ?>>Check Out</option>
                            </select>
                        </div>
                    </div>
                    <div class="row gy-1 msg"><?php echo $msg ?></div>
                    <div class="row mb-3 gy-1">
                        <div class="col-12 col-md-6">
                            <button type="submit" name="discard" class="btn btn-danger w-100">Discard</button>
                        </div>
                        <div class="col-12 col-md-6">
                            <button type="submit" name="create" class="btn btn-primary w-100">Create New</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>