<?php

require "lib/openConnection.php";

if (isset($_POST["name"])) {
  $name = $_POST["name"];
  echo $name;

  /*
  NOT DONE YET
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
    $sql = "INSERT INTO users (userID, name, email, password_hash) VALUES ('$userID', '$name', '$email', '$password_hash')";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql = "CREATE TABLE boxes_{$userID} (Valid INT, BoxID VARCHAR(255), BoxData VARCHAR(255), BoxDate date);";
    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    echo ("New account created!");
    */
} else {
  echo "fail";
}

$conn->close();
