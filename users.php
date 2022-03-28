<?php $active= 'users'; include 'includes/header.php'; include 'includes/db_connect.php' ?>
    <!--Container Main start-->
    <div class="container py-3">
        <!-- ADMIN Search Bar -->
        <div class="d-flex align-items-center mb-4">
            <h2 class="me-auto">Admins</h2>
            <?php
                $search_a = '';

                if(isset($_POST['search-admin'])){
                    $search_a = $_POST['search-input-admin'];

                }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="flex-row-reverse">
                <div class="input-group">
                    <input type="text" name="search-input-admin" class="form-control" placeholder="Search Admin" value="<?php echo $search_a ?>">
                    <button type="submit" name="search-admin" class="input-group-text" title="Search">
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
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        // search for the exact keyword that user input
                        $exactId_a = $search_a;
                        if($exactId_a == '')    //if no user input search
                            $exactId_a = '%'; //search all
                        // search for keywords containing string from input
                        $temp_a = '%'.$search_a.'%';
                        if($temp_a == '')
                            $temp_a = '%';  
                            
                        $sql_a = "SELECT * FROM users WHERE (is_admin = 'yes') AND (id LIKE :id OR username LIKE :username OR name LIKE :name OR email LIKE :email OR phone LIKE :phone)";
                        $query_a = $conn->prepare($sql_a);
                        $query_a->execute([
                            ':id' => $exactId_a,
                            ':username' => $temp_a,
                            ':name' => $temp_a,
                            ':email' => $temp_a,
                            ':phone' => $temp_a,
                        ]);
                        // if no data found from input print error message
                        if($query_a->rowCount() == 0){
                            echo '<p class="msg">No Result</p>';
                        }
                        while($admin = $query_a->fetch(PDO::FETCH_ASSOC)){ 
                    ?>
                        <tr>
                        <th scope="row" class="px-4"><?php echo $admin['id'] ?></th>
                        <td><?php echo $admin['username'] ?></td>
                        <td><?php echo $admin['name'] ?></td>
                        <td><?php echo $admin['email'] ?></td>
                        <td><?php echo $admin['phone'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
        </div>
        <!-- USER Search Bar -->
        <div class="d-flex align-items-center mb-4">
            <h2 class="me-auto">Users</h2>
            <?php
                $search = '';

                if(isset($_POST['search'])){
                    $search = $_POST['search-input'];

                }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="flex-row-reverse">
                <div class="input-group">
                    <input type="text" name="search-input" class="form-control" placeholder="Search User" value="<?php echo $search ?>">
                    <button type="submit" name="search" class="input-group-text" title="Search">
                        <i class='bx bx-search'></i>
                    </button>
                </div>

                <a href="" class="input-group-text me-3" data-bs-toggle="modal" data-bs-target="#addUser">
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
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $exactId = $search;
                        if($exactId == '')
                            $exactId = '%';
                        $temp = '%'.$search.'%';
                        if($temp == '')
                            $temp = '%';
                            
                        $sql = "SELECT * FROM users WHERE (is_admin = 'no') AND (id LIKE :id OR username LIKE :username OR name LIKE :name OR email LIKE :email OR phone LIKE :phone)";
                        $query = $conn->prepare($sql);
                        $query->execute([
                            ':id' => $exactId,
                            ':username' => $temp,
                            ':name' => $temp,
                            ':email' => $temp,
                            ':phone' => $temp,
                        ]);
                        if($query_a->rowCount() == 0){
                            echo '<p class="msg">No Result</p>';
                        }
                        while($user = $query->fetch(PDO::FETCH_ASSOC)){ 
                    ?>
                        <tr>
                        <th scope="row" class="px-4"><?php echo $user['id'] ?></th>
                        <td><?php echo $user['username'] ?></td>
                        <td><?php echo $user['name'] ?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><?php echo $user['phone'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--Container Main end-->

    <!-- Modal for Admin -->
    <?php
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
    }

    ?>
    <div class="modal fade" id="addAdmin" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-grey">
            <div class="modal-header">
                <h5 class="modal-title">New Admin Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="row justify-content-center">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control mb-3" name="username_a" value="<?php echo $username_a ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control mb-3" name="password_a" value="<?php echo $password_a ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control mb-3" name="name_a" value="<?php echo $name_a ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control mb-3" name="phone_a" value="<?php echo $phone_a ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="mail" class="form-control mb-3" name="email_a" value="<?php echo $email_a ?>">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit-admin" class="btn btn-primary me-4">Create new</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal for User -->
    <?php
    $username = '';
    $password = '';
    $name = '' ;
    $email = '';
    $phone = '';

    if(isset($_POST['submit'])){
        $username = strtolower($_POST['username']);
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $sql = "INSERT INTO users(username,password,name,email,phone,is_admin) VALUES(:username,:password,:name,:email,:phone,:isAdmin)";
        $query = $conn->prepare($sql);
        $query->execute([
            ':username' => $username,
            ':password' => $password,
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':isAdmin' => 'no'
        ]);
    }

    ?>
    <div class="modal fade" id="addUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-grey">
            <div class="modal-header">
                <h5 class="modal-title">New User Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" class="row justify-content-center">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control mb-3" name="username" value="<?php echo $username_a ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control mb-3" name="password" value="<?php echo $password_a ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control mb-3" name="name" value="<?php echo $name_a ?>">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control mb-3" name="phone" value="<?php echo $phone_a ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="mail" class="form-control mb-3" name="email" value="<?php echo $email_a ?>">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit-admin" class="btn btn-primary me-4">Create new</button>
            </div>
            </div>
        </div>
    </div>

<?php include 'includes/footer.php' ?>