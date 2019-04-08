<?php

require_once 'vendor/autoload.php';
require "lib/openConnection.php";

// Retrieve SQL User Info

$userID = $_SESSION["userID"];
$userInfo = array();
$sql = "select userID, name, email, profile_photo from users where userID = '{$userID}'";
$retval = mysqli_query($conn, $sql);
echo($conn->error);
$userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

// Twig

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

echo $twig->render('modalsViews.html', array(
	"userID" => $_SESSION["userID"],
	"name" => $userInfo['name'],
	"email" => $userInfo['email'],
	"profile_photo" => $userInfo['profile_photo'],
));

/*
$shibaArray = array();
for ($i = 0; $i < 24; $i++) {
	$shibaArray[$i]["Number"] = $i;
}

echo $twig->render(
	'shibaViews.html',
	array(
		'shibas' => $shibaArray
	)
);
*/

$conn->close();
