<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | Login</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/default.css">
  </head>
  <body style="height: 100vh;">
    <div id="particles-js">
      <canvas class="particles-js-canvas-el" style="width: 100%; height: 100%">
      </canvas>
    </div>
    
    <div class="center-card">
      <div class="card shadow bg-grey">
        <div class="card-title text-center border-b">
          <img src="images/logo.png" class="w-50 my-4" style="filter: invert(1);">
        </div>
        <div class="card-body" style="padding: 1rem 2.5rem;">
          <form>
            <div class="mb-4">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username"/>
            </div>
            <div class="mb-2">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password"/>
            </div>
            <div class="mb-4">
              <input type="checkbox" class="form-check-input"/>
              <label for="remember" class="form-label">Show password</label>
            </div>
            <div class="mb-4">
              <button type="submit" class="btn btn-secondary w-100" id="login">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/login.js"></script>

    <script>
      $('#login').click((e)=>{
        e.preventDefault()
        var username = $('#username').val()
        var password = $('#password').val()
        $.ajax({
          url: "ajax/login.php",
          type: "POST",
          data: ({
            username: username,
            password: password
          }),
          dataType: 'text',
          success: (data)=>{
            if(data == "OK"){
              window.location.href = "dashboard.php";
            }
            else if(data == "NOT-ADMIN"){
              alert('User is not an admin')
            }
            else if(data == "WRONG-CREDENTIAL"){
              alert('Username or password incorrect')
            }
            else{
              alert('An error occurred')
            }
          }
        })
      })
    </script>
  </body>
</html>