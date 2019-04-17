<?php

class User {
  public $user_id;
  protected $conn;
  protected $user_table;
  protected $user_name;
  protected $user_email;
  protected $user_photo;

  function __construct($session_user_id, $general_conn) {
    $user_info = array();
    $this -> user_id = $session_user_id;
    $this -> conn = $general_conn;
    $this -> user_table = 'boxes_'.$this -> user_id;
    $sql = "SELECT name, email, profile_photo, recovery_code FROM users WHERE userID = '{$this -> user_id}'";
    $retval = mysqli_query($this -> conn, $sql);
    $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);
    $this -> user_name = $user_info['name'];
    $this -> user_email = $user_info['email'];
    $this -> user_photo = $user_info['profile_photo'];
  }

  // Get values

  public function get_user_name() {
    return($this -> user_name);
  }
  public function get_user_email() {
    return($this -> user_email);
  }
  public function get_user_table() {
    return($this -> user_table);
  }
  public function get_user_photo() {
    return($this -> user_photo);
  }

  // Set values

  // Sets the user name
  public function set_user_name($new_user_name) {
    $this -> user_name = $new_user_name;
    $sql = "UPDATE users SET name = '{$this -> user_name}' WHERE userID = '{$this -> user_id}';";
    if($this -> conn -> query($sql)) {
      return true;
    } else {
      return false;
    }
  }

  
  public function set_user_email($new_user_email) {
    $this -> user_email = $new_user_email;
    $sql = "UPDATE users SET email = '{$this -> user_email}' WHERE userID = '{$this -> user_id}';";
    if($this -> conn -> query($sql)) {
      return true;
    } else {
      return false;
    }
  }

  public function set_user_photo($new_user_photo) {
    $this -> user_photo = $new_user_photo;
    $sql = "UPDATE users SET profile_photo = '{$this -> user_photo}' WHERE userID = '{$this -> user_id}';";
    if($this -> conn -> query($sql)) {
      return true;
    } else {
      return false;
    }
  }
}

?>