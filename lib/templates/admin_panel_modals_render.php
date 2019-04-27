<?php

require_once 'vendor/autoload.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  die();
}

$conn = new mysqli($server_name, $server_username, $server_password, $db_name);

// Retrieve SQL User Info

$user_id = $_SESSION["user_id"];
$user_info = array();
$sql = "SELECT user_id, name, email, profile_photo, is_admin FROM users WHERE user_id = '{$user_id}'";
$retval = mysqli_query($conn, $sql);
echo ($conn->error);
$user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);

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

echo $twig->render('modals_views.html', array(
  "user_id" => $_SESSION["user_id"],
  "name" => htmlspecialchars_decode($user_info['name'], ENT_QUOTES),
  "email" => $user_info['email'],
  "profile_photo" => $user_info['profile_photo'],
  'is_admin' => $user_info['is_admin'],
  "shibas" => $shibas_array,
  'categories' => htmlspecialchars_decode($categories_array, ENT_QUOTES),
  'admin_privilege' => $_SESSION['admin_privilege']
));

$conn->close();
