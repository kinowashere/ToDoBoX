<?php

require_once 'vendor/autoload.php';
require_once 'lib/csvToArray.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$userData = explode(",",file_get_contents("user.csv"));

echo $twig->render('modalsViews.html', array(
  "name" => $userData[0],
  "email" => $userData[1],
  "password" => $userData[2]
));

?>