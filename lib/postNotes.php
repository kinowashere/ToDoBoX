<?php

// checks if user is logged in.
if (!isset($_SESSION['userID'])) {
  //if not, redirect to login.php
  header('Location: login.php');
}

$conn = open_connection();

// Get data from POST

if (isset($_POST["noteInput"])) {
  $noteInput = $_POST['noteInput'];
  $date = $_POST['date'];

  if ($date == "") {
    // Insert data
    $sql = "INSERT INTO boxes_{$_SESSION['userID']} (Valid, BoxData) VALUES (1,'" . $noteInput . "')";

    if ($conn->query($sql) === TRUE) { } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    // Insert data
    $sql = "INSERT INTO boxes_{$_SESSION['userID']} (Valid, BoxData, BoxDate) VALUES (1,'" . $noteInput . "','" . $date . "')";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  close_connection($conn);
  header("Location: index.php?create_box");
} elseif (isset($_POST["boxIDArchive"])) {
  $boxID = $_POST["boxIDArchive"];
  $sql = "delete from boxes_{$_SESSION['userID']} where BoxID='{$boxID}'";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  close_connection($conn);
  header("Location: archive.php?delete_box");
} elseif (isset($_POST["boxID"])) {
  $boxID = $_POST["boxID"];
  $sql = "update boxes_{$_SESSION['userID']} set Valid=0 where BoxID='{$boxID}'";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  close_connection($conn);
  header("Location: index.php?archive_box");
} elseif (isset($_POST["boxIDEdit"])) {
  $boxID = $_POST["boxIDEdit"];
  if ($_POST["editNoteInput"] != "") {
    $noteInput = $_POST['editNoteInput'];
    $sql = "update boxes_{$_SESSION['userID']} set BoxData = '{$noteInput}' where BoxID='{$boxID}'";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  if (isset($_POST["editDate"])) {
    $boxDate = $_POST["editDate"];
    $sql = "update boxes_{$_SESSION['userID']} set BoxDate = '{$boxDate}' where BoxID='{$boxID}'";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  if (isset($_POST["unsetDate"])) {
    $sql = "update boxes_{$_SESSION['userID']} set BoxDate = NULL where BoxID='{$boxID}'";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  close_connection($conn);
  header("Location: index.php?edited_note");
} elseif (isset($_POST["boxIDArchiveRestore"])) {
  $boxID = $_POST["boxIDArchiveRestore"];
  $userID = $_SESSION["userID"];
  $sql = "update boxes_{$userID} set Valid = 1 where BoxID = '{$boxID}';";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  close_connection($conn);
  header("Location: archive.php?archive_restore");
}
close_connection($conn);
