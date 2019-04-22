<?php

// Checks if user is logged in
// If not, redirect to login

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  die();
}

// Get data from POST

// If the user creates a new Box
if (isset($_POST['noteInput'])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $box_data_input = filter_var($_POST['noteInput'], FILTER_SANITIZE_STRING);
  $box_date_input = $_POST['date'];
  $box_category_input = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
  $user_id = $_SESSION['user_id'];
  
  // Creates the Box object
  $box = new Box($user_id, $conn);

  // Sets the content of the box
  $box -> box_set_data($box_data_input);

  // Set date if placed
  if($box_date_input != '') {
    $box -> box_set_date($box_date_input);
  }

  // Set category if placed
  if($box_category_input != '') {
    $box -> box_set_category($box_category_input);
  }
  unset($box);

  $conn -> close();
  header("Location: index.php?create_box");
  die();

}

// Delete a Box
elseif (isset($_POST["boxIDArchive"])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $box_id = $_POST["boxIDArchive"];
  $user_id = $_SESSION['user_id'];
  
  // Creates the Box object
  $box = new Box($user_id, $conn, $box_id);
  // Deletes the Box
  $box -> box_delete();
  unset($box);
  
  $conn -> close();
  header("Location: index.php?archive&delete_box");
  die();
} 

// Archive a Box
elseif (isset($_POST["boxID"])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $user_id = $_SESSION['user_id'];
  $box_id = $_POST["boxID"];

  // Creates the Box object
  $box = new Box($user_id, $conn, $box_id);
  // Deletes the Box
  $box -> box_archive();
  unset($box);

  $conn -> close();
  header("Location: index.php?archive_box");
  die();
} 

// Edit a Box
elseif (isset($_POST["boxIDEdit"])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $user_id = $_SESSION['user_id'];
  $box_id = $_POST["boxIDEdit"];

  // Creates the Box object
  $box = new Box($user_id, $conn, $box_id);

  //Edit Box content
  if ($_POST["editNoteInput"] != "") {
    $box_data_input = filter_var($_POST['editNoteInput'], FILTER_SANITIZE_STRING);
    $box -> box_set_data($box_data_input);
  }

  // Edit Box date
  if (isset($_POST["editDate"])) {
    $box_date_input = $_POST["editDate"];
    $box -> box_set_date($box_date_input);
  }

  // Edit Box category
  if (isset($_POST["editCategory"])) {
    $box_category_input = filter_var($_POST["editCategory"], FILTER_SANITIZE_STRING);
    $box -> box_set_category($box_category_input);
  }

  // Unset Box date
  if (isset($_POST["unsetDate"])) {
    $box -> box_unset_date(NULL);
  }

  unset($box);
  $conn -> close();
  header("Location: index.php?edited_note");
  die();

} 

// Restore an archived Box
elseif (isset($_POST["boxIDArchiveRestore"])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);
  
  $box_id = $_POST["boxIDArchiveRestore"];
  $user_id = $_SESSION["user_id"];

  // Creates the Box object
  $box = new Box($user_id, $conn, $box_id);

  // Restores the Box
  $box -> box_restore();

  unset($box);
  $conn -> close();
  header("Location: index.php?archive&archive_restore");
  die();
}
