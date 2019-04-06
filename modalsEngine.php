<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
require_once 'vendor/autoload.php';
require_once 'lib/csvToArray.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

//$userData = explode(",", file_get_contents("user.csv"));

echo $twig->render('modalsViews.html', array(
	"name" => $_SESSION['name'],
	"email" => $_SESSION['email'],
	"password" => $_SESSION['name']
));
