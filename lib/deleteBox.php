<?php
require "lib/openConnection.php";

$sql = "select Valid, BoxData, BoxDate, BoxID from boxes_{$_SESSION['user_id']}";
$retval = mysqli_query($conn, $sql);
