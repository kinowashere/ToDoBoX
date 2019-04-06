<?php
require "lib/openConnection.php";

$sql = "select Valid, BoxData, BoxDate, BoxID from boxes_{$_SESSION['userID']}";
$retval = mysqli_query($conn, $sql);
