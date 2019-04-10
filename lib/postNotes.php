<?php

// checks if user is logged in.
if (!isset($_SESSION['userID'])) {
  //if not, redirect to login.php
  header('Location: login.php');
}

require "lib/openConnection.php";

function randomNumber($length)
{
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars), 0, $length);
}

// Get data from POST

if (isset($_POST["noteInput"])) {
  $noteInput = $_POST['noteInput'];
  $date = $_POST['date'];
  $boxID = randomNumber(32);

  if ($date == "") {
    // Insert data
    $sql = "INSERT INTO boxes_{$_SESSION['userID']} (Valid, BoxID, BoxData) VALUES (1,'" . $boxID . "','" . $noteInput . "')";

    if ($conn->query($sql) === TRUE) { } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    // Insert data
    $sql = "INSERT INTO boxes_{$_SESSION['userID']} (Valid, BoxID, BoxData, BoxDate) VALUES (1,'" . $boxID . "','" . $noteInput . "','" . $date . "')";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  header("Location: index.php?create_box");
} elseif (isset($_POST["boxIDArchive"])) {
  $boxID = $_POST["boxIDArchive"];
  $sql = "delete from boxes_{$_SESSION['userID']} where BoxID='{$boxID}'";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  header("Location: archive.php?delete_box");
} elseif (isset($_POST["boxID"])) {
  $boxID = $_POST["boxID"];
  $sql = "update boxes_{$_SESSION['userID']} set Valid=0 where BoxID='{$boxID}'";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  header("Location: index.php?archive_box");
}
$conn->close();

?>