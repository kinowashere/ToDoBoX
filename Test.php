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

$user = new User($conn);
$user -> user_register('Pablo', 'pabels@pabels', '12345678');
echo($user -> user_get_name());

$conn -> close();

?>

</html>