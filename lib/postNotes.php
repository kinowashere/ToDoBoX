<?php

// Checks if user is logged in
// If not, redirect to login
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
}

$conn = open_connection();

// Get data from POST

if (isset($_POST["noteInput"])) {
  $box_data_input = filter_var($_POST['noteInput'], FILTER_SANITIZE_STRING);
  $box_date_input = $_POST['date'];
  $box_category_input = filter_var($_POST['category'], FILTER_SANITIZE_STRING);

  if($box_date_input != '') {
    
  }

  close_connection($conn);
  header("Location: index.php?create_box");

} elseif (isset($_POST["boxIDArchive"])) {
  $boxID = $_POST["boxIDArchive"];
  $sql = "delete from boxes_{$_SESSION['user_id']} where BoxID='{$boxID}'";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  close_connection($conn);
  header("Location: archive.php?delete_box");
} elseif (isset($_POST["boxID"])) {
  $boxID = $_POST["boxID"];
  $sql = "update boxes_{$_SESSION['user_id']} set Valid=0 where BoxID='{$boxID}'";

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
    $box_data_input = $_POST['editNoteInput'];
    $sql = "update boxes_{$_SESSION['user_id']} set BoxData = '{$box_data_input}' where BoxID='{$boxID}'";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  if (isset($_POST["editDate"])) {
    $boxDate = $_POST["editDate"];
    $sql = "update boxes_{$_SESSION['user_id']} set BoxDate = '{$boxDate}' where BoxID='{$boxID}'";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  if (isset($_POST["editCategory"])) {
    $boxCategory = $_POST["editCategory"];
    $sql = "update boxes_{$_SESSION['user_id']} set BoxCategory = '{$boxCategory}' where BoxID='{$boxID}'";

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  if (isset($_POST["unsetDate"])) {
    $sql = "update boxes_{$_SESSION['user_id']} set BoxDate = NULL where BoxID='{$boxID}'";

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
  $user_id = $_SESSION["user_id"];
  $sql = "update boxes_{$user_id} set Valid = 1 where BoxID = '{$boxID}';";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  close_connection($conn);
  header("Location: archive.php?archive_restore");
}
close_connection($conn);
