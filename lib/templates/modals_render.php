<?php

require_once 'vendor/autoload.php';
$conn = new mysqli($server_name, $server_username, $server_password, $db_name);

// Retrieve SQL User Info

$user_id = $_SESSION["user_id"];
$userInfo = array();
$sql = "SELECT user_id, name, email, profile_photo, is_admin FROM users WHERE user_id = '{$user_id}'";
$retval = mysqli_query($conn, $sql);
echo ($conn->error);
$userInfo = mysqli_fetch_array($retval, MYSQLI_ASSOC);

// Check how many Shibas are there

$dir = "img/shibas";
$shibas_temp = scandir($dir);
$shibas_array = array();
$counter = 0;
foreach ($shibas_temp as $file) {
  if (strpos($file, "jpg") == true) {
    $shibas_array[$counter] = $counter . ".jpg";
    $counter++;
  }
}

// Retrieve categories

$sql = "SELECT DISTINCT box_category FROM boxes_{$user_id}";
$retval = mysqli_query($conn, $sql);

$categories_array = array();
$counter = 0;
while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
  if ($row['box_category'] != "") {
    $categories_array[$counter] = $row['box_category'];
  }
  $counter++;
}

// Twig

$loader = new Twig_Loader_Filesystem('lib/templates/views');
$twig = new Twig_Environment($loader);
if ($userInfo['is_admin'] == 1) {
  echo $twig->render('adminModalsViews.html', array(
    "user_id" => $_SESSION["user_id"],
    "name" => $userInfo['name'],
    "email" => $userInfo['email'],
    "profile_photo" => $userInfo['profile_photo'],
    "shibas" => $shibas_array,
    'categories' => $categories_array
  ));
} else {
  echo $twig->render('modalsViews.html', array(
    "user_id" => $_SESSION["user_id"],
    "name" => $userInfo['name'],
    "email" => $userInfo['email'],
    "profile_photo" => $userInfo['profile_photo'],
    "shibas" => $shibas_array,
    'categories' => $categories_array
  ));
}



$conn->close();
