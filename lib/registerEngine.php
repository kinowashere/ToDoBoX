<?php
session_start();

$conn = open_connection();

function randomString($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

if (isset($_POST["name"]) and isset($_POST["password"]) and isset($_POST["email"])) {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $password_hash = password_hash($password, PASSWORD_DEFAULT);
  $userID = randomString(50);
  $profile_photo = 0;
  $recovery_code = randomString(6);

  //checks whether the email already exists
  $sql = "select email from users where email = '{$email}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  try {
    // Email Already Exists
    if ($userInfo["email"] == $email) {
      throw new Exception("register_email_exists"); // email already exists
    }
    // wrong aptcha
    require 'securimage/securimage.php';
    $securimage = new Securimage();
    if ($securimage->check($_POST['captcha_code']) == false) {
      throw new Exception("wrong_captcha"); // wrong captcha
    }
    // insert user data
    $sql = "INSERT INTO users (userID, name, email, password_hash, profile_photo, recovery_code) VALUES ('$userID', '$name', '$email', '$password_hash', '$profile_photo', '$recovery_code')";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    // create user box
    $sql = "CREATE TABLE boxes_{$userID} (Valid INT, BoxID VARCHAR(255), BoxData VARCHAR(255), BoxDate date);";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    // create first box in current
    $boxID = randomString(32);
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (1, '{$boxID}', 'Welcome to ToDoBoX, {$name}!');";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    // create second box in current
    $boxID = randomString(32);
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (1, '{$boxID}', 'Create a new box with + icon in the bottom right.');";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    // create third box in current
    $boxID = randomString(32);
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (1, '{$boxID}', 'Archive a box with the check mark.');";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    // create fourth box in current
    $boxID = randomString(32);
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (1, '{$boxID}', 'Go to Archive in the menu to see archives.');";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    // create first box in archive
    $boxID = randomString(32);
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (0, '{$boxID}', 'Delete a box with the delete mark.');";
    // Connection Error
    if ($conn->query($sql) !== TRUE) {
      throw new Exception('<p style="color:red">Error:' . $sql . "<br>" . $conn->error . '</p>');
    }
    // session
    $_SESSION['userID'] = $userID;
    $_SESSION["recovery_active"] = 1;
    // jump to index
    close_connection($conn);
    header('Location: recovery_code.php');
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "register_email_exists") == 0) {
      close_connection($conn);
      header("Location: register.php?register_email_exists");
    }
    if (strcmp($e->getMessage(), "wrong_captcha") == 0) {
      close_connection($conn);
      header("Location: register.php?wrong_captcha");
    }
  }
}
