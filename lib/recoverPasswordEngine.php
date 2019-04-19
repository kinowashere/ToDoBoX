<?php
session_start();

$conn = open_connection();

function randomString($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

if (isset($_POST['email']) and isset($_POST['recovery_code'])) {
  $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
  $recovery_code = filter_var($_POST['recovery_code'], FILTER_SANITIZE_STRING);

  //checks whether the email already exists
  $sql = "select email, recovery_code, password_hash from users where email = '{$email}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);
  try {
    //Incorrect email or code
    if ($userInfo["email"] != $email or $userInfo["recovery_code"] != $recovery_code) {
      throw new Exception('<p style="color:red">Wrong email or recovery code</p>');
    }

    $user = new User($conn, $_SESSION['user_id']);
    $user->user_recover_password();
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

close_connection($conn);
