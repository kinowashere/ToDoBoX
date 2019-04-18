<?php
session_start();
$conn = open_connection();

function randomString($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

if (isset($_POST["email"]) and isset($_POST["password"])) {
  $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
  $password = $_POST["password"];

  //checks whether the email already exists
  $sql = "select user_id, name, email, password_hash from users where email = '{$email}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  // returns true if typed password and stored password are the same
  $auth = password_verify($password, $userInfo["password_hash"]);
  try {
    if (!$auth) {
      throw new Exception("login_incorrect");
    }
    $_SESSION['user_id'] = $userInfo["user_id"];
    $_SESSION['name'] = $userInfo['name'];
    $_SESSION['email'] = $userInfo['email'];
  } catch (Exception $e) {
    if(strcmp($e->getMessage(),"login_incorrect") == 0 ) {
      header("Location: login.php?login_incorrect");
    }
  }
}

if (isset($_SESSION['name'])) {
  header("Location: index.php");
}

close_connection($conn);
