<?php

class Box extends User
{

  protected $box_id;
  protected $box_valid;
  protected $box_data;
  protected $box_category;
  protected $box_date;

  function __construct($session_user_id, $general_conn, $box_id = NULL)
  {

    // Construct User parent Class
    parent::__construct($general_conn, $session_user_id);

    // If the Box doesn't exist, create it
    if ($box_id == NULL) {
      $sql = "INSERT INTO boxes (user_id, valid) VALUES ('{$session_user_id}', 1);";
      if ($this->conn->query($sql)) {
        $this->box_id = $this->conn->insert_id;
        return true;
      } else {
        return false;
      }
      // Else if the Box exists, set the values to the class variables
    } else {
      $sql = "SELECT valid, box_data, box_category, box_date FROM boxes WHERE user_id = '{$this -> user_id}';";
      $retval = mysqli_query($this->conn, $sql);
      $box_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);
      $this->box_id = $box_id;
      $this->box_valid = $box_info['valid'];
      $this->box_data = $box_info['box_data'];
      $this->box_category = $box_info['box_category'];
      $this->box_date = $box_info['box_date'];
    }
  }

  // Deletes the box
  public function box_delete()
  {
    $sql = "DELETE FROM boxes WHERE user_id = '{$this -> user_id}' AND box_id = {$this->box_id};";
    return $this->sql_query($this->conn, $sql);
  }

  // Archive the box
  public function box_archive()
  {
    $sql = "UPDATE boxes SET valid = 0 WHERE user_id = '{$this -> user_id}' AND box_id = {$this->box_id};";
    return $this->sql_query($this->conn, $sql);
  }

  // Restore an archived Box
  public function box_restore()
  {
    $sql = "UPDATE boxes SET valid = 1 WHERE user_id = '{$this -> user_id}' AND box_id = {$this->box_id};";
    return $this->sql_query($this->conn, $sql);
  }

  // Set especific values for the boxes
  
  public function box_set_data($new_box_data)
  {
    $sql = "UPDATE boxes SET box_data = ? WHERE user_id = '{$this -> user_id}' AND box_id = {$this->box_id};";
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> bind_param("s", $new_box_data);
    $stmt -> execute();
    $stmt -> close();
  }

  public function box_set_category($new_box_category)
  {
    $sql = "UPDATE boxes SET box_category = ? WHERE user_id = '{$this -> user_id}' AND box_id = {$this->box_id};";
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> bind_param("s", $new_box_category);
    $stmt -> execute();
    $stmt -> close();
  }

  public function box_set_date($new_box_date)
  {
    $sql = "UPDATE boxes SET box_date = ? WHERE user_id = '{$this -> user_id}' AND box_id = {$this->box_id};";
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> bind_param("s", $new_box_date);
    $stmt -> execute();
    $stmt -> close();
  }
  public function box_unset_date()
  {
    $sql = "UPDATE boxes SET box_date = NULL WHERE user_id = '{$this -> user_id}' AND box_id = {$this->box_id};";
    return $this->sql_query($this->conn, $sql);
  }
}