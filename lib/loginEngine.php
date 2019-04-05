<?php

require "lib/openConnection.php";

if ($_POST) {
  $email = $_POST["email"];
  $password = $_POST["password"];
  $sql = "select Email, Password from Users where Email='{$email}';";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);
  if($userInfo["Email"] == $email and $userInfo["Password"] == $password) {
    echo ("success!!!");
  }
}

$conn->close();
?>