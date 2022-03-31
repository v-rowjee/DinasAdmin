<!doctype html>
<html lang="en">
  <head>
  	<title>Dina's</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	
	<link rel="stylesheet" href="css/default.css">

	</head>
	<body class="js-fullheight" style="background-image:linear-gradient(to left,transparent, black),url(images/bg-spaghetti.jpeg); background-size: cover;background-position: center;height:100vh;">
	
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-12 col-md-4 align-self-center">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center"><img src="images/logo.png" class="avatar" style="filter: invert(68%) sepia(28%) saturate(559%) hue-rotate(7deg) brightness(90%) contrast(84%);"></h3>
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
					  <button type="login" class="btn btn-primary">Log In</button>
	          
					</form>
	          
		      </div>
				</div>
			</div>
		</div>
	</section>




  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="bootstrap/bootstrap.bundle.min.js"></script>
  <script src="js/main.js"></script>
  
	</body>
</html>

