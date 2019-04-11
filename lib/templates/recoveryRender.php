<?php

require_once 'vendor/autoload.php';

if(isset($_SESSION["recovery_active"]) and $_SESSION["recovery_active"] == 1) {
  $conn = open_connection();
  $userID = $_SESSION["userID"];
  $sql = "select recovery_code from users where userID = '{$userID}'";
  $retval = mysqli_query($conn, $sql);
  $userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);
  $_SESSION["recovery_active"] = 0;
  close_connection($conn);
  
  // Twig Engine
  $loader = new Twig_Loader_Filesystem("lib/templates/views");
  $twig = new Twig_Environment($loader);

  echo $twig->render("recoveryViews.html",$userInfo);

} else {
  header("location: index.php");
}
?>