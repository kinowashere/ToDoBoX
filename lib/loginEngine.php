<?php
session_start();
$conn = open_connection();

if (isset($_POST['email']) and isset($_POST['password'])) {

  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

  // Checks if the email already exists
  $sql = "SELECT user_id, name, email, password_hash FROM users WHERE email = '{$email}'";
  $retval = mysqli_query($conn, $sql);
  $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  try {
    if($user_info['email'] != $email) {
      throw new Exception("email_doesnt_exist"); 
    }

    // Returns true if typed password and stored password are the same
    $auth = password_verify($password, $user_info["password_hash"]);

    if (!$auth) {
      throw new Exception("login_incorrect");
    }

    $_SESSION['user_id'] = $user_info["user_id"];
    $_SESSION['name'] = $user_info['name'];
    $_SESSION['email'] = $user_info['email'];

  } catch (Exception $e) {
    if(strcmp($e->getMessage(),"login_incorrect") == 0 ) {
      header("Location: login.php?login_incorrect");
    }
    if(strcmp($e->getMessage(),"email_doesnt_exist") == 0 ) {
      header("Location: login.php?email_doesnt_exist");
    }
  }
}

if (isset($_SESSION['name'])) {
  header("Location: index.php");
}

close_connection($conn);
