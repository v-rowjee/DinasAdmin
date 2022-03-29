<?php
include 'db_connect.php';

$id = $_GET['edit'];
$msg='';

$sql = "SELECT * FROM users WHERE id =?";
$query = $conn->prepare($sql);
$query->execute([$id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

$username = $user['username'];
$password = '';
$name = $user['name'];
$email = $user['email'];
$phone = $user['phone'];
$isAdmin = $user['is_admin'];

if(isset($_POST['delete'])){
    $sql_d = "DELETE FROM users WHERE id = ?";
    $query_d = $conn->prepare($sql_d);
    $query_d->execute([$id]);

    if($_SESSION['id'] == $id)
        header('location: includes/logout.php');
    else    
        header('loaction: users.php');

}else if(isset($_POST['cancel'])){
    header('location: users.php');

}else if(isset($_POST['save'])){

    $msg = '';
    
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $isAdmin = $_POST['isAdmin'];

    if($username == '') $msg="Username required";
    if($name == '') $msg="Name required";
    if($email == '') $msg="Email required";
    if($phone == '') $msg="Phone required";

    if($msg == ''){
        if(empty($_POST['password'])){
            $sql_u = "UPDATE users SET username = :username, name = :name, phone = :phone, email = :email, is_admin = :isAdmin WHERE id = :id";
            $query_u = $conn->prepare($sql_u);
            $query_u->execute([
                ':username' => $username,
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':isAdmin' => $isAdmin,
                ':id' => $id
            ]);
        }else{
            $hashed_password = password_hash($password,PASSWORD_DEFAULT);
            $sql_u = "UPDATE users SET username = :username, name = :name, phone = :phone, email = : email, is_admin = :isAdmin, password = :password WHERE id = :id";
            $query_u = $conn->prepare($sql_u);
            $query_u->execute([
                ':username' => $username,
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                '"is_admin' => $isAdmin,
                ':password' => $hashed_password,
                ':id' => $id
            ]);
        }

        if($_SESSION['id'] == $id)
            header('location: includes/logout.php');
        else    
            header('location: users.php');
    }
    
}

?>

<div class="container">
    <div class="row justify-content-center" style="min-height: calc(100vh - 50px)">
        <div class="col-12 col-md-6 align-self-center">
            <div class="card bg-grey shadow p-3">
                <div class="card-header">
                    <h4>User ID <?php echo $id ?></h4>
                </div>
                <div class="card-body overflow-x-hidden">
                    <form action="" method="post" class="row">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control mb-3" maxlength="16" name="username" value="<?php echo $username ?>" required pattern="[a-zA-Z0-9\._-]+">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="text" class="form-control mb-3" name="password" value="<?php echo $password ?>" maxlength="16">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control mb-3" name="name" value="<?php echo $name ?>" maxlength="24" pattern="[a-zA-Z\s]+" >
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control mb-3" name="phone" value="<?php echo $phone ?>" maxlength="16" pattern="[0-9\s\+]+">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <label class="form-label">Email</label>
                                <input type="mail" class="form-control mb-3" name="email" value="<?php echo $email ?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">Acc Type</label>
                                <select name="isAdmin" class="form-select">
                                    <option value="no" <?php if($isAdmin == 'no') echo 'selected' ?>>Normal</option>
                                    <option value="yes" <?php if($isAdmin == 'yes') echo 'selected' ?> >Admin</option>
                                </select>
                            </div>
                        </div>
                        <p class="msg text-center mx-0"><?php echo $msg ?></p>
                        <div class="row">
                            <div class="col-4">
                                <button type="submit" name="delete" class="btn btn-danger w-100">Delete</button>
                            </div>
                            <div class="col-4">
                                <button type="submit" name="cancel" class="btn btn-secondary w-100">Cancel</button>
                            </div>
                            <div class="col-4">
                                <button type="submit" name="save" class="btn btn-primary w-100">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>