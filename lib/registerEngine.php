<?php
session_start();

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
    echo ('<p style="color:red">This email is already used.</p>');
  } else {
    // Create the user's data in the user's table.
    $sql = "INSERT INTO users (userID, name, email, password_hash, profile_photo) VALUES ('$userID', '$name', '$email', '$password_hash', 0)";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // Create the user's table.


    $sql = "CREATE TABLE boxes_{$userID} (Valid INT, BoxID VARCHAR(255), BoxData VARCHAR(255), BoxDate date);";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $boxID = randomString(32);
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (1, '{$boxID}', 'Welcome to ToDoBoX, {$name}!');";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $boxID = randomString(32);
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (1, '{$boxID}', 'Create a new box with + icon in the bottom right.');";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $boxID = randomString(32);
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (1, '{$boxID}', 'Archive a box with the check mark.');";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $boxID = randomString(32);
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (1, '{$boxID}', 'Go to Archive in the menu to see archives.');";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $boxID = randomString(32);
    $sql = "INSERT INTO boxes_{$userID} (Valid, BoxID, BoxData) VALUES (0, '{$boxID}', 'Delete a box with the delete mark.');";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $_SESSION['userID'] = $userID;
    header('Location: index.php');
  }
}

$conn->close();
