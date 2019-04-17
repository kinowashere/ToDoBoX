<?php

class Box extends User {

  protected $box_id;
  protected $box_content;

  function __construct($session_user_id, $general_conn, $box_id) {

    // Construct User parent Class
    parent::__construct($session_user_id, $general_conn);

    // Check if the Box Exists
    $sql = "select ";
  }

  public function box_delete() {

  }

  public function box_archive() {

  }

  public function echo_smth() {
    echo($this -> get_user_name());
    echo($this -> user_name);
  }
}

$servername = "localhost";
$username = "testroot";
$password = "";
$dbname = "todoDB";
$conn = new mysqli($servername, $username, $password, $dbname);

$box = new Box('xq5XA3NioJeFBldHWDRPyMjVz96sLKkY0QpZvO8T2mruw7hGac', $conn,'a');
$conn -> close();

?>