<?php

if ($_POST) {
  $noteInput = $_POST['noteInput'];
  $date = $_POST['date'];
  $data = array("1", $date, $noteInput);
  echo ($noteInput);
  echo ($date);

  $f = fopen("list.csv", "a");
  if ($f) {
    fputcsv($f, $data);
  } else {
    echo ("nofile");
  }
  flose($f);
}
