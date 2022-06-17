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
    <div class="text">
      <div class="container h-100">
        <div class="row h-100 justify-content-center">
          <div class="col-12 col-lg-4">
            <div class="card shadow bg-grey">
              <div class="card-title text-center border-b">
                <img src="images/logo.png" class="w-50 my-4" style="filter: invert(1);">
              </div>
              <div class="card-body" style="padding: 1rem 2.5rem;">
                <form>
                  <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control"/>
                  </div>
                  <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control"/>
                  </div>
                  <div class="mb-4">
                    <input type="checkbox" class="form-check-input"/>
                    <label for="remember" class="form-label">Show password</label>
                  </div>
                  <div class="mb-4">
                    <button class="btn btn-outline-secondary w-100">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script src="js/login.js"></script>
  </body>
</html>