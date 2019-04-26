<?php
if (isset($_POST['install'])) {

  // Initial connection to SQL
  // This is done to create the database
  // Then a full connection with database is done

  $server_name = $_POST['server_name'];
  $server_username = $_POST['server_username'];
  $server_password = $_POST['server_password'];
  $db_name = 'todoDB';

  // Test if database exists
  // If it exists, installation cannot be done

  $conn = new mysqli($server_name, $server_username, $server_password);

  if ($conn->select_db($db_name)) {
    $conn->close();
    header("Location: setup_wizard.php?database_exists");
    die();
  }

  // Perform initial connection if the test is passed

  $conn = new mysqli($server_name, $server_username, $server_password);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Save all server info to a PHP file

  $var_server_name = var_export($server_name, true);
  $var_server_username = var_export($server_username, true);
  $var_server_password = var_export($server_password, true);
  $var =
    "<?php
    \$server_name = $var_server_name;
    \$server_username = $var_server_username;
    \$server_password = $var_server_password;
    \$db_name = 'todoDB';
  ?>";

  file_put_contents('lib/sql_data.php', $var);

  // Create DB and close old connection

  $sql = "CREATE DATABASE IF NOT EXISTS {$db_name};";

  if ($conn->query($sql) != true) {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

  // New connection with DB selected

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Create table users

  $sql = "CREATE TABLE IF NOT EXISTS users (
  user_id VARCHAR(100) NOT NULL,
  name VARCHAR(100) NOT NULL, 
  email VARCHAR(100) NOT NULL, 
  password_hash VARCHAR(100) NOT NULL, 
  profile_photo INT(1) NOT NULL, 
  recovery_code VARCHAR(10) NOT NULL, 
  is_admin TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY(user_id));";

  if ($conn->query($sql) != true) {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  // Create table contacts

  $sql = "CREATE TABLE IF NOT EXISTS contact (
  user_id VARCHAR(100) NOT NULL,
  contact_id VARCHAR(100) NOT NULL,
  contact_name VARCHAR(100) NOT NULL, 
  contact_email VARCHAR(100) NOT NULL, 
  contact_message VARCHAR(100) NOT NULL, 
  PRIMARY KEY(contact_id));";

  if ($conn->query($sql) != true) {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  try {

    // Test CAPTCHA
    require 'securimage/securimage.php';
    $securimage = new Securimage();
    if ($securimage->check($_POST['captcha_code']) == false) {
      throw new Exception("wrong_captcha");
    }

    // Insert user data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $user = new User($conn);
    $user->user_register($name, $email, $password_hash, '1');
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

    // Create Session
    $_SESSION['user_id'] = $user_id;
    $_SESSION["recovery_active"] = 1;

    // Jump to recovery_code.php
    $conn->close();
    header('Location: recovery_code.php');
    die();
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "wrong_captcha") == 0) {
      $conn->close();
      header("Location: setup_wizard.php?wrong_captcha");
      die();
    }
  }
}
