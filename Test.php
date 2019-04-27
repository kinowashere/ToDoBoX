<!DOCTYPE html>
<html>

<head>
  <title>Test</title>
</head>

<body>
  <?php
  require 'lib/sql_data.php';
  require 'lib/user.php';
  require 'lib/box.php';
  // Add testing stuff here
  ?>
</body>
<?php

$conn = new mysqli($server_name, $server_username, $server_password, $db_name);

$box = new Box('r4yvqNkSVKQRiP8oeasXWlx5BpJb2GzL3Fw7YZC6HUIMOjfgnh', $conn, 64);
$box->box_set_data("Henlo madafak");
$box->box_set_category("Tutorial.com");
unset($box);

$conn -> close();

?>

</html>