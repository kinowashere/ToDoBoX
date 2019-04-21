<?php
session_start();

$conn = new mysqli($server_name, $server_username, $server_password, $db_name);

// Admin Access
if (isset($_POST['admin'])) {
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
      throw new Exception("incorrect_password_admin");
    }
    // redirect to admin_panel.php
    $_SESSION['admin_privilege'] = 1;
    $conn->close();
    header('Location: admin_panel.php');
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "incorrect_password_admin") == 0) {
      unset($_SESSION['admin_privilege']);
      $conn->close();
      header("Location: index.php?incorrect_password_admin");
    }
  }
}

// Create user
if (isset($_POST['name']) and isset($_POST['password']) and isset($_POST['email'])) {
  $email_check = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

  //checks whether the email already exists
  $sql = "SELECT email FROM users WHERE email = '{$email_check}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  try {

    // If the email already exists
    if ($userInfo["email"] == $email_check) {
      throw new Exception("register_email_exists");
    }

    // Insert user data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $user = new User($conn);
    if (isset($_POST['check_admin']) && $_POST['check_admin]'] == 'admin') {
      $user->user_register($name, $email, $password_hash, '1');
    } else {
      $user->user_register($name, $email, $password_hash, '0');
    }
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

    // Create the Session
    $_SESSION['user_id'] = $user_id;
    $_SESSION["recovery_active"] = 1;

    // Jump to index
    $conn->close();
    header('Location: recovery_code.php');
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "register_email_exists") == 0) {
      $conn->close();
      header("Location: register.php?register_email_exists");
    }
    if (strcmp($e->getMessage(), "wrong_captcha") == 0) {
      $conn->close();
      header("Location: register.php?wrong_captcha");
    }
  }
}
