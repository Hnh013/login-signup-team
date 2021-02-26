<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
      
    if(empty(trim($_POST["username"]))){
          $username_err = "Username can't be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST['username']);

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                  $username_err = "This username is already taken";
                }
                else {
                    $username = trim($_POST["username"]);
                }
            }
            else {
                echo "Something went wrong";
            }
        }
    }
    mysqli_stmt_close($stmt);



if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
} 
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}


if(trim($_POST['password']) != trim($_POST['confirm_password'])){
    $password_err = "Passwords should match!";
}


if(empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        if (mysqli_stmt_execute($stmt)) 
        {
            header("location: login.php");
        }
        else {
            echo "Something went wrong... cannot redirect";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);

}

?>








<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>PHP</title>
  </head>
  <body>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="register.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="login.php">Log In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="logout.php">Log Out</a>
        </li>

      
      </ul>

      <!-- <div class="navbar-collapse collapse">
      <ul class="navbar-nav ml-auto">
      
        <li class="nav-item active">
          <a class="nav-link" href="#"><?php echo "Welcome ". $_SESSION['username'] ?></a>
        </li>
      </ul>
      </div> -->
    </div>
  </div>
</nav>

<div class="container my-8">

<h3>Please Register Here!</h3>
<hr>


<form class="row g-3" action="" method="POST">
<div class="col-md-6">
    <label for="username" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" id="username">
  </div>

  <!-- <div class="col-md-6">
    <label for="Surname" class="form-label">Surname</label>
    <input type="text" name="Surname" class="form-control" id="Surname">
  </div>

  <div class="col-md-6">
    <label for="Email" class="form-label">Email</label>
    <input type="email" name="Email"class="form-control" id="Email">
  </div>
  -->
  <div class="col-md-6">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" name="password" id="password">
  </div>

  <div class="col-md-6">
    <label for="confirm_password" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" name="confirm_password" id="confirm_password">
  </div>
  
<!--  
  <div class="col-md-6">
    <label for="Country" class="form-label">Country</label>
    <select id="Country" class="form-select" name="Country">
      <option selected value="India">India</option>
      <option value="USA">USA</option>
    </select>
  </div> -->
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Register</button>
  </div>
</form>

</div>





  </body>
</html>