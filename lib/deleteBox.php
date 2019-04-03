<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todoDB";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "select Valid, BoxData, BoxDate, BoxID from boxes";
$retval = mysqli_query($conn, $sql);

?>