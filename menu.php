<?php 
$active= 'menu';
include 'includes/header.php';

if(isset($_GET['id'])){
  if($_GET['id'] == 'new')
    include 'includes/menu_new.php';
  else
    include 'includes/menu_edit.php';
}else{
?>
  <!--Container Main start-->
  <div class="container py-3">
    <div class="d-flex align-items-center align-middle">
      <h2 class="me-auto">Menu</h2>

      <!-- SEARCH BAR -->
      <?php
      include_once 'includes/db_connect.php';
      $search = "";
      $msg = "";
      if(isset($_POST['search-menu']) && isset($_POST['search-input'])){
        $msg = "";

        $search = $_POST['search-input'];

        $sql = "SELECT * FROM menu WHERE name LIKE :search_name OR category = :search_cat ORDER BY category DESC, name ASC";
        $query = $conn->prepare($sql);
        $query->bindValue(':search_name', '%' . $search . '%');
        $query->bindParam(':search_cat',$search);
        $query->execute();

        if($query->rowCount() == 0){
          $msg = '<div class="col align-self-center text-center"><p class="msg">No Search Result for: "'.$search.'"</p></div>';
        }
        
      }else{
        // order by descending category (z-a) and descending id (most recent to oldest)
        $sql = "SELECT * FROM menu ORDER BY category DESC, name ASC"; 
        $query = $conn->prepare($sql);
        $query->execute();
      }
      ?>
      <!-- SEARCH BAR -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="flex-row-reverse">
        <div class="input-group">
          <input type="text" name="search-input" class="form-control" placeholder="Search item" value="<?php echo $search ?>">
          <button type="submit" name="search-menu" class="input-group-text" title="Search">
            <i class='bx bx-search'></i>
          </button>
        </div>

        <a href="menu.php?id=new" class="input-group-text me-3">
          <i class="bx bx-plus"></i>
        </a>
      </form>
              
    </div>

    <!-- ITEMS -->
    <div class="row g-4 mt-3">
      <!-- Create new item -->
      <div class="col-sm-6 col-md-4 col-lg-3">
        <a href="menu.php?id=new" class="card-link">
          <div class="card card-shadow">
            <img
                src="images/menu/default.jpg"
                style="filter: invert(1);"
                class="card-img-top"
                alt=""
            />
            <div class="card-img-overlay">
              <p class="item-cat">New</p>
            </div>
            <div class="card-body">
                <h5 class="card-title">New Item</h5>
                <p class="card-text mb-2">Add a new item to the menu now!</p>
                <h6 class="price"></h6>

                <a href="menu.php?id=new" class="btn btn-primary float-none">
                  Add <i class="bx bx-plus"></i>
                </a>

            </div>
          </div>
        </a>
      </div>
      <!-- Edit selected item -->
    <?php  
      if($msg!='') echo $msg;

      $filter = '';

      while($item = $query->fetch(PDO::FETCH_ASSOC)){

        echo '
            <div class="col-sm-6 col-md-4 col-lg-3">
              <a href="menu.php?id='.$item['id'].'" class="card-link">
                <div class="card card-shadow">
                  <img
                      src="images/menu/'.$item['img'].'"
                      class="card-img-top"
                      alt="'.$item['name'].'"
                  />
                  <div class="card-img-overlay">
                    <p class="item-cat">'.$item['category'].'</p>
                  </div>
                  <div class="card-body">
                      <h5 class="card-title">'.$item['name'].'</h5>
                      <p class="card-text mb-2">'.$item['caption'].'</p>
                      <h6 class="price">Rs '.$item['price'].'</h6>

                      <a href="menu.php?id='.$item['id'].'" class="btn btn-primary">
                        Edit <i class="bx bxs-edit pt-2"></i>
                      </a>

                  </div>
                </div>
              </a>
            </div>
        ';
      }
    ?>
    </div>
    
  </div>
  <!--Container Main end-->
<?php 
}include 'includes/footer.php'; $conn == null;
?>