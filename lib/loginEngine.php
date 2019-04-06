<?php
session_start();
require "lib/openConnection.php";

function randomString($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

if (isset($_POST)) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  //checks whether the email already exists
  $sql = "select userID, name, email, password_hash from users where email = '{$email}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  // returns true if typed password and stored password are the same
  $auth = password_verify($password, $userInfo["password_hash"]);

  if ($auth) {

    echo ("Login success <br>");
    $_SESSION['userID'] = $userInfo["userID"];
    $_SESSION['name'] = $userInfo['name'];
    $_SESSION['email'] = $userInfo['email'];
    echo "Sessions<br>" . $_SESSION['userID'];
    echo "<br>" . $_SESSION['name'];
    echo "<br>" . $_SESSION['email'];
  } else {
    echo ("Wrong email or password");
  }

  if (isset($_SESSION['name'])) {
    header("Location: index.php");
  }
}

$conn->close();
