<?php
if (isset($_POST['install'])) {
  $server_name = $_POST['server_name'];
  $server_username = $_POST['server_username'];
  $server_password = $_POST['server_password'];

  // save server name, username, password, dbname in a PHP file
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
  // import database data
  require 'lib/SQLdata.php';

  $conn = new mysqli($server_name, $server_username, $server_password);
  // Check connection
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
}

$conn->close();
