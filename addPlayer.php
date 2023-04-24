<?php
  session_start();
  include("NameDetails.php");
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Object of NameDetails is beuing initialized.
    $obj = new NameDetails();
    // Passing values from user input to add new player.
    $uploadDetails = [
      "empId" => $_POST['title'],
      "empName" => $_POST['title'],
      "type" => $_POST['type'],
      "point" => $_POST['point'],
    ];
    $obj->upload($uploadDetails, "Upload");
  }
?>
<link rel="stylesheet" href="./css/formstyle.css">
<div class="center">
  <div>
    <h1 class="title">Add Employee Details</h1>
    <form method="POST" enctype="multipart/form-data">
      <div class="flex center">
        <input type="text" id="empId" name="empId" class="input-fields" placeholder="Employee Id" required autofocus>
        <input type="text" id="empName" name="empName" class="input-fields" placeholder="Employee Name" required autofocus>
        <input type="text" id="type" name="type" class="input-fields" placeholder="Type" required autofocus>
        <input type="text" id="point" name="point" class="input-fields" placeholder="Point" required autofocus>
        <input type="submit" class="rounded-btn upload-btn">
      </div>
    </form>
  </div>
</div>
