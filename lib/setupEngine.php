<?php
if (isset($_POST['install'])) {
  $conn = new mysqli();

  // create a php file to write. overwrites when it already exists.
  $myfile = fopen("lib/SQLdata.php", "w") or die("Unable to open file!");
  $data = '
  <?php
  $server_name = \'{$_POST[\'server_name\']}\';
  $server_username = \'{$_POST[\'server_username\']}\';
  $server_password = \'{$_POST[\'server_password\']}\';
  $dbname = \'todoDB\';
  ?>';
  // writes $data in $myfile
  $myfile = fwrite($myfile, $data);

  close_connection($conn);
  header("Location: setup_wizard.php?done");
}
