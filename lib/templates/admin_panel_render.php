<?php

require_once 'vendor/autoload.php';

if (isset($_POST)) {
  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  // Twig Engine
  $loader = new Twig_Loader_Filesystem("lib/templates/views");
  $twig = new Twig_Environment($loader);

  echo $twig->render("adminPanelViews.html", $userInfo);
  echo("wtf");

  $conn->close();
} else {
  header("location: index.php");
}

if (isset($_POST['view'])) {

  $conn = new mysqli($server_name, $server_username, $server_password, $db_name);

  $retval = mysqli_query($conn, $sql);
  $userArray = array();
  $counter = 0;

  while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
    $userArray[$counter]['user_id'] = $row['user_id'];
    $userArray[$counter]['name'] = $row['name'];
    $userArray[$counter]['email'] = $row['email'];
    $userArray[$counter]['recovery_code'] = $row['recovery_code'];
    $userArray[$counter]['is_admin'] = $row['is_admin'];
    $counter++;
  }

  // Twig Engine
  $loader = new Twig_Loader_Filesystem('lib/templates/views');
  $twig = new Twig_Environment($loader);

  echo $twig->render(
    'user_views.html',
    array('users' => $userArray)
  );

  $conn->close();
}
