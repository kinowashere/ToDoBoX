<?php

// Given a table name, column name, column datatype and any extra info
// The table will be updated with the set parameters
// Returns false if something fails, else true

function table_column_updater($conn, $table, $column_name, $column_datatype, $extra_info = "")
{

  // Add column if it doesn't exist

  $sql = "ALTER TABLE {$table} ADD COLUMN {$column_name} {$column_datatype} {$extra_info};";
  if ($conn->query($sql) != true) {
    echo "Error: " . $sql . "<br>" . $conn->error;
    return false;
  }

  return true;
}

// If the POST is update

if (isset($_POST['update'])) {

  // Connect to SQL

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  // If the database doesn't exist, you cannot update

  if ($conn->connect_error) {
    header("Location: setup_wizard.php?update_error");
  }

  // Updates table users

  $sql = "CREATE TABLE IF NOT EXISTS users (user_id VARCHAR(100) NOT NULL);";

  $conn->query($sql);

  table_column_updater($conn, "users", "user_id", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "users", "name", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "users", "email", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "users", "password_hash", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "users", "profile_photo", "INT(1)", "NOT NULL");
  table_column_updater($conn, "users", "recovery_code", "VARCHAR(10)", "NOT NULL");
  table_column_updater($conn, "users", "is_admin", "TINYINT(1)", "NOT NULL DEFAULT 0");

  $sql = "ALTER TABLE users ADD PRIMARY KEY(user_id);";

  $conn->query($sql);

  // Creates table contacts

  $sql = "CREATE TABLE IF NOT EXISTS contact (user_id VARCHAR(100) NOT NULL);";

  $conn->query($sql);

  table_column_updater($conn, "contact", "user_id", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "contact", "contact_id", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "contact", "contact_name", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "contact", "contact_email", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "contact", "contact_message", "VARCHAR(100)", "NOT NULL");
  table_column_updater($conn, "contact", "valid", "TINYINT(1)", "DEFAULT 1");

  $sql = "ALTER TABLE contact ADD PRIMARY KEY(contact_id);";

  $conn->query($sql);

  //checks whether the email already exists
  $sql = "SELECT email FROM users WHERE email = '{$email_check}'";
  $retval = mysqli_query($conn, $sql);
  $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);
}
