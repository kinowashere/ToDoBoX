<?php

require "lib/openConnection.php";


if (isset($_POST["new_name"]) and $_POST["new_name"] != "") {
  $new_name = $_POST["new_name"];
  $sql = "update users set name = '{$new_name}' where userID = '{$_SESSION['userID']}';";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} elseif (isset($_POST["new_email"]) and $_POST["new_email"] != "") {
  $new_email = $_POST["new_email"];
  $sql = "update users set email='{$new_email}' where userID = '{$_SESSION['userID']}'";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} elseif (isset($_POST["new_password"]) and isset($_POST["confirm_password"])) {
  $new_password = $_POST["new_password"];
  $confirm_password = $_POST["confirm_password"];

  if ($new_password != $confirm_password) {
    echo "they don't match";
  } else {
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $sql = "update users set password_hash='{$new_password_hash}' where userID = '{$_SESSION['userID']}'";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
} elseif (isset($_POST["delete_password"])) {
  $delete_password = $_POST["delete_password"];

  //checks whether the email already exists
  $sql = "select password_hash from users where userID = '{$_SESSION["userID"]}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  // returns true if typed password and stored password are the same
  $auth = password_verify($delete_password, $userInfo["password_hash"]);

  if ($auth) {
    // delete table for user's boxes
    $sql = "DROP TABLE boxes_{$_SESSION['userID']}";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // delete user data from table users
    $sql = "DELETE FROM users WHERE userID = '{$_SESSION['userID']}'";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // delete sessions
    session_unset();
    session_destroy();
    header('Location: login.php');
  } else {
    echo ("Password isn't correct");
  }
} elseif (isset($_POST["new_profile_photo"])) {
  $new_profile_photo = $_POST["new_profile_photo"];

  $sql = "update users set profile_photo = '{$new_profile_photo}' where userID = '{$_SESSION['userID']}';";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
