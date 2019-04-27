<?php
session_start();

$conn = new mysqli($server_name, $server_username, $server_password, $db_name);

if (isset($_POST['name']) and isset($_POST['password']) and isset($_POST['email'])) {
  $email_check = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

<<<<<<< HEAD
  // Checks if the email already exists
=======
  //check if email already exists
>>>>>>> 049b85eb35d938ca3faaffe63341a5de08b7d6a6
  $sql = "SELECT email FROM users WHERE email = '{$email_check}'";
  $retval = mysqli_query($conn, $sql);
  $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  try {

    // Test if email already exists
    if ($user_info["email"] == $email_check) {
      throw new Exception("register_email_exists");
    }

    // Wrong captcha
    require 'securimage/securimage.php';
    $securimage = new Securimage();
    if ($securimage->check($_POST['captcha_code']) == false) {
      throw new Exception("wrong_captcha"); // wrong captcha
    }

    // Insert user data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // If the name is empty
    if($name == '') {
      throw new Exception('empty_name');
    }

    $user = new User($conn);
    $user->user_register($name, $email, $password_hash);
    $user_id = $user->user_get_user_id();

    // Create Starter / Tutorial Boxes

    // First Box in Current
    $box = new Box($user_id, $conn);
    $box->box_set_data("Welcome to ToDoBoX, {$name}!");
    $box->box_set_category("Tutorial");
    unset($box);

    // Second Box in Current
    $box = new Box($user_id, $conn);
    $box->box_set_data("Create a new box with + icon in the bottom right.");
    $box->box_set_category("Tutorial");
    unset($box);

    // Third Box in Current
    $box = new Box($user_id, $conn);
    $box->box_set_data("Archive a box with the check mark.");
    $box->box_set_category("Tutorial");
    unset($box);

    // Fourth Box in Current
    $box = new Box($user_id, $conn);
    $box->box_set_data("Go to Archive in the menu to see your archived boxes.");
    $box->box_set_category("Tutorial");
    unset($box);

    // First Box in Archive
    $box = new Box($user_id, $conn);
    $box->box_set_data("Delete a box with the delete mark.");
    $box->box_set_category("Tutorial");
    $box->box_archive();
    unset($box);

    // Create session
    $_SESSION['user_id'] = $user_id;
    $_SESSION["recovery_active"] = 1;

    // Jump to recovery_code.php
    $conn->close();
    header('Location: recovery_code.php');
    die();
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "register_email_exists") == 0) {
      $conn->close();
      header("Location: register.php?register_email_exists");
      die();
    }
    elseif (strcmp($e->getMessage(), "wrong_captcha") == 0) {
      $conn->close();
      header("Location: register.php?wrong_captcha");
      die();
    }
    elseif (strcmp($e->getMessage(), "empty_name") == 0) {
      $conn->close();
      header("Location: register.php?empty_name");
      die();
    }
  }
}
