<?php
$target_dir = "../images/menu/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1; // true
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
// if(isset($_POST["submit-upload"])) {
  
  // TODO: check if file empty
  if (empty($_FILES['fileToUpload']['name'])) {
    $msg = 'No image selected';
    $uploadOk = 0;
  }else
    $uploadOk = 1;

  // Check if file already exists
  if (file_exists($target_file)) {
    $msg = "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    $msg = "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $msg = "Sorry, only JPG, JPEG & PNG files are allowed.";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $msg = "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    // upload image in backend
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $msg = "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded";
    } else {
      $msg = "Sorry, there was an error uploading your file.";
    }
  }
// }
echo $msg;
header('location: ../menu.php?id=new');
?>