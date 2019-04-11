<?php

require_once 'vendor/autoload.php';
$conn = open_connection();

// Retrieve SQL User Info

$userID = $_SESSION["userID"];
$userInfo = array();
$sql = "select userID, name, email, profile_photo from users where userID = '{$userID}'";
$retval = mysqli_query($conn, $sql);
echo($conn->error);
$userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

// Check how many Shibas are there

$dir = "img/shibas";
$shibas_temp = scandir($dir);
$shibas_array = array();
$counter = 0;
foreach ($shibas_temp as $file) {
  if(strpos($file,"jpg") == true) {
    $shibas_array[$counter] = $counter.".jpg";
    $counter++;
  }
}

// Twig

$loader = new Twig_Loader_Filesystem('lib/templates/views');
$twig = new Twig_Environment($loader);

echo $twig->render('modalsViews.html', array(
	"userID" => $_SESSION["userID"],
	"name" => $userInfo['name'],
	"email" => $userInfo['email'],
	"profile_photo" => $userInfo['profile_photo'],
  "shibas" => $shibas_array
));

close_connection($conn);
