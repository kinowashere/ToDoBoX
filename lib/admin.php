<?php
session_start();

// Delete account
if (isset($_POST["admin"])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $_SESSION['admin_privilege'] = 1;
  $admin = filter_var($_POST['admin'], FILTER_SANITIZE_STRING);
  // Checks if password is correct
  $sql = "SELECT password_hash FROM users WHERE user_id = '{$_SESSION['user_id']}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  // returns true if typed password and stored password are the same
  $auth = password_verify($admin, $userInfo["password_hash"]);
  try {
    // Checks if password is correct
    if (!$auth) {
      throw new Exception("incorrect_password_delete");
    }
    // redirect to index.php
    $conn->close();
    header('Location: index.php');
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "incorrect_password_delete") == 0) {
      $conn->close();
      header("Location: index.php?incorrect_password_delete");
    }
  }
}
