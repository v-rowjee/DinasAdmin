<?php 
$active= 'users'; 
include 'includes/header.php'; 
include 'config/db_connect.php';

if(isset($_GET['dlt'])){

    $sql2 = "DELETE FROM users WHERE id = ?";
    $query2 = $conn->prepare($sql2);
    $query2->execute([$_GET['dlt']]);
    
    header('location: users.php');
  
}else if(isset($_GET['edit'])){

    include 'includes/user_edit.php';

}else{

?>
<!--Container Main start-->
<div class="container py-3">
    <!-- ADMIN Search Bar -->
    <div class="d-flex align-items-center mb-4">
        <h2 class="me-auto">Admins</h2>
        <form method="post" class="flex-row-reverse">
            <div class="input-group">
                <input type="text" class="form-control" id="search_a" onkeyup="searchAdmin()" placeholder="Search Admin">
                <button type="button" class="input-group-text">
                    <i class='bx bx-search'></i>
                </button>
            </div>

            <a href="" class="input-group-text me-3" data-bs-toggle="modal" data-bs-target="#addAdmin">
                <i class="bx bx-plus"></i>
            </a>
        </form>
    </div>
    <div class="card bg-grey shadow rounded mb-4">
        <div class="card-body">
            <table class="table table-borderless nowrap">
            <thead>
                <tr>
                <th scope="col" class="px-4">ID</th>
                <th scope="col">Username</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col" class="text-end pe-4">Action</th>
                </tr>
            </thead>
            <tbody id="output_a"></tbody>
            </table>
        </div>
    </div>
    <!-- USER Search Bar -->
    <div class="d-flex align-items-center mb-4">
        <h2 class="me-auto">Users</h2>
        <form class="flex-row-reverse">
            <div class="input-group">
                <input type="text" class="form-control" onkeyup="searchUser()" id="search" placeholder="Search User">
                <button type="button" class="input-group-text">
                    <i class='bx bx-search'></i>
                </button>
            </div>
            <a class="input-group-text me-3" data-bs-toggle="modal" data-bs-target="#addUser">
                <i class="bx bx-plus"></i>
            </a>
        </form>
    </div>
    <div class="card bg-grey shadow rounded mb-4">
        <div class="card-body">
            <table class="table table-borderless nowrap">
            <thead>
                <tr>
                <th scope="col" class="ps-4">ID</th>
                <th scope="col">Username</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col" class="text-end pe-4">Action</th>
                </tr>
            </thead>
            <tbody id="output"></tbody>
            </table>
        </div>
    </div>
</div>
<!--Container Main end-->

<script>    
    searchUser();
    searchAdmin();

    function searchUser(){
        $.ajax({
            type:'POST',
            url:'ajax/search-user.php',
            data:{
                search:$("#search").val(),
            },
            success:function(data){
                $("#output").html(data);
            },
            error: (xhr) => alert("Error Occured: "+xhr.status+" "+xhr.statusText) 
        });
    }
    function searchAdmin(){
        $.ajax({
            type:'POST',
            url:'ajax/search-admin.php',
            data:{
                search:$("#search_a").val(),
            },
            success:function(data){
                $("#output_a").html(data);
            },
            error: (xhr) => alert("Error Occured: "+xhr.status+" "+xhr.statusText) 
        });
    }
</script>

<!-- Modal for Admin -->
<?php
    $msg_a = '';
    $username_a = '';
    $password_a = '';
    $name_a = '' ;
    $email_a = '';
    $phone_a = '';
    if(isset($_POST['submit-admin'])){
        $username_a = strtolower($_POST['username_a']);
        $password_a = password_hash($_POST['password_a'],PASSWORD_DEFAULT);
        $name_a = $_POST['name_a'];
        $email_a = $_POST['email_a'];
        $phone_a = $_POST['phone_a'];

        // validations
        if(empty($username_a)) $msg_a = 'Username required';
        if(empty($password_a)) $msg_a = 'Password required';
        if(empty($name_a)) $msg_a = 'Name required';
        if(empty($email_a)) $msg_a = 'Email required';
        if(empty($phone_a)) $msg_a = 'Phone required';

        if($msg_a == ''){
            $sql_a = "INSERT INTO users(username,password,name,email,phone,is_admin) VALUES(:username,:password,:name,:email,:phone,:isAdmin)";
            $query_a = $conn->prepare($sql_a);
            $query_a->execute([
                ':username' => $username_a,
                ':password' => $password_a,
                ':name' => $name_a,
                ':email' => $email_a,
                ':phone' => $phone_a,
                ':isAdmin' => 'yes'
            ]);
        }else{
            $password_a = '';
            echo '<script>alert("'.$msg_a.'")</script>';
        }
            
    }
?>
<div class="modal fade" id="addAdmin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="" method="post">
        <div class="modal-content bg-grey">
            <div class="modal-header">
                <h5 class="modal-title">New Admin Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control mb-3" pattern="[a-zA-Z0-9\._-]+" maxlength="16" name="username_a" value="<?php echo $username_a ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control mb-3" name="password_a" maxlength="16" value="<?php echo $password_a ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control mb-3" name="name_a" maxlength="24" pattern="[a-zA-Z\.\s]+" value="<?php echo $name_a ?>">
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control mb-3" name="phone_a" pattern="[0-9\s\+]+" maxlength="16" value="<?php echo $phone_a ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="mail" class="form-control mb-3" name="email_a" value="<?php echo $email_a ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit-admin" class="btn btn-primary me-4">Create new</button>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- Modal for User -->
<div class="modal fade" id="addUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <form id="new-user-form" method="post">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title">New User Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control mb-3" name="username" maxlength="16" pattern="[a-zA-Z0-9\._-]+" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Password</label>
                        <input type="text" class="form-control mb-3" name="password" maxlength="16" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control mb-3" name="name" maxlength="24" pattern="[a-zA-Z\.\s]+" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control mb-3" name="phone" maxlength="16" pattern="[0-9\s\+]+">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control mb-3" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <p class="msg float-start m-0 me-5" id="msg"></p>
                <button type="button" class="btn btn-secondary" id="close-user" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary me-4" id="create-user">Create new</button>
            </div>
        </div>
    </form>
    </div>
</div>

<script>
    // used js library to validate
    $('#new-user-form').validate({
        rules: {
            username: {
                required: true,
                minlength: 1,
                maxlength: 32
            },
            password: {
                required: true,
                minlength: 1,
                maxlength: 32
            },
            name: {
                required: true,
                minlength: 1,
                maxlength: 32
            },
            phone: {
                required: false,
                minlength: 0,
                maxlength: 16
            },
            email: {
                required: true,
                email: true,
                maxlength: 64
            },
        },
        highlight: function (input) {
            $(input).addClass('is-invalid');
        },
        unhighlight: function (input) {
            $(input).removeClass('is-invalid');
        },
        errorPlacement: function (error, element) {
            $(element).next().append(error);
        },
        messages: {
            username: "Username required",
            name: "Name required",
            password: "Password required",
            email: "Invalid email",
            phone: "Invalid phone number"
        },
        submitHandler: function (form, e) {
            e.preventDefault()

            $.ajax({
                method: "POST",
                url: "ajax/new-user.php",
                data: $('#new-user-form').serialize(),
                success: (data)=>{
                    if(data == 0){
                        location.reload();
                    }
                    else if(data == 1){
                        $('#msg').html("Username already exist")
                    }
                    else{
                        $('#msg').html("An Error occured")
                    }
                },
                error: (xhr) => alert("Error Occured: "+xhr.status+" "+xhr.statusText) 
            })
        }
    })

    $('#close-user').click(()=>{
        $('#new-user-form')[0].reset();
        $('#msg').html("");
    })
</script>

<?php } include 'includes/footer.php' ?>