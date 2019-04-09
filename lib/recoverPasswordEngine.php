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
  if ($userInfo["email"] != $email) {
    echo ('<p style="color:red">This email is not registered.</p>');
    //checks whether recovery code is correct
  } elseif ($userInfo["recovery_code"] != $recovery_code) {
    echo ('<p style="color:red">This recovery code is not correct.</p>');
  } else {
    $generated_password = randomString(8);
    //todo send the password to the user via email
    echo $generated_password;

    $generated_password_hash = password_hash($generated_password, PASSWORD_DEFAULT);
    echo $generated_password_hash;


    $sql = "update users set password_hash='{$generated_password_hash}' where email = '{$email}'";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

$conn->close();
