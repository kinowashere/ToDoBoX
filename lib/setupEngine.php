<?php
if (isset($_POST['install'])) {
  $servername = "localhost";
  $username = "testroot";
  $password = "";
  $dbname = "todoDB";
  $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // create a php file to write. overwrites when it already exists.
  $myfile = fopen("lib/SQLdata.php", "w") or die("Unable to open file!");
  $data = '
  <?php
  $server_name = \'{$_POST[\'server_name\']}\';
  $server_username = \'{$_POST[\'server_username\']}\';
  $server_password = \'{$_POST[\'server_password\']}\';
  $dbname = \'todoDB\';
  ?>';
  // writes $data in $myfile
  $myfile = fwrite($myfile, $data);


  //creates a DB
  $sql = " CREATE DATABASE IF NOT EXISTS todoDB;";
  // Connection Error
  if ($conn->query($sql) !== TRUE) {
    echo ('error');
  };
  //select a DB
  $sql = " USE todoDB;";
  // Connection Error
  if ($conn->query($sql) === TRUE) {
    echo ('works');
  } else {
    echo ('error');
  };
  // creates tables to use
  // table users
  $sql = " CREATE TABLE IF NOT EXISTS users
  (user_id VARCHAR(100) NOT NULL,
  name VARCHAR(100) NOT NULL, 
  email VARCHAR(100) NOT NULL, 
  password_hash VARCHAR(100) NOT NULL, 
  profile_photo TINYINT(1) UNSIGNED NOT NULL, 
  recovery_code VARCHAR(10) NOT NULL, 
  is_admin TINYINT(1) NOT NULL DEFAULT '0',
  );";

  // Connection Error
  if ($conn->query($sql) === TRUE) {
    echo ('works');
  } else {
    echo ('error');
  };

  // table Contact
  $sql = " CREATE TABLE IF NOT EXISTS contact
  (
  user_id VARCHAR(100) NOT NULL,
  contact_id VARCHAR(100) NOT NULL,
  contact_name VARCHAR(100) NOT NULL, 
  contact_email VARCHAR(100) NOT NULL, 
  contact_message VARCHAR(100) NOT NULL, 
  );";

  // Connection Error
  if ($conn->query($sql) === TRUE) {
    echo ('works');
  } else {
    echo ('error');
  }
  $conn -> close();
}
header(" Location: setup_wizard . php ? done ");
