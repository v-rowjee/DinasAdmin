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

                <a href="" class="input-group-text me-3">
                    <i class="bx bx-plus"></i>
                </a>
            </form>
        </div>
        <div class="card bg-dark shadow rounded mb-4">
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

                <a href="" class="input-group-text me-3">
                    <i class="bx bx-plus"></i>
                </a>
            </form>
        </div>
        <div class="card bg-dark shadow rounded mb-4">
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
<?php include 'includes/footer.php' ?>