<?php

require_once 'vendor/autoload.php';

$conn = new mysqli($server_name, $server_username, $server_password, $db_name);
$sql = "SELECT user_id, contact_id, contact_name, contact_email, contact_message, valid FROM contact";
$retval = mysqli_query($conn, $sql);
$contact_array = array();
$counter = 0;

while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
  $contact_array[$counter]['user_id'] = $row['user_id'];
  $contact_array[$counter]['contact_id'] = $row['contact_id'];
  $contact_array[$counter]['contact_name'] = $row['contact_name'];
  $contact_array[$counter]['contact_email'] = $row['contact_email'];
  $contact_array[$counter]['contact_message'] = $row['contact_message'];
  $contact_array[$counter]['valid'] = $row['valid'];

  $counter++;
}

$sql = "SELECT user_id, name, email, password_hash, recovery_code, is_admin FROM users";
$retval = mysqli_query($conn, $sql);
$users_array = array();
$counter = 0;

while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
  $users_array[$counter]['user_id'] = $row['user_id'];
  $users_array[$counter]['name'] = $row['name'];
  $users_array[$counter]['email'] = $row['email'];
  $users_array[$counter]['recovery_code'] = $row['recovery_code'];
  $users_array[$counter]['is_admin'] = $row['is_admin'];

  $counter++;
}

// Twig Engine
$loader = new Twig_Loader_Filesystem("lib/templates/views");
$twig = new Twig_Environment($loader);

echo $twig->render(
  'admin_panel_views.html',
  array(
    'contact' => $contact_array,
    'users' => $users_array
  )
);

$conn->close();
