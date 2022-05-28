<?php
session_start();
?>
<?php
if(isset($_SESSION['id'])){
    header('location: index.php');
    die();
  }
  $username = $password = "";
  $usernameErr = $passwordErr = "";
  if ($_SERVER['REQUEST_METHOD'] == "POST") {

    require "includes/db_connect.php";
     if(empty($_POST['username']))
     $usernameErr = "* Required field";
 else{
     $usernameErr = "";
     $username = filter($_POST['username']);
 }
}
// validating password
if(empty($_POST['password']))
$passwordErr = "* Required field";
else{
$passwordErr = "";
$password = filter($_POST['password']);
}

if (isset($user['username'])) {    

	$hashed_password = $user['password'];

if (password_verify($password,$hashed_password)) { 
		$_SESSION['id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['name'] = $user['name'];
		$_SESSION['email'] = $user['email'];
		$_SESSION['phone'] = $user['phone'];
		$_SESSION['is_admin'] = $user['is_admin'];
		header('location: index.php');
	} else
		$passwordErr = "* Invalid password";
} else{
  $usernameErr = "* Username does not exists";
  $passwordErr = "* Required field";
}
	
// validating password strength
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$specialChars = preg_match('@[^\w]@', $password);

if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
    echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
}else{
    echo 'Strong password.';
}

function filter($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<!doctype html>
<html lang="en">
  <head>
  	<title>Dina's loginn</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	
	<link rel="stylesheet" href="css/default.css">

	</head>
	<body class="img js-fullheight" style="background-image:linear-gradient(to left,transparent, black),url(../bg-spaghetti.png); background-size: cover;background-position: center;;">
	
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-12 col-md-4 align-self-center">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center"><img src="./images/logoo.png" class="avatar" style="filter: invert(68%) sepia(28%) saturate(559%) hue-rotate(7deg) brightness(90%) contrast(84%);"></h3>
		      	<form>
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Email</label>
						<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
						<div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
					  </div>
					  <div class="mb-3">
						<label for="exampleInputPassword1" class="form-label ">Password</label>
						<input type="password" class="form-control" id="myInput">
					  </div>
					  <div class="mb-3 form-check">
						<input type="checkbox" onclick="myFunction()" class="form-check-input" id="exampleCheck1">
						<label class="form-check-label" for="exampleCheck1">Show Password </label>
						<script>
							function myFunction() {
							  var x = document.getElementById("myInput");
							  if (x.type === "password") {
								x.type = "text";
							  } else {
								x.type = "password";
							  }
							}
							</script>
                            
					  </div>
					  <button type="login" class="btn btn-primary text-dark w-100">Log In</button>
	          
					</form>
	          
		      </div>
				</div>
			</div>
		</div>
	</section>




  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  
	</body>
</html>

