<?php
require "openSession.php";
require "lib/openConnection.php";

function randomString($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

// POST

if (isset($_POST["new_name"])) {
  try {
    // Empty Name
    if ($_POST["new_name"] == "") {
      throw new Exception('<p style="color:red">Error: Invalid Name<br>Name cannot be empty.</p>');
    }
    $new_name = $_POST["new_name"];
    $sql = "update users set name = '{$new_name}' where userID = '{$_SESSION['userID']}';";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    $last_id = $conn->insert_id;
  } catch (Exception $e) {
    echo $e->getMessage();
  }
  header("Location: index.php");
}

if (isset($_POST["new_email"])) {
  try {
    // Empty Name
    if ($_POST["new_email"] == "") {
      throw new Exception('<p style="color:red">Error: Invalid Email<br>Email cannot be empty.</p>');
    }
    $new_email = $_POST["new_email"];
    $sql = "update users set email = '{$new_email}' where userID = '{$_SESSION['userID']}';";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    $last_id = $conn->insert_id;
  } catch (Exception $e) {
    echo $e->getMessage();
  }
  header("Location: index.php");
}

if (isset($_POST["new_password"]) and isset($_POST["confirm_password"])) {
  try {
    // Password Too Short
    if (strlen($_POST["new_password"]) < 8) {
      throw new Exception('<p style="color:red">Error: Invalid Password<br>Password has to contain at least 8 characters.</p>');
    }
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_passwoerd"];
    // Password Not Match
    if ($new_password != $confirm_password) {
      throw new Exception('<p style="color:red">Error: Different Passwords<br>Passwords do not match.</p>');
    }
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    $sql = "update users set password_hash='{$new_password_hash}' where userID = '{$_SESSION['userID']}'";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    $last_id = $conn->insert_id;
  } catch (Exception $e) {
    echo $e->getMessage();
  }
  header("Location: index.php");
}

if (isset($_POST["delete_account"])) {
  $delete_account = $_POST["delete_account"];
  //checks whether the email already exists
  $sql = "select password_hash from users where userID = '{$_SESSION["userID"]}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);
  // returns true if typed password and stored password are the same
  $auth = password_verify($delete_account, $userInfo["password_hash"]);
  try {
    // Incorrect Password
    if (!$auth) {
      throw new Exception('<p style="color:red">Error: Incorrect Password<br>Password is not correct.</p>');
    }
    // delete table for user's boxes
    $sql = "DROP TABLE boxes_{$_SESSION['userID']}";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    // delete user data from table users
    $sql = "DELETE FROM users WHERE userID = '{$_SESSION['userID']}'";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    // delete sessions
    session_unset();
    session_destroy();
    // redirect to login.php
    header('Location: login.php');
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

if (isset($_POST["new_profile_photo"])) {
  $new_profile_photo = $_POST["new_profile_photo"];
  $sql = "update users set profile_photo = '{$new_profile_photo}' where userID = '{$_SESSION['userID']}';";
  try {
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
  } catch (Exception $e) {
    echo $e->getMessage();
  }
  header("Location: index.php");
}

if (isset($_POST["contact_name"]) and isset($_POST["contact_email"]) and isset($_POST["contact_message"])) {
  $contactID = randomString(50);
  $contact_name = $_POST["contact_name"];
  $contact_email = $_POST["contact_email"];
  $contact_message = $_POST["contact_message"];
  // insert contact data
  $sql = "INSERT INTO contact (contactID, contact_name, contact_email, contact_message, userID) VALUES ('{$contactID}', '{$contact_name}', '{$contact_email}', '{$contact_message}', '{$_SESSION["userID"]}');";
  // Connection Error
  echo("M.toast({html: 'I am a toast'})");
  try {
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
  } catch (Exception $e) {
    echo $e->getMessage();
  }
  header("Location: index.php?email_success=1");
}

$conn->close();
