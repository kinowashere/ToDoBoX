<?php

require "lib/openConnection.php";

function randomNumber($length) {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  return substr(str_shuffle($chars),0,$length);
}

// Get data from POST

if (isset($_POST["noteInput"])) {
  $noteInput = $_POST['noteInput'];
  $date = $_POST['date'];
  $boxID = randomNumber(32);

  if($date == "") {
    // Insert data
    $sql = "INSERT INTO boxes (Valid, BoxID, BoxData) VALUES (1,'".$boxID."','".$noteInput."')";

    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    // Insert data
    $sql = "INSERT INTO boxes (Valid, BoxID, BoxData, BoxDate) VALUES (1,'".$boxID."','".$noteInput."','".$date."')";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
} elseif (isset($_POST["boxIDArchive"])) {
  $boxID = $_POST["boxIDArchive"];
  $sql = "delete from boxes where BoxID='{$boxID}'";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} elseif (isset($_POST["boxID"])) {
  $boxID = $_POST["boxID"];
  $sql = "update boxes set Valid=0 where BoxID='{$boxID}'";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}
$conn->close();
?>