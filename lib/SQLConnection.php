<?php

function open_connection() {
  /*
  $servername = "anysql.itcollege.ee";
  $username = "team1";
  $password = "Sk.00K7b4FY";
  $dbname = "WT_1";
  */
  $servername = "localhost";
  $username = "testroot";
  $password = "";
  $dbname = "todoDB";
  $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  return $conn;
}

function close_connection($conn) {
  $conn->close();
}
?>