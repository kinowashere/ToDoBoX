<?php

require "lib/openConnection.php";


if (isset($_POST["new_name"]) and $_POST["new_name"] != "") {
  $new_name = $_POST["new_name"];

  $sql = "update users set name='{$new_name}' where userID = '{$_SESSION['userID']}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} elseif (isset($_POST["new_email"]) and $_POST["new_email"] != "") {
  $new_email = $_POST["new_email"];

  $sql = "update users set email='{$new_email}' where userID = '{$_SESSION['userID']}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = array();
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} elseif (isset($_POST["new_password"]) and $_POST["confirm_password"]) {
  $new_password = $_POST["new_password"];
  $confirm_password = $_POST["confirm_password"];

  if ($new_password != $confirm_password) {
    echo "they don't match";
  } else {
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    $sql = "update users set password_hash='{$new_password_hash}' where userID = '{$_SESSION['userID']}'";
    $retval = mysqli_query($conn, $sql);
    $userInfo = array();
    $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}



$conn->close();
