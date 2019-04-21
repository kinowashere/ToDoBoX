<?php

require_once 'vendor/autoload.php';

if (isset($_POST)) {
  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);
  $sql = "SELECT contact.contact_name, contact.contact_email, contact.contact_message, 
  users.user_id, users.name, users.email, users.password_hash, users.recovery_code, users.is_admin
  FROM contact, users";
  $retval = mysqli_query($conn, $sql);
  $dataArray = array();
  $counter = 0;

  while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
    $dataArray[$counter]['contact_name'] = $row['contact_name'];
    $dataArray[$counter]['contact_email'] = $row['contact_email'];
    $dataArray[$counter]['contact_message'] = $row['contact_message'];

    $dataArray[$counter]['user_id'] = $row['user_id'];
    $dataArray[$counter]['name'] = $row['name'];
    $dataArray[$counter]['email'] = $row['email'];
    $dataArray[$counter]['recovery_code'] = $row['recovery_code'];
    $dataArray[$counter]['is_admin'] = $row['is_admin'];

    $counter++;
  }

  // Twig Engine
  $loader = new Twig_Loader_Filesystem("lib/templates/views");
  $twig = new Twig_Environment($loader);

  echo $twig->render(
    'admin_panel_views.html',
    array('data' => $dataArray)
  );

  echo ("wtf");

  $conn->close();
} else {
  header("location: index.php");
}
