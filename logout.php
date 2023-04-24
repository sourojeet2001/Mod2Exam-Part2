<?php
  // Unset login credentials and logout also redirect back to login page.
  session_start();
  session_unset();
  header("Location: login.php");
?>
