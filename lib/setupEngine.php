<?php
if (isset($_POST['install'])) {
  $server_name = $_POST['server_name'];
  $server_username = $_POST['server_username'];
  $server_password = $_POST['server_password'];

  // saves server name, username, password, dbname in a PHP file
  $var_server_name = var_export($server_name, true);
  $var_server_username = var_export($server_username, true);
  $var_server_password = var_export($server_password, true);
  $var = "<?php
    \$server_name = $var_server_name;
    \$server_username = $var_server_username;
    \$server_password = $var_server_password;
    \$dbname = 'todoDB';
    ?>";
  file_put_contents('lib/SQLdata.php', $var);
  // imports database data
  require 'lib/SQLdata.php';

  $conn = new mysqli($server_name, $server_username, $server_password);
  // checks connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  //creates a DB
  $sql = "CREATE DATABASE IF NOT EXISTS {$dbname};";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  //select a DB
  $sql = "USE todoDB;";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  // creates table users
  $sql = "CREATE TABLE IF NOT EXISTS users
  (user_id VARCHAR(100) NOT NULL,
  name VARCHAR(100) NOT NULL, 
  email VARCHAR(100) NOT NULL, 
  password_hash VARCHAR(100) NOT NULL, 
  profile_photo INT(1) NOT NULL, 
  recovery_code VARCHAR(10) NOT NULL, 
  is_admin TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY(user_id));";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  // create table Contact
  $sql = "CREATE TABLE IF NOT EXISTS contact
  (
  user_id VARCHAR(100) NOT NULL,
  contact_id VARCHAR(100) NOT NULL,
  contact_name VARCHAR(100) NOT NULL, 
  contact_email VARCHAR(100) NOT NULL, 
  contact_message VARCHAR(100) NOT NULL, 
  PRIMARY KEY(contact_id));";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  try {

    // If the email already exists
    if ($userInfo["email"] == $email_check) {
      throw new Exception("register_email_exists"); // email already exists
    }

    // wrong captcha
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
    $user_id = random_string(50);
    $profile_photo = 0;
    $recovery_code = randomString(6);

    $user = new User($conn);
    $user->user_register($user_id, $name, $email, $password_hash, $recovery_code, 1);

    // Jump to index

    close_connection($conn);
    header('Location: recovery_code.php');
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "register_email_exists") == 0) {
      close_connection($conn);
      // header("Location: register.php?register_email_exists");
    }
    if (strcmp($e->getMessage(), "wrong_captcha") == 0) {
      close_connection($conn);
      // header("Location: register.php?wrong_captcha");
    }
  }
}

$conn->close();
