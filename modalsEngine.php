<?php

require_once 'vendor/autoload.php';
require "lib/openConnection.php";

// Retrieve SQL User Info

$userID = $_SESSION["userID"];
$userInfo = array();
$sql = "select userID, name, email from users where userID = '{$userID}'";
$retval = mysqli_query($conn, $sql);
$userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

// Twig

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

echo $twig->render('modalsViews.html', array(
  "userID" => $_SESSION["userID"],
	"name" => $userInfo['name'],
	"email" => $userInfo['email'],
	"password" => $userInfo['name']
));

$conn->close();

?>