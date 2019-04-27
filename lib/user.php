<?php
class User
{
  public $user_id;
  protected $conn;
  protected $user_boxes_table;
  protected $user_name;
  protected $user_email;
  protected $user_password;
  protected $user_photo;
  private $user_password_hash;
  private $user_recovery_code;
  private $user_is_admin;

  function __construct($general_conn, $session_user_id = NULL)
  {
    // If the user exists, set all the variables to the class
    if ($session_user_id != NULL) {
      $user_info = array();
      $this->user_id = $session_user_id;
      $this->conn = $general_conn;
      $this->user_boxes_table = 'boxes_' . $this->user_id;
      $sql = "SELECT name, email, profile_photo, recovery_code FROM users WHERE user_id = '{$this->user_id}'";
      $retval = mysqli_query($this->conn, $sql);
      $user_info = mysqli_fetch_array($retval, MYSQLI_ASSOC);
      $this->user_name = $user_info['name'];
      $this->user_email = $user_info['email'];
      $this->user_photo = $user_info['profile_photo'];
    } else {
      $this->conn = $general_conn;
      return true;
    }
  }

  // Generate random string
  function random_string($length)
  {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars), 0, $length);
  }

  // SQL Check
  public function sql_query($conn, $sql)
  {
    if ($conn->query($sql)) {
      return true;
    } else {
      return false;
    }
  }

  // Register user
  public function user_register($new_user_name, $new_user_email, $new_user_password_hash, $user_is_admin = 0)
  {

    if($new_user_name == '' or $new_user_email == '' or $new_user_password_hash == '') {
      return false;
    }

    $this->user_id = $this->random_string(50);
    $this->user_boxes_table = 'boxes_' . $this->user_id;
    $this->user_name = $new_user_name;
    $this->user_email = $new_user_email;
    $this->user_password_hash = $new_user_password_hash;
    $this->user_recovery_code = $this->random_string(6);
    $this->user_is_admin = $user_is_admin;
    $this->user_photo = 0;
    $sql = "INSERT INTO users (user_id, name, email, recovery_code, password_hash, profile_photo, is_admin) VALUES (?,?,?,?,?,?,?);";
    
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> bind_param("sssssii", $this->user_id, $this->user_name, $this->user_email, $this->user_recovery_code, $this->user_password_hash, $this->user_photo, $this->user_is_admin);
    $stmt -> execute();
    $stmt -> close();

    $sql = "CREATE TABLE {$this->user_boxes_table} 
    (box_id INT(11) NOT NULL AUTO_INCREMENT, valid INT(11), 
    box_data VARCHAR(255), box_category VARCHAR(255), 
    box_date DATE, PRIMARY KEY (box_id));";

    return $this->sql_query($this->conn, $sql);
  }

  // Get values from the class

  public function user_get_name()
  {
    return ($this->user_name);
  }
  public function user_get_email()
  {
    return ($this->user_email);
  }
  public function user_get_boxes_table()
  {
    return ($this->user_boxes_table);
  }
  public function user_get_photo()
  {
    return ($this->user_photo);
  }
  public function user_get_user_id()
  {
    return ($this->user_id);
  }

  // Functions to set values

  // Set newname
  public function user_set_name($new_user_name)
  {

    if($new_user_name == '') {
      return false;
    }

    $this->user_name = $new_user_name;
    $sql = "UPDATE users SET name = ? WHERE user_id = '{$this->user_id}';";
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> bind_param("s", $this->user_name);
    $stmt -> execute();
    $stmt -> close();
  }

  // Set new email
  public function user_set_email($new_user_email)
  {

    if($new_user_email == '') {
      return false;
    }

    $this->user_email = $new_user_email;
    $sql = "UPDATE users SET email = ? WHERE user_id = '{$this->user_id}';";
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> bind_param("s", $this->user_email);
    $stmt -> execute();
    $stmt -> close();
  }

  // Set new password
  public function user_set_password($new_user_password_hash)
  {

    if($new_user_password_hash == '') {
      return false;
    }

    $this->user_password = $new_user_password_hash;
    $sql = "UPDATE users SET password_hash = ? WHERE user_id = '{$this->user_id}';";
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> bind_param("s", $this->user_password);
    $stmt -> execute();
    $stmt -> close();
  }

  // Recover password
  public function user_recover_password()
  {
    $this->user_password = password_hash($this->random_string(8), PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password_hash = '{$this->user_password}' WHERE user_id = '{$this->user_id}';";
    return $this->sql_query($this->conn, $sql);
  }

  // Set new profile photo
  public function user_set_photo($new_user_photo)
  {

    if(!is_int($new_user_photo)) {
      return false;
    }

    $this->user_photo = $new_user_photo;
    $sql = "UPDATE users SET profile_photo = '{$this->user_photo}' WHERE user_id = '{$this->user_id}';";
    return $this->sql_query($this->conn, $sql);
  }

  // Set new recovery code
  public function user_set_recovery_code($new_user_recovery_code)
  {

    if($new_user_recovery_code == '') {
      return false;
    }

    $this->user_recovery_code = $new_user_recovery_code;
    $sql = "UPDATE users SET recovery_code = ? WHERE user_id = '{$this->user_id}';";
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> bind_param("s", $this->user_recovery_code);
    $stmt -> execute();
    $stmt -> close();
  }

  // Set new recovery code
  public function user_set_admin()
  {
    $sql = "UPDATE users SET is_admin = '1' WHERE user_id = '{$this->user_id}';";
    return $this->sql_query($this->conn, $sql);
  }

  // Delete account and box
  public function user_delete($user_id)
  {
    $sql = "DELETE FROM users WHERE user_id = '{$this->user_id}';";
    if ($this->sql_query($this->conn, $sql) == false) {
      return false;
    }
    $sql = "DROP TABLE boxes_{$this->user_id};";
    return $this->sql_query($this->conn, $sql);
  }

  // Send contact
  public function send_contact($contact_message)
  {

    if($contact_message == '') {
      return false;
    }

    $contact_id = $this->random_string(50);
    $sql = "INSERT INTO contact (contact_id, contact_name, contact_email, contact_message, user_id) VALUES (?, ?, ?, ?, ?);";
    $stmt = $this -> conn -> prepare($sql);
    $stmt -> bind_param("sssss", $contact_id, $this->user_name, $this->user_email, $contact_message, $this->user_id);
    $stmt -> execute();
    $stmt -> close();
  }
}
