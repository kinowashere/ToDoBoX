<?php

require_once 'vendor/autoload.php';
$conn = new mysqli($server_name, $server_username, $server_password, $db_name);

// If there is a category to be queried from

if (isset($_GET['category'])) {
  $category = $_GET['category'];
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT valid, box_data, box_date, box_id, box_category 
  FROM boxes_{$user_id} 
  WHERE box_category = '{$category}';";
}

// If we're looking for the Archive

elseif (isset($_GET['archive'])) {
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT valid, box_data, box_date, box_id, box_category 
  FROM boxes_{$user_id} 
  WHERE valid = 0;";
}

// If we're just looking for current ones
// No query (GET)

else {
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT valid, box_data, box_date, box_id, box_category 
  FROM boxes_{$user_id};";
}

$retval = mysqli_query($conn, $sql);
$boxesArray = array();
$counter = 0;

while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
  $boxesArray[$counter]['valid'] = $row['valid'];
  $boxesArray[$counter]['box_data'] = htmlspecialchars_decode($row['box_data'], ENT_QUOTES);
  $boxesArray[$counter]['box_date'] = $row['box_date'];
  $boxesArray[$counter]['box_id'] = $row['box_id'];
  $boxesArray[$counter]['box_category'] = htmlspecialchars_decode($row['box_category'], ENT_QUOTES);
  $counter++;
}

// Twig Engine

$loader = new Twig_Loader_Filesystem('lib/templates/views');
$twig = new Twig_Environment($loader);

if (isset($_GET['archive'])) {
  $views = 'archive_box_views.html';
} else {
  $views = 'current_box_views.html';
}

echo $twig->render(
  $views,
  array(
    'tasks' => $boxesArray
  )
);

$conn->close();
