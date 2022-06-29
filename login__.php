<?php
ob_start();
$active = "login";
include 'includes/header.php';

// include 'config/g_auth.php';

$username = $password = "";
$usernameErr = $passwordErr = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  require 'config/db_connect.php';

    // validating username
    if(empty($_POST['username']))
        $usernameErr = "* Required field";
    else{
        $usernameErr = "";
        $username = filter($_POST['username']);

        if(!preg_match("/^[a-zA-Z0-9]+$/",$username)){
            $usernameErr = "* Only letters and numbers allowed";
            $passwordErr = "* Required field";
        }
    }
        

    // validating password
    if(empty($_POST['password']))
        $passwordErr = "* Required field";
    else{
      $passwordErr = "";
      $password = filter($_POST['password']);
    }
    // MORE PASSWORD VALIDATION


    if($usernameErr=="" && $passwordErr==""){ // if no error...

        // USER MUST BE ADMIN
        $sql = "SELECT * FROM users WHERE username = ? and is_admin = 'yes'";
        $statement = $conn->prepare($sql);
        $statement->execute([$username]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (isset($user['username'])) {    // if username exist

            $hashed_password = $user['password'];

            if (password_verify($password,$hashed_password)) { // if password correct
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['phone'] = $user['phone'];
                $_SESSION['is_admin'] = $user['is_admin'];
                header('location: dashboard.php');
            } else
                $passwordErr = "* Invalid password";
        } else{
          $usernameErr = "* Username does not exists";
          $passwordErr = "* Required field";
        }
            
    }

    $conn == null;
}

function filter($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!-- HTML -->
<body style="height:100vh" class="p-0 m-0">
		<div class="container h-100">
			<div class="row h-100 justify-content-center">
				<div class="col-12 col-md-4 align-self-center">
					<div class="p-0">
		      	<h3 class="mb-4 text-center"><img src="./images/logoo.png" class="avatar" style="filter: invert(68%) sepia(28%) saturate(559%) hue-rotate(7deg) brightness(90%) contrast(84%);"></h3>
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
	          	          
		      </div>
				</div>
			</div>
		</div>
</body>

<!-- include Footer -->
<?php 
include 'includes/footer.php';
?>