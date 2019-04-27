<?php
session_start();

function randomString($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

if (isset($_POST['email']) and isset($_POST['recovery_code'])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
  $recovery_code = filter_var($_POST['recovery_code'], FILTER_SANITIZE_SPECIAL_CHARS);

  //checks whether the email already exists
  $sql = "select email, recovery_code, password_hash from users where email = '{$email}'";
  $retval = mysqli_query($conn, $sql);
  $user_info = array();
  $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);
  $conn->close();
  try {
    //Incorrect email or code
    if ($user_info["email"] != $email or $user_info["recovery_code"] != $recovery_code) {
      throw new Exception('<p style="color:red">Wrong email or recovery code</p>');
    }

    $user = new User($conn, $_SESSION['user_id']);
    $user->user_recover_password();
  } catch (Exception $e) {
    echo $e->getMessage();
    $conn->close();
  }
}
