<?php

// Admin Access
if (isset($_POST['admin'])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $admin = filter_var($_POST['admin'], FILTER_SANITIZE_STRING);
  // Checks if password is correct
  $sql = "SELECT password_hash FROM users WHERE user_id = '{$_SESSION['user_id']}'";
  $retval = mysqli_query($conn, $sql);
  $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  // returns true if typed password and stored password are the same
  $auth = password_verify($admin, $user_info["password_hash"]);
  try {
    // Checks if password is correct
    if (!$auth) {
      throw new Exception("incorrect_password_admin");
    }
    // redirect to admin_panel.php
    $_SESSION['admin_privilege'] = 1;
    $conn->close();
    header('Location: admin_panel.php');
    die();
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "incorrect_password_admin") == 0) {
      unset($_SESSION['admin_privilege']);
      $conn->close();
      header("Location: index.php?incorrect_password_admin");
      die();
    }
  }
}

// Create user
if (isset($_POST['create'])  and isset($_POST['password']) and isset($_POST['email'])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $email_check = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

  //checks whether the email already exists
  $sql = "SELECT email FROM users WHERE email = '{$email_check}'";
  $retval = mysqli_query($conn, $sql);
  $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  try {

    // If the email already exists
    if ($user_info["email"] == $email_check) {
      throw new Exception("register_email_exists");
    }

    // Insert user data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $user = new User($conn);

    if (isset($_POST['check_admin'])) {
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

    // Jump to index
    $conn->close();
    header('Location: admin_panel.php');
    die();
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "register_email_exists") == 0) {
      $conn->close();
      header("Location: register.php?register_email_exists");
      die();
    }
  }
}

// Edit user
if (isset($_POST['edit_user'])) {
  print_r($_POST);

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $email_check = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

  //checks whether the email already exists
  $sql = "SELECT email FROM users WHERE email = '{$email_check}'";
  $retval = mysqli_query($conn, $sql);
  $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  try {


    // If the email already exists
    if ($user_info["email"] == $email_check) {
      throw new Exception("register_email_exists");
    }

    // Insert user data
    $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_STRING);

    $user = new User($conn, $user_id);

    if (isset($_POST['name'])) {
      $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
      $user->user_set_name($name);
    }

    if (isset($_POST['email'])) {
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $user->user_set_email($email);
    }

    if (isset($_POST['password'])) {
      $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $user->user_set_password($password_hash);
    }

    if (isset($_POST['recovery_code'])) {
      $recovery_code = filter_var($_POST['recovery_code'], FILTER_SANITIZE_STRING);
      $user->user_set_recovery_code($recovery_code);
    }

    if (isset($_POST['check_admin'])) {
      $user->user_set_admin();
    }

    // Jump to index
    $conn->close();
    //header('Location: admin_panel.php');
    die();
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "register_email_exists") == 0) {
      $conn->close();
      header("Location: admin_panel.php?register_email_exists");
      die();
    }
  }
}

// Delete user
if (isset($_POST['delete_user'])) {
  // Connect to SQL
  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);
  // Insert user data
  $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_STRING);

  $user = new User($conn, $user_id);
  $user->user_delete($user_id);

  $conn->close();
  header('Location: admin_panel.php');
  die();
}

// Delete feedback
if (isset($_POST['delete_feedback'])) {
  // Connect to SQL
  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);
  $contact_id = filter_var($_POST['contact_id'], FILTER_SANITIZE_STRING);
  $test = filter_var($_POST['test'], FILTER_SANITIZE_STRING);
  echo $contact_id;

  $sql = "DELETE FROM contact WHERE contact_id = '{$contact_id}';";
  $conn->query($sql);

  $conn->close();
  header('Location: admin_panel.php');
  die();
}

// Send feedback
if (isset($_POST['send_mail'])) {
  echo "tere";
  print_r($_POST);
  $contact_name = filter_var($_POST['contact_name'], FILTER_SANITIZE_STRING);
  $contact_email = filter_var($_POST['contact_email'], FILTER_SANITIZE_EMAIL);
  $contact_message = filter_var($_POST['contact_message'], FILTER_SANITIZE_STRING);

  require_once "lib/Mail-1.4.1/Mail.php";
  $from = '<todoboxtaltech@gmail.com>';
  $to = $contact_mail;
  $subject = 'Hello, ' . $contact_name;
  $body = "Hello, " . $contact_name . "\n" . $contact_message . "\nBest regards,\nToDoBoX";

  $headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
  );

  $smtp = Mail::factory('smtp', array(
    'host' => 'ssl://smtp.gmail.com',
    'port' => '465',
    'auth' => true,
    'username' => 'myaccount',
    'password' => 'manuelandshiori23'
  ));

  $mail = $smtp->send($to, $headers, $body);

  if (PEAR::isError($mail)) {
    echo ('tere<p>' . $mail->getMessage() . '</p>');
  } else {
    echo ('privet<p>Message successfully sent!</p>');
  }

  $conn->close();
  //header('Location: admin_panel.php');
  die();
}
