<?php

class Box extends User {

  protected $box_id;
  protected $box_valid;
  protected $box_data;
  protected $box_category;
  protected $box_date;

  function __construct($session_user_id, $general_conn, $box_id = NULL) {

    // Construct User parent Class
    parent::__construct($session_user_id, $general_conn);

    // If the Box doesn't exist, create it
    if($box_id == NULL) {
      $sql = "INSERT INTO {$this -> user_boxes_table} (valid) VALUES (1);";
      if($this -> conn -> query($sql)) {
        $this -> box_id = $this -> conn -> insert_id;
        return true;
      } else {
        return false;
      }
    // Else if the Box exists, set the values to the class variables
    } else {
      $sql = "SELECT valid, box_data, box_category, box_date FROM {$this -> user_boxes_table};";
      $retval = mysqli_query($this -> conn, $sql);
      $box_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);
      $this -> box_id = $box_id;
      $this -> box_valid = $box_info['valid'];
      $this -> box_data = $box_info['box_data'];
      $this -> box_category = $box_info['box_category'];
      $this -> box_date = $box_info['box_date'];
    }
  }

  // Deletes the box
  public function box_delete() {
    $sql = "DELETE FROM {$this -> user_boxes_table} WHERE box_id = {$this -> box_id};";
    return $this -> sql_query($this -> conn, $sql);
  }

  // Archive the box
  public function box_archive() {
    $sql = "UPDATE {$this -> user_boxes_table} SET valid = 0 WHERE box_id = {$this -> box_id};";
    return $this -> sql_query($this -> conn, $sql);
  }

  public function box_restore() {
    $sql = "UPDATE {$this -> user_boxes_table} SET valid = 1 WHERE box_id = {$this -> box_id};";
    return $this -> sql_query($this -> conn, $sql);
  }

  // Set especific values for the boxes
  public function box_set_data($new_box_data) {
    $sql = "UPDATE {$this -> user_boxes_table} SET box_data = '{$new_box_data}' WHERE box_id = {$this -> box_id};";
    return $this -> sql_query($this -> conn, $sql);
  }

  public function box_set_category($new_box_category) {
    $sql = "UPDATE {$this -> user_boxes_table} SET box_category = '{$new_box_category}' WHERE box_id = {$this -> box_id};";
    return $this -> sql_query($this -> conn, $sql);
  }

  public function box_set_date($new_box_date) {
    $sql = "UPDATE {$this -> user_boxes_table} SET box_date = '{$new_box_date}' WHERE box_id = {$this -> box_id};";
    return $this -> sql_query($this -> conn, $sql);
  }
}

$servername = "localhost";
$username = "testroot";
$password = "";
$dbname = "todoDB";
$conn = new mysqli($servername, $username, $password, $dbname);

$user = new User($conn);
$user -> user_register('1234abcd', 'Manueru Desu', 'abc@abc', '12345678', '09876543');
echo($user -> user_get_name());

$conn -> close();

?>