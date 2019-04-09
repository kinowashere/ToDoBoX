<?php
session_start();

require "lib/openConnection.php";

function randomString($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

if (isset($_POST["email"]) and isset($_POST["recovery_code"])) {
  $email = $_POST["email"];
  $recovery_code = $_POST["recovery_code"];

  //checks whether the email already exists
  $sql = "select email, recovery_code, password_hash from users where email = '{$email}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);
  try {
    //Incorrect input
    if ($userInfo["email"] != $email or $userInfo["recovery_code"] != $recovery_code) {
      throw new Exception('<p style="color:red">Wrong email or recovery code</p>');
    }

    $generated_password = randomString(8);
    //todo send the password to the user via email
    //echo $generated_password . "<br>";
    $generated_password_hash = password_hash($generated_password, PASSWORD_DEFAULT);
    $sql = "update users set password_hash='{$generated_password_hash}' where email = '{$email}'";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    echo "Password sent to {$email}.";
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

$conn->close();
