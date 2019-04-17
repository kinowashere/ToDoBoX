  <?php
  require "toastEngine.php";

  if (isset($_GET["login_incorrect"])) {
    // Can't login because email or password was incorrect
    toaster("Wrong email or password!");
  } elseif (isset($_GET["register_email_exists"])) {
    // Email wasn't set because it already exists (update to hmtl5 or jquery)
    toaster("Email already exists!");
  } elseif (isset($_GET["wrong_captcha"])) {
    // Can't login because email or password was incorrect
    toaster("Wrong captcha!");
  }
  ?>