<?php

require_once 'vendor/autoload.php';

// Twig Engine
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

echo $twig->render('headerViews.html');

?>