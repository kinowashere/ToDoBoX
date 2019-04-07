<?php

require "lib/openConnection.php";

function randomString($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

if (isset($_POST["name"]) and isset($_POST["password"]) and isset($_POST["email"])) {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $password_hash = password_hash($password, PASSWORD_DEFAULT);
  $userID = randomString(50);

  //checks whether the email already exists
  $sql = "select email from users where email = '{$email}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);
  if ($userInfo["email"] == $email) {
    echo ("This email already exists.");
  } else {
    // Create the user's data in the user's table.
    $sql = "INSERT INTO users (userID, name, email, password_hash) VALUES ('$userID', '$name', '$email', '$password_hash')";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // Create the user's table.
    $boxID = randomString(32);

    $sql = "CREATE TABLE boxes_{$userID} (Valid INT, BoxID VARCHAR(255), BoxData VARCHAR(255), BoxDate date);";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Create the first box.
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (1, '{$boxID}', 'Welcome to ToDoBoX! You can enter a new box with the icon on the bottom. Archive them with the check mark.');";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    echo ("New account created!");
  }
}

$conn->close();
