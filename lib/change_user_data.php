<?php

// POST

// Change name
if (isset($_POST['new_name'])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $new_name = filter_var($_POST['new_name'], FILTER_SANITIZE_SPECIAL_CHARS);
  try {
    // Check if new name is empty
    if ($new_name == "") {
      throw new Exception("empty_name");
    }
    $user = new User($conn, $_SESSION['user_id']);
    $user->user_set_name($new_name);
    $conn->close();
    header("Location: index.php?update_name");
    die();
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "empty_name") == 0) {
      $conn->close();
      header("Location: index.php?empty_name");
      die();
    }
  }
}

// Change email
if (isset($_POST['new_email'])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $new_email = filter_var($_POST['new_email'], FILTER_SANITIZE_SPECIAL_CHARS);

  // Checks if email already exists
  $sql = "SELECT email FROM users WHERE email = '{$new_email}'";
  $retval = mysqli_query($conn, $sql);
  $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);
  try {
    // Checks if email already exists
    if ($user_info["email"] == $new_email) {
      throw new Exception("email_already_exists");
    }
    // Check if new email is empty
    if ($new_email == "") {
      throw new Exception("empty_email");
    }
    $user = new User($conn, $_SESSION['user_id']);
    $user->user_set_email($new_email);
    $conn->close();
    header("Location: index.php?update_email");
    die();
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "empty_email") == 0) {
      $conn->close();
      header("Location: index.php?empty_email");
      die();
    } elseif (strcmp($e->getMessage(), "email_already_exists") == 0) {
      $conn->close();
      header("Location: index.php?email_already_exists");
      die();
    }
  }
}
// Change password
if (isset($_POST['new_password']) and isset($_POST["confirm_password"])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_SPECIAL_CHARS);
  $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_SPECIAL_CHARS);
  try {
    // Check if password is long enough
    if (strlen($new_password) < 8) {
      throw new Exception("password_too_short");
    }
    // Check if passwords match
    if ($new_password != $confirm_password) {
      throw new Exception("different_passwords");
    }
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $user = new User($conn, $_SESSION['user_id']);
    $user->user_set_password($new_password_hash);
    $conn->close();
    header("Location: index.php?updated_password");
    die();
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "password_too_short") == 0) {
      $conn->close();
      header("Location: index.php?password_too_short");
      die();
    } elseif (strcmp($e->getMessage(), "different_passwords") == 0) {
      $conn->close();
      header("Location: index.php?different_passwords");
      die();
    }
  }
}

// Change profile photo
if (isset($_POST['new_profile_photo'])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $new_profile_photo = filter_var($_POST['new_profile_photo'], FILTER_SANITIZE_NUMBER_INT);
  $user = new User($conn, $_SESSION['user_id']);
  $user->user_set_photo($new_profile_photo);
  $conn->close();
  header("Location: index.php");
}

// Delete account
if (isset($_POST["delete_account"])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $delete_account = filter_var($_POST['delete_account'], FILTER_SANITIZE_SPECIAL_CHARS);
  // Checks if password is correct
  $sql = "SELECT password_hash FROM users WHERE user_id = '{$_SESSION['user_id']}'";
  $retval = mysqli_query($conn, $sql);
  $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);


  // returns true if typed password and stored password are the same
  $auth = password_verify($delete_account, $user_info["password_hash"]);
  try {
    // Checks if password is correct
    if (!$auth) {
      throw new Exception("incorrect_password_delete");
    }
    $user = new User($conn, $_SESSION['user_id']);
    $user->user_delete($_SESSION['user_id']);
    // delete sessions
    session_unset();
    session_destroy();
    // redirect to login.php
    $conn->close();
    header('Location: deleted_account.php');
    die();
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "incorrect_password_delete") == 0) {
      $conn->close();
      header("Location: index.php?incorrect_password_delete");
      die();
    }
  }
}

// Send message

if (isset($_POST['contact_message'])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);
  $user_id = $_SESSION['user_id'];

  $contact_message = filter_var($_POST['contact_message'], FILTER_SANITIZE_SPECIAL_CHARS);

  $user = new User($conn, $user_id);
  $user->send_contact($contact_message);
  unset($user);
  $conn->close();
  header("Location: index.php?email_success");
  die();
}
