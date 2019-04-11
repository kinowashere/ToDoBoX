<?php

require_once 'vendor/autoload.php';
$conn = open_connection();

$sql = "select Valid, BoxData, BoxDate, BoxID from boxes_{$_SESSION['userID']}";
$retval = mysqli_query($conn, $sql);

$boxesArray = array();
$counter = 0;
while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
	$boxesArray[$counter]["Valid"] = $row["Valid"];
	$boxesArray[$counter]["BoxData"] = $row["BoxData"];
	$boxesArray[$counter]["BoxDate"] = $row["BoxDate"];
	$boxesArray[$counter]["BoxID"] = $row["BoxID"];
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
?>