<?php
require "lib/openConnection.php";

$sql = "select Valid, BoxData, BoxDate, BoxID from boxes";
$retval = mysqli_query($conn, $sql);

?>