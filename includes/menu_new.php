<?php 
include 'db_connect.php';

$name=''; $price='';$cat=''; $desc=''; $img='default.jpg'; $msg='';

if(isset($_GET['upload'])) $img = $_GET['upload'];

if(isset($_POST['create'])){
    // INPUT VALIDATION
    // if user press save with no name as input
    if(empty($_POST['name'])){
        $msg = 'Enter item name!';
    }else
      $name = $_POST['name'];

    if(empty($_POST['category'])){ 
        $msg = 'Choose a category!';
    }else 
      $cat = $_POST['category'];

    if(empty($_POST['desc'])){ 
        $desc = 'No description yet.';
    }else 
      $desc = $_POST['desc'];

    if(empty($_POST['price'])){ 
        $price = '0';
    }else 
      $price = $_POST['price'];

    if(file_exists('images/menu/'.$_POST['img']))
      $img = $_POST['img'];
    else
      $img = "default.jpg";
    
    // $img = isset($_POST['img']) ?  $_POST['img'] : 'default.jpg';


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

		include 'config/functions.php';
    	setMenuJson();

		header('location: menu.php');
		die();
        
    }
}
else if(isset($_POST['discard'])){
    header('location: menu.php');
}

?>
<div class="container py-3">
    	<div class="row align-items-center g-4" style="height: calc(100vh-2rem);">
		
			<div class="col-12 col-xl-5 text-center">   
				<img src="images/menu/<?php echo $img ?>" id="img_preview" class="img-edit" style="transform: scale(0.8);" alt="">
				<form action="config/upload.php" method="post" enctype="multipart/form-data" class="row g-4" <?php if(isset($_GET['upload'])) echo 'hidden' ?>>
					<div class="col-12 col-md-6">
					<input type="file" name="fileToUpload" id="fileToUpload" hidden>
					<label for="fileToUpload" class="btn btn-primary opacity-100">Choose File</label>
					</div>
					<div class="col-12 col-md-6">
					<input type="submit" value="Upload Image" class="btn btn-primary" name="submit-upload">
					</div>
				</form>
			</div>

			<div class="col-12 col-xl-7 z-top">
				<form action="" method="POST" class="row gy-3 mx-5">
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
						<input type="number" name="price" min=0 class="form-control" value="<?php echo $price ?>">
					</div>
					<div class="col-12">
						<label class="form-label" for="">Description</label>
						<textarea class="form-control" name="desc" maxlength="100" style="height: 4rem;"><?php echo $desc ?></textarea>
					</div>
					<div class="col-12 col-lg-6">
						<label class="form-label" for="">Category</label>
						<select class="form-select pt-1 select" name="category">
						<option value="Starter">Starter</option>
						<option value="Pasta" >Pasta</option>
						<option value="Pizza" >Pizza</option>
						<option value="Drinks" >Drinks</option>
						<option value="Dessert">Dessert</option>
						</select>
					</div>
					<div class="col-12 col-lg-6 mb-5">
						<div class="d-flex justify-content-between">
						<label class="form-label" for="">Image URL</label>
						<label class="form-label px-2"><i class="bx bx-plus" title="Upload Image" style="cursor:pointer"></i></label>
						</div>
						<input type="text" id="img_url" name="img" class="form-control" placeholder="default.jpg" value="<?php echo $img ?>">
					</div>
					<div class="col-6"><button type="submit" name="discard" class="btn btn-danger w-100">Discard</button></div>
					<div class="col-6"><button type="submit" name="create" class="btn btn-primary w-100">Create</button></div>
				</form>
			</div>
    	</div>
  </div>

<script>

  fileToUpload.onchange = event => {
    const [file] = fileToUpload.files;
    if(file){

      img_preview.src = URL.createObjectURL(file);

      $('#img_url').val(file.name);

    }
  }

</script>
