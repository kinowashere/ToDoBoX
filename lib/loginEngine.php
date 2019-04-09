<?php
session_start();
require "lib/openConnection.php";

function randomString($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

if (isset($_POST["email"]) and isset($_POST["password"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  //checks whether the email already exists
  $sql = "select userID, name, email, password_hash from users where email = '{$email}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  // returns true if typed password and stored password are the same
  $auth = password_verify($password, $userInfo["password_hash"]);
  try {
    if (!$auth) {
      throw new Exception('<p style="color:red">Wrong email or password</p>');
    }
    $_SESSION['userID'] = $userInfo["userID"];
    $_SESSION['name'] = $userInfo['name'];
    $_SESSION['email'] = $userInfo['email'];
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

if (isset($_SESSION['name'])) {
  header("Location: index.php");
}

$conn->close();
