<?php $active= 'users'; include 'includes/header.php'; include 'includes/db_connect.php' ?>
    <!--Container Main start-->
    <div class="container py-3">
        <!-- Search bar -->
        <div class="d-flex align-items-center">
            <h2 class="me-auto">Users</h2>
            <?php
                $search = '';

                if(isset($_POST['search'])){
                    $search = $_POST['search-input'];

                    $temp = $search;
                    if($temp == '')
                        $temp = '%';

                    $sql = "SELECT * FROM users id LIKE :id OR username LIKE :username OR name LIKE :name OR email LIKE :email OR phone LIKE :phone AND is_admin = :isAdmin";
                    $query = $conn->prepare($sql);
                    $query->execute([
                        ':id' => $temp,
                        ':username' => $temp,
                        ':name' => $temp,
                        ':email' => $temp,
                        ':phone' => $temp,
                        ':isAdmin' => 'no',
                    ]);
                    $user = $query->fetch(PDO::FETCH_ASSOC);
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
    </div>
    <!--Container Main end-->
<?php include 'includes/footer.php' ?>