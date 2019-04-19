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
  // If it exists, install cannot be done

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  if (!$conn->connect_error) {
    $conn->close();
    header("Location: setup_wizard.php?database_exists");
  }

  // Perform the initial connection if the test is passed

  $conn = new mysqli($server_name, $server_username, $server_password);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Saves all server info to a PHP file

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

  // Creates the DB and closes old connection

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

  // Creates table users

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

  // Creates table contacts

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

  $email_check = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  //checks whether the email already exists
  $sql = "SELECT email FROM users WHERE email = '{$email_check}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

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
    $user->user_register($name, $email, $password_hash, '0');

    // Jump to index
    $conn->close();
    echo ('Success!');
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "wrong_captcha") == 0) {
      $conn->close();
      header("Location: setup_wizard.php?wrong_captcha");
    }
  }
}
