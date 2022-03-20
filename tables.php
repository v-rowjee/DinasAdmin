<?php
ob_start();
$active= 'tables'; 
include_once 'includes/header.php';
include 'includes/db_connect.php';
?>
    <!--Container Main start-->
    <div class="container py-3">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col">
            <h2>Tables</h2>
            </div>
            <div class="col">
                <!-- SEARCH BAR -->
                <?php
                include_once 'includes/db_connect.php';
                $search = ''; $search2 = "";
                $msg = "";

                if(isset($_POST['search-rid']) && isset($_POST['search-input-rid'])){
                    $msg = "";

                    $search = $_POST['search-input-rid'];

                    $sql = "SELECT * FROM res_tab WHERE rid LIKE ? ";
                    $query = $conn->prepare($sql);
                    $query->execute([$search]);

                    if($query->rowCount() == 0){
                     $msg = '<div class="col align-self-center text-center"><p class="msg">No Search Result for: "'.$search2.'"</p></div>';
                    }

                }else{
                    $sql = "SELECT * FROM res_tab"; 
                    $query = $conn->prepare($sql);
                    $query->execute();
                }

                if(isset($_POST['search-tables']) && isset($_POST['search-input'])){
                    $msg = "";

                    $search2 = $_POST['search-input'];

                    $sql2 = "SELECT * FROM tables WHERE tab_num LIKE :search_num OR placement = :search_pla ORDER BY tab_num, placement";
                    $query2 = $conn->prepare($sql2);
                    $query2->bindValue(':search_num', '%' . $search2 . '%');
                    $query2->bindParam(':search_pla',$search2);
                    $query2->execute();

                    if($query2->rowCount() == 0){
                     $msg = '<div class="col align-self-center text-center"><p class="msg">No Search Result for: "'.$search2.'"</p></div>';
                    }
                    
                }else{
                    $sql2 = "SELECT * FROM tables ORDER BY tab_num, placement"; 
                    $query2 = $conn->prepare($sql2);
                    $query2->execute();
                }
                ?>
                <!-- SEARCH BAR -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                    
                    <div class="input-group me-3 w-50">
                        <input type="text" name="search-input-rid" class="form-control" placeholder="Search res. id" value="<?php echo $search ?>">
                        <button type="submit" name="search-rid" class="input-group-text" title="Search">
                            <i class='bx bx-search'></i>
                        </button>
                    </div>

                    <div class="input-group me-3 w-50">
                        <input type="text" name="search-input" class="form-control" placeholder="Search table" value="<?php echo $search2 ?>">
                        <button type="submit" name="search-tables" class="input-group-text" title="Search">
                            <i class='bx bx-search'></i>
                        </button>
                    </div>

                    <!-- <a href="tables.php?id=new" class="input-group-text">
                    <i class="bx bx-plus"></i>
                    </a> -->
                </form>
            </div>
        </div>
        
        <!-- RES_TAB -->
        <div class="row text-center">
            <div class="col-12 col-md-6">
                <div class="card bg-dark shadow">
                    <div class="card-body" style="overflow-x: hidden;">
                        <table class="table table-dark table-borderless table-hover">
                            <thead>
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Res. ID</th>
                                <th scope="col">Tab. ID(s)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($res_tab = $query->fetch(PDO::FETCH_ASSOC)){ ?>
                                <tr>
                                <th><?php echo $res_tab['id'] ?></th>
                                <td><?php echo $res_tab['rid'] ?></td>
                                <td><?php echo $res_tab['tid'] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <!-- TABLES -->
            <div class="col-12 col-md-6">
                <div class="card bg-dark shadow">
                    <div class="card-body" style="overflow-x: hidden;">
                        <table class="table table-dark table-borderless table-hover">
                            <thead>
                                <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Table No.</th>
                                <th scope="col">Placement</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($table = $query2->fetch(PDO::FETCH_ASSOC)){ ?>
                                <tr>
                                <th><?php echo $table['id'] ?></th>
                                <td><?php echo $table['tab_num'] ?></td>
                                <td class="text-capitalize"><?php echo $table['placement'] ?></td>
                                <td><a href="includes/tables_delete.php?dlt=<?php echo $table['id'] ?>"><i class='bx bxs-trash-alt text-danger'></i></a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Add new table -->
                <?php
                    $tnum = ''; $place='inside'; $msg ='';
                    
                    if(isset($_POST['add-table'])){

                        $sql3 = "SELECT * FROM tables WHERE tab_num = ?";
                        $query3 = $conn->prepare($sql3);
                        $query3->execute([$_POST['tnum']]);

                        if($query3->rowCount() > 0)
                            $msg = "Table number already exist";
                        else{
                            $msg = '';
                            $tnum = $_POST['tnum'];
                            $place = $_POST['placement'];

                            $sql = "INSERT INTO tables (tab_num,placement) VALUES (:num,:place)";
                            $query = $conn->prepare($sql);
                            $query->execute([
                                ':num' => $tnum,
                                ':place' => $place
                            ]);

                            header('location: tables.php');
                        }
                    }
                ?>
                <div class="card bg-dark shadow mt-4">
                    <div class="card-body vertical-align" style="overflow-x: hidden;">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                            <div class="row text-start justify-content-center">
                                <div class="col-4">
                                    <label class="form-label">Table Number</label>
                                    <input type="number" class="form-control" name="tnum" placeholder="Tab No.">
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Placement</label>
                                    <select name="placement" class="form-select">
                                        <option value="inside" selected>inside</option>
                                        <option value="outside">outside</option>
                                        <option value="vip">vip</option>
                                        <option value="bar">bar</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Add Table</label>
                                    <button type="submit" name="add-table" class="btn btn-secondary h-2rem w-100"><i class="bx bx-plus"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="msg"><?php echo $msg ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Container Main end-->
<?php include 'includes/footer.php'; ob_end_flush(); ?>