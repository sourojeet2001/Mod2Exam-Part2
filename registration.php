<?php
  // Starting session.
  session_start();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("NameDetails.php");
    // Creating object of the above class
    $person = new NameDetails();
    $userDetails = [
      "firstName" => $_POST["firstname"],
      "lastName" => $_POST["lastname"],
      "phone" => $_POST["phone"],
      "regEmail" => $_POST["regemail"],
      "userPassword" => $_POST["userpassword"],
      "userRole" => $_POST['userRole']
    ];
    $person->register($userDetails);
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
  <!-- BootStrap Form -->
  <form name="registration_form"  class="details" method="post" enctype="multipart/form-data">
    <div class="container register">
      <div class="reg-formcontrol">
        <div class="reg-formfields">
          <div class="name">
            <div class="mb-3 namecomponent">
              <label for="firstname" class="form-label">FirstName</label>
              <!-- This field takes firstname from user. -->
              <input type="text" name="firstname" class="form-control firstname">
              <!-- Shows error on not satisfying condition of all characters being alphabet. -->
              <span class="error-message nameError"></span>
            </div>
            <div class="mb-3 namecomponent">
              <label for="lastname" class="form-label">LastName</label>
              <!-- This field takes lastname from user. -->
              <input type="text" name="lastname" class="form-control lastname">
              <!-- Shows error on not satisfying condition of all characters being alphabet. -->
              <span class="error-message nameError"></span>
            </div>
          </div>
          <div class="mb-3">
            <label for="fullname" class="form-label">FullName</label>
            <!-- This field is disabled by default.
                Shows live concatination of firname and lastname. -->
            <input type="text" disabled name="fullname" class="form-control fullname">
          </div>
          <div class="name">
            <div class="mb-3 namecomponent">
              <label for="phone" class="form-label">Phone No</label>
              <!-- This field accepts phone no from user. -->
              <input type="phone" class="form-control" name="phone" id="phone" placeholder="+91">
              <span class="error-message contactError"></span>
            </div>
            <div class="mb-3 namecomponent">
              <label for="email" class="form-label">Email Id</label>
              <!-- This field accepts email from user. -->
              <input type="text" class="form-control" name="regemail" id="email" placeholder="Enter your email id">
              <span class="error-message emailError"></span>
            </div>
          </div>
          <div class="name">
            <div class="mb-3 namecomponent">
              <label for="userpassword" class="form-label">Password</label>
              <!-- This field takes password from user. -->
              <input type="password" name="userpassword" class="form-control userpassword" id="userpassword">
              <input type="checkbox" id="showPass">Show Password
              <span class="error-message passwordError"></span>
            </div>
            <div class="mb-3 namecomponent">
              <label for="cnfpassword" class="form-label">Confirm Password</label>
              <!-- This field confirms password from user. -->
              <input type="password" name="cnfpassword" class="form-control cnfpassword" id="cnfpassword">
              <input type="checkbox" id="showcnfPass">Show Password
              <span class="error-message passwordError"></span>
            </div>
          </div>
          <div class="name">
            <div class="interests prefInterests">
                <input type="checkbox" id="Admin" name="userRole" value="Admin">
                <label for="Admin">Admin</label>
                <input type="checkbox" id="Indie" name="userRole" value="User">
                <label for="User">User</label>
            </div>
          </div>
          <span class="error-message interestsError"></span>
          <div class="name">
            <button type="submit" name="submit" id="submit" class="btn btn-primary custom-btn" onclick="validate()">Submit</button>
            <a class="login_link" href="login.php">Already a User? Log In!</a>
          </div>
        </div>
      </div>
    </div>
  </form>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
</body>
</html>
