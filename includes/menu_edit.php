<?php 
include 'config/db_connect.php';

$sql = "SELECT * FROM menu WHERE id = ?";
$query = $conn->prepare($sql);
$query -> execute([$_GET['id']]);
$item = $query->fetch(PDO::FETCH_ASSOC);

if($query->rowCount() == 0)
  header('location: menu.php');

$msg = '';  // error message

$conn->beginTransaction();  // begin transaction

// UPDATE ITEM
if(isset($_POST['save'])){

  if(empty($_POST['price']))
    $msg = 'Price required';

  if(empty($_POST['name']))
    $msg = 'Name required';

  if(empty($_POST['desc']))
    $msg = 'Description required';

  // validation for all input
  if(!file_exists('images/menu/'.$_POST['img']))
    $item['img'] = "default.jpg";

  if($msg == ''){
    $sql2 = "UPDATE menu SET name = :name , price = :price , caption = :desc , category = :category , img = :img WHERE id = :id";
    $query2 = $conn->prepare($sql2);
    $query2->execute([
      ':id' => $item['id'],
      ':name' => $_POST['name'],
      ':price' => $_POST['price'],
      ':desc' => $_POST['desc'],
      ':category' => $_POST['category'],
      ':img' => $_POST['img']
    ]);

    $conn->commit();

    $msg = "Record saved";

    include 'config/functions.php';
    setMenuJson();
  }

  // to get saved values
  if($msg != ''){
    $sql = "SELECT * FROM menu WHERE id = ?";
    $query = $conn->prepare($sql);
    $query -> execute([$_GET['id']]);
    $item = $query->fetch(PDO::FETCH_ASSOC);
  }
}
// DELETE ITEM
else if(isset($_POST['delete'])){

  $sql3 = "DELETE FROM menu WHERE id = ?";
  $query3 = $conn->prepare($sql3);
  $query3->execute([$_GET['id']]);

  if($item['img'] != 'default.jpg'){

    $filePath = 'images/menu/'.$item['img'];

    if (file_exists($filePath)) 
    {
        unlink($filePath);
        $conn->commit();
        header('location: menu.php');
        die();
    }
    else
    {
      $conn->commit();
      header('location: menu.php');
      die();
    }
  }

  
}
// CANCEL CHANGES
else if(isset($_POST['cancel'])){
  if($item['name'] == ''){
    $sql3 = "DELETE FROM menu WHERE id = ?";
    $query3 = $conn->prepare($sql3);
    $query3->execute([$_GET['id']]);
  }

  $conn->commit();

  header('location: menu.php');
  die();
}

$conn==null;

?>
  <!--Container Main start-->
  <div class="container py-3">
      <div class="row align-items-center" style="height: calc(100vh-2rem);">
        <div class="col-12 col-xl-5 ">
          <img src="images/menu/<?php echo $item['img'] ?>" class="img-edit" style="transform: scale(0.8);" alt="...">
        </div>
        <div class="col-12 col-xl-7 z-top">
          <form action="" method="post" class="row gy-3 mx-5">
            <div class="col-12 col-sm-6">
              <h1 class="d-inline sm-h1 p-0">Item <?php echo $item['id'] ?></h2>
            </div>
            <div class="col-12 col-sm-6 text-end align-self-center">
              <p class="msg m-0"><?php echo $msg ?></p>
            </div>
            <div class="col-12 col-lg-6">
              <label class="form-label" for="">Name</label>
              <input type="text" name="name" class="form-control" value="<?php echo $item['name'] ?>">
            </div>
            <div class="col-12 col-lg-6">
              <label class="form-label" for="">Price</label>
              <input type="number" name="price" min=0 class="form-control" value="<?php echo $item['price'] ?>">
            </div>
            <div class="col-12">
              <label class="form-label" for="">Description</label>
              <textarea class="form-control" name="desc" style="height: 4rem;"><?php echo $item['caption'] ?></textarea>
            </div>
            <div class="col-12 col-lg-6">
              <label class="form-label" for="">Category</label>
              <select class="form-select pt-1 bg-transparent select" name="category">
                <option value="" disabled <?php if($item['category'] == '') echo 'selected' ?>> Choose a Category</option>
                <option value="Starter" <?php if(strcasecmp($item['category'],'starter')==0) echo 'selected' ?> >Starter</option>
                <option value="Pasta" <?php if(strcasecmp($item['category'],'pasta')==0) echo 'selected' ?> >Pasta</option>
                <option value="Pizza" <?php if(strcasecmp($item['category'],'pizza')==0) echo 'selected' ?> >Pizza</option>
                <option value="Drinks" <?php if(strcasecmp($item['category'],'drinks')==0) echo 'selected' ?> >Drinks</option>
                <option value="Dessert" <?php if(strcasecmp($item['category'],'dessert')==0) echo 'selected' ?> >Dessert</option>
              </select>
            </div>
            <div class="col-12 col-lg-6 mb-5">
              <label class="form-label" for="">Image URL</label>
              <input type="text" name="img" class="form-control" value="<?php echo $item['img'] ?>">
            </div>
            <div class="col-3"><button type="submit" name="delete" class="btn btn-danger w-100"><i class='bx bx-trash'></i></button></div>
            <div class="col-3"><button type="submit" name="cancel" class="btn btn-primary w-100">Back</button></div>
            <div class="col-6"><button type="submit" name="save" class="btn btn-primary w-100">Save</button></div>
      
          </form>
          
        </div>
      </div>
  </div>
  <!--Container Main end-->

