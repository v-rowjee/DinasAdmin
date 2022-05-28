<?php 
ob_start();
$active = 'login';
include 'includes/header.php';

if(isset($_SESSION['id'])){
  header('location: dashboard.php');
  die();
}

// include 'includes/g_auth.php';

$username = $password = "";
$usernameErr = $passwordErr = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  require "includes/db_connect.php";

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
<body>
    hello
</body>

<!-- include Footer -->
<?php 
include 'includes/footer.php';
?>