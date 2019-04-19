<?php

require_once 'vendor/autoload.php';
$conn = open_connection();

$sql = "SELECT valid, box_data, box_date, box_id, box_category FROM boxes_{$_SESSION['user_id']}";
$retval = mysqli_query($conn, $sql);

$boxesArray = array();
$counter = 0;
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
	$boxesArray[$counter]["valid"] = $row["valid"];
	$boxesArray[$counter]["box_data"] = $row["box_data"];
	$boxesArray[$counter]["box_date"] = $row["box_date"];
	$boxesArray[$counter]["box_id"] = $row["box_id"];
	$boxesArray[$counter]["box_category"] = $row["box_category"];
	$counter++;
}

// Twig Engine
$loader = new Twig_Loader_Filesystem('lib/templates/views');
$twig = new Twig_Environment($loader);

echo $twig->render('archiveBoxViews.html',array(
	'tasks' => $boxesArray
)
);

close_connection($conn);
