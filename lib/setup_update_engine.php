<?php

// Given a table name, column name, column datatype and any extra info
// The table will be updated with the set parameters
// Returns false if something fails, else true

function table_column_updater($conn, $table, $column_name, $column_datatype, $extra_info = "") {

  // Create the empty table if it doesn't exist

  $sql = "CREATE TABLE IF NOT EXISTS {$table} ();";
  if ($conn->query($sql) != true) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    return false;
  }

  // Add column if it doesn't exist

  $sql = "ALTER TABLE {$table} ADD COLUMN IF NOT EXISTS {$column_name};";
  if ($conn->query($sql) != true) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    return false;
  }

  // Add the datatype and extra info

  $sql = "ALTER TABLE {$table} MODIFY COLUMN {$column_name} {$column_datatype} {$extra_info};";
  if ($conn->query($sql) != true) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    return false;
  }

  return true;
}

if (isset($_POST['update'])) {

  // Connect to SQL

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  // If the database doesn't exist, you cannot update

  if ($conn->connect_error) {
    header("Location: setup_wizard.php?update_error");
  }

  // Updates table users

  table_column_updater($conn, "users", "user_id", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "users", "name", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "users", "email", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "users", "password_hash", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "users", "profile_photo", "INT(1)", "NOT NULL");
  table_column_updater($conn, "users", "recovery_code", "VARCHAR(10)", "NOT NULL");
  table_column_updater($conn, "users", "is_admin", "TINYINT(1)", "NOT NULL DEFAULT 0");

  $sql = "ALTER TABLE users ADD PRIMARY KEY(user_id);";
  
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
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

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $email_check = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  //checks whether the email already exists
  $sql = "SELECT email FROM users WHERE email = '{$email_check}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  try {

    // If the email already exists
    if ($userInfo["email"] == $email_check) {
      throw new Exception("register_email_exists"); // email already exists
    }

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
    $user_id = random_string(50);
    $recovery_code = random_string(6);

    $user = new User($conn);
    $user->user_register($user_id, $name, $email, $password_hash, $recovery_code, '0');

    // Jump to index
    $conn -> close();
    echo('Success!');
  } catch (Exception $e) {
    if (strcmp($e->getMessage(), "register_email_exists") == 0) {
      $conn -> close();
      header("Location: setup_wizard.php?register_email_exists");
    }
    if (strcmp($e->getMessage(), "wrong_captcha") == 0) {
      $conn -> close();
      header("Location: setup_wizard.php?wrong_captcha");
    }
  }
}
