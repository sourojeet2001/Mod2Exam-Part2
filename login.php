<?php
  // Session start.
  session_start();
  include("NameDetails.php");
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $obj = new NameDetails();
    // Checking for empty fields and email validation.
    $empty = $obj->isEmpty($_POST['loginemail']);
    $empty = $obj->isEmpty($_POST['loginpassword']);
    $validate = $obj->emailValidate($_POST['loginemail']);
    if($validate && !$empty) {
      $loginDetails = [
        "loginEmail" => $_POST['loginemail'],
        "loginPassword" => $_POST['loginpassword'],
      ];
      $obj->login($loginDetails);
    }
    else {
      $obj->redirect("login.php");
    }
    $errorMsg = $_SESSION['msg']; 
    $_SESSION['msg'] = "";
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/raw.css">
    <script src="./js/validation.js"></script>
  </head>

  <body>
    <!-- Form Start -->
    <form class="login" class=" container mt-5" method="post">
      <div class="formcontrol">
        <div class="formfields">
          <div class="mb-3">
            <?php echo $errorMsg ?>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="loginemail"  class="form-control" id="email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            <span class="error-message emailError"></span>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="loginpassword"  class="form-control userpassword" id="password">
            <input type="checkbox" id="showPass">Show Password
            <span class="error-message passwordError"></span>
          </div>
          <div class="name">
            <button type="submit" name="submit" class="btn btn-primary" onclick="validate()">Submit</button>
            <a class="forgot_pw" href="forgot.php">Forgot Password?</a>
          </div>
          <div class="signup_link">
            <a href="registration.php">New User? Sign Up!</a>
          </div>
        </div>
      </div>
    </form>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> 
  <script src="./js/validation.js"></script>
</html>
