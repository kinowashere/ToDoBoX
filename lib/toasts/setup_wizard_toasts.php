  <?php
  require "toast_engine.php";

  if (isset($_GET["database_exists"])) {
    // Can't install because database already exists.
    toaster("Database already existes");
  } elseif (isset($_GET["wrong_captcha"])) {
    // Can't login because captha was wrong
    toaster("Wrong captcha!");
  }
  ?>