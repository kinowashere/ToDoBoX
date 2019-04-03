<?php
require_once 'vendor/autoload.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "todoDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "select Valid, BoxData, BoxDate, BoxID from boxes";
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
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

echo $twig->render('boxViews.html',array(
	'tasks' => $boxesArray
)
);

$conn->close();

?>