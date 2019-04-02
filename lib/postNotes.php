<?php

if ($_POST) {
  $noteInput = $_POST['noteInput'];
  $date = $_POST['date'];
  $data = array("1", $date, $noteInput);

  $f = fopen("./list.csv", "a");
  if ($f) {
    fputcsv($f, $data);
  }
  fclose($f);
}
