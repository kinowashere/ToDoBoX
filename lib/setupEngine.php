<?php
if(isset($_POST["submit"])) {
  $conn = new mysqli();
  close_connection($conn);
  header("Location: setup_wizard.php?done");
}
?>