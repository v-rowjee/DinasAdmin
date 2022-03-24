<?php
$sql = "SELECT * FROM reservation WHERE id = ?";
$query = $conn->prepare($sql);
$query->execute([$_GET['edit']]);
$reservation = $query->fetch(pdo::FETCH_ASSOC);

$sql = "SELECT * FROM users WHERE id = ?";
$query = $conn->prepare($sql);
$query->execute([$reservation['uid']]);
$user = $query->fetch(pdo::FETCH_ASSOC);

$uid =$user['id']; $date=$reservation['date'] ;$time=$reservation['time']; $guest=$reservation['party_size']; $status=$reservation['status'];
$msg ='';

if(isset($_POST['cancel'])){
    header('location: reservations.php');
}
if(isset($_POST['delete'])){
    $sql2 = "DELETE FROM reservation WHERE id = ?";
    $query2 = $conn->prepare($sql2);
    $query2->execute([$_GET['edit']]);

    $sql3 = "DELETE FROM res_tab WHERE rid = ?";
    $query3 = $conn->prepare($sql3);
    $query3->execute([$_GET['edit']]);
    
    header('location: reservations.php');
}
if(isset($_POST['save'])){

    $uid=$_POST['uid']; $date=$_POST['date'] ;$time=$_POST['time']; $guest=$_POST['guest']; $status=$_POST['status'];

    ####    VALIDATION FOR STATUS CHECK OUT   #### NOT WORKING
    if($status == 'check-out'){
        $sql6 = "DELETE FROM res_tab WHERE rid = ? ";
        $result6 = $conn->prepare($sql6);
        $result6->execute([$_GET['edit']]);
    }

    ####    VALIDATION FOR GUEST   ####
    $tables_needed = ceil($guest/2);
    // get num of reservation at input date and time
    $sql1 = "SELECT * FROM res_tab WHERE rid = (SELECT id FROM reservation WHERE date = :date AND time = :time AND status <> :status AND uid = :uid)"; 
    $result1 = $conn->prepare($sql1); 
    $result1->execute([
        ':date' => $date,
        ':time' => $time,
        ':status' => 'check-out',
        ':uid' => $uid
    ]); 
    $num_of_reservations = $result1->rowCount();
    // get num of tables 
    $sql2 = "SELECT * FROM tables "; 
    $result2 = $conn->prepare($sql2); 
    $result2->execute(); 
    $num_of_tables = $result2->rowCount();
    if(($tables_needed+$num_of_reservations) > $num_of_tables) // if num of table not enough(restaurant full) when current reservation is added
        $msg = "Restaurant full at this time";
    else{
        // update reservation
        $sql2 = "UPDATE reservation SET uid=:uid, date=:date, time=:time, party_size=:guest, status=:status WHERE id = :id";
        $query2 = $conn->prepare($sql2);
        $query2->execute([
            ':uid' => $uid,
            ':date'=> $date,
            ':time'=> $time,
            ':guest'=> $guest,
            ':status'=> $status,
            ':id' => $_GET['edit']
        ]);
        // put n rows for n table needed
        $sql4 = "DELETE FROM res_tab WHERE rid LIKE ?";
        $result4 = $conn->prepare($sql4);
        $result4->execute([$_GET['edit']]);

        $sql3 = "INSERT INTO res_tab (rid, tid) VALUES (:rid,:tid)";
        $result3 = $conn->prepare($sql3);
        
        for($i=0; $i < $tables_needed; $i++){
            $result3->execute([
                ':rid' => $_GET['edit'],
                ':tid' => $num_of_reservations+1+$i
            ]); 
        }
        header('location: reservations.php');     
    }
}


?>

<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6 align-self-center">
            <div class="card bg-dark shadow p-4"> 
            <div class="card-header">
                <h4 class="modal-title text-gold">Reservation ID <?php echo $_GET['edit'] ?></h4>
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
                            <input type="text" class="form-control bg-transparent" value="<?php echo $user['phone'] ?>" disabled>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control bg-transparent" value="<?php echo $user['name'] ?>" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Guest</label>
                            <input type="number" name="guest" class="form-control" value="<?php echo $guest ?>" min=0>
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
                        <div class="col-12 col-md-3">
                            <button type="submit" name="cancel" class="btn btn-secondary w-100">Cancel</button>
                        </div>
                        <div class="col-12 col-md-3">
                            <button type="submit" name="delete" class="btn btn-danger w-100">Delete</button>
                        </div>
                        <div class="col-12 col-md-6">
                            <button type="submit" name="save" class="btn btn-primary w-100">Save changes</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>