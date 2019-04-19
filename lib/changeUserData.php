<?php
require "openSession.php";
$conn = open_connection();

function randomString($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

// POST

// Change name
if (isset($_POST['new_name'])) {
  $new_name = filter_var($_POST['new_name'], FILTER_SANITIZE_STRING);
  try {
    // Check if new name is empty
    if ($new_name == "") {
      throw new Exception("empty_name");
    }
    $user = new User($conn, $_SESSION['user_id']);
    $user->user_set_name($new_name);
    close_connection($conn);
    header("Location: index.php?update_name");
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "empty_name") == 0) {
      close_connection($conn);
      header("Location: index.php?empty_name");
    }
  }
}

// Change email
if (isset($_POST['new_email'])) {
  $new_email = filter_var($_POST['new_email'], FILTER_SANITIZE_STRING);

  // Checks if email already exists
  $sql = "SELECT email FROM users WHERE email = '{$new_email}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);
  try {
    // Checks if email already exists
    if ($userInfo["email"] == $email_check) {
      throw new Exception("email_already_exists");
    }
    // Check if new email is empty
    if ($new_email == "") {
      throw new Exception("empty_email");
    }
    $user = new User($conn, $_SESSION['user_id']);
    $user->user_set_email($new_email);
    close_connection($conn);
    header("Location: index.php?update_email");
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "empty_email") == 0) {
      close_connection($conn);
      header("Location: index.php?empty_email");
    } elseif (strcmp($e->getMessage(), "email_already_exists") == 0) {
      close_connection($conn);
      header("Location: index.php?email_already_exists");
    }
  }
}
// Change password
if (isset($_POST['new_password']) and isset($_POST["confirm_password"])) {
  $new_password = filter_var($_POST['new_password'], FILTER_SANITIZE_STRING);
  $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);
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
    close_connection($conn);
    header("Location: index.php?updated_password");
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "password_too_short") == 0) {
      close_connection($conn);
      header("Location: index.php?password_too_short");
    } elseif (strcmp($e->getMessage(), "different_passwords") == 0) {
      close_connection($conn);
      header("Location: index.php?different_passwords");
    }
  }
}

// Change profile photo
if (isset($_POST['new_profile_photo'])) {
  $new_profile_photo = filter_var($_POST['new_profile_photo'], FILTER_SANITIZE_NUMBER_INT);
  $user = new User($conn, $_SESSION['user_id']);
  $user->user_set_photo($new_profile_photo);
  close_connection($conn);
  header("Location: index.php");
}

// Delete account
if (isset($_POST["delete_account"])) {
  $delete_account = filter_var($_POST['delete_account'], FILTER_SANITIZE_STRING);
  // Checks if password is correct
  $sql = "SELECT password_hash FROM users WHERE user_id = '{$_SESSION['user_id']}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);


  // returns true if typed password and stored password are the same
  $auth = password_verify($delete_account, $userInfo["password_hash"]);
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
    close_connection($conn);
    header('Location: deleted_account.php');
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "incorrect_password_delete") == 0) {
      close_connection($conn);
      header("Location: index.php?incorrect_password_del
      eete");
    }
  }
}

if (isset($_POST["contact_message"])) {
  $user_id = $_SESSION["user_id"];
  $sql = "select name, email from users where user_id = '{$user_id}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  $contact_id = randomString(50);
  $contact_name = $userInfo["name"];
  $contact_email = $userInfo["email"];
  $contact_message = $_POST["contact_message"];
  // insert contact data
  $sql = "INSERT INTO contact (contact_id, contact_name, contact_email, contact_message, user_id) VALUES ('{$contact_id}', '{$contact_name}', '{$contact_email}', '{$contact_message}', '{$_SESSION["user_id"]}');";
  // Connection Error
  echo ("M.toast({html: 'I am a toast'})");
  try {
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
  } catch (Exception $e) {
    echo $e->getMessage();
  }
  close_connection($conn);
  header("Location: index.php?email_success=1");
}
