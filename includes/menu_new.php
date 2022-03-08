<?php 
include 'db_connect.php';

$name=''; $price='';$cat=''; $desc=''; $img='default.png'; $msg='';

if(isset($_POST['create'])){

    // if user press save with no name as input
    if(empty($_POST['name'])){
        $msg = 'Enter item name!';
    }
    if(empty($_POST['category'])){ 
        $msg = 'Choose a category!';
    }
    if(empty($_POST['img'])){ 
        $msg = 'Upload an image!';
    }

    // validate input here
    $name = $_POST['name'];
    $price = $_POST['price'];
    $cat = $_POST['category'];
    $desc = $_POST['desc'];
    $img = $_POST['img'];

    if($msg==''){
        $sql = "INSERT INTO menu (name,price,caption,category,img) VALUES (:name,:price,:desc,:cat,:img) ";
        $query = $conn->prepare($sql);
        $query->execute([
            ':name' => $name,
            ':price' => $price,
            ':desc' => $desc,
            ':cat' => $cat,
            ':img' => $img
        ]);

        $newID = $conn->lastInsertId();

        header('location: menu.php?id='.$newID);
    }
}
else if(isset($_POST['discard']) || isset($_POST['delete'])){
    header('location: menu.php');
}

?>
<div class="container py-3">
      <div class="row align-items-center" style="height: calc(100vh-2rem);">
        <div class="col-12 col-xl-5 ">
          <img src="images/menu/<?php echo $img ?>" class="img-edit" style="transform: scale(0.8);" alt="...">
        </div>
        <div class="col-12 col-xl-7 z-top">

          <form action="" method="post" class="row gy-3 mx-5">
            <div class="col-12 col-sm-6">
              <h1 class="d-inline sm-h1 p-0">New Item</h2>
            </div>
            <div class="col-12 col-sm-6 text-end align-self-center">
              <p class="msg m-0"><?php echo $msg ?></p>
            </div>
            <div class="col-12 col-lg-6">
              <label class="form-label" for="">Name</label>
              <input type="text" name="name" class="form-control" value="<?php echo $name ?>">
            </div>
            <div class="col-12 col-lg-6">
              <label class="form-label" for="">Price</label>
              <input type="number" name="price" class="form-control" value="<?php echo $price ?>">
            </div>
            <div class="col-12">
              <label class="form-label" for="">Description</label>
              <textarea class="form-control" name="desc" style="height: 4rem;"><?php echo $desc ?></textarea>
            </div>
            <div class="col-12 col-lg-6">
              <label class="form-label" for="">Category</label>
              <select class="form-select pt-1 bg-dark select" name="category">
                <option value="Starter">Starter</option>
                <option value="Pasta" >Pasta</option>
                <option value="Pizza" >Pizza</option>
                <option value="Drinks" >Drinks</option>
                <option value="Dessert">Dessert</option>
              </select>
            </div>
            <div class="col-12 col-lg-6 mb-5">
              <label class="form-label" for="">Image URL</label>
              <input type="text" name="img" class="form-control" placeholder="default.png" value="<?php echo $img ?>">
            </div>
            <div class="col-3"><button type="submit" name="delete" class="btn btn-danger w-100"><i class='bx bx-trash'></i></button></div>
            <div class="col-3"><button type="submit" name="discard" class="btn btn-primary w-100">Discard</button></div>
            <div class="col-6"><button type="submit" name="create" class="btn btn-primary w-100">Save</button></div>
      
          </form>
          
        </div>
      </div>
  </div>
<?php

