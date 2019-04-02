<?php

require_once 'vendor/autoload.php';
require_once 'lib/csvToArray.php';

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
$boxes = csv_to_array('list.csv');

echo $twig->render('boxViews.html',array(
  'tasks' => $boxes
  )
);

?>