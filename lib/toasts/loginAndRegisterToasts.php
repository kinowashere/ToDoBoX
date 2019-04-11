  <?php
  if (isset($_GET["login_incorrect"])) {
    // Can't login because email or password was incorrect
    $javascript = '<script> M.toast({html: \'Wrong email or password.\'}); </script>';
  }
  elseif (isset($_GET["register_email_exists"])) {
    // Email wasn't set because it already exists (update to hmtl5 or jquery)
    $javascript = '<script> M.toast({html: \'Email already exists.\'}); </script>';
  }
  if(isset($javascript)) {
    echo($javascript);
  }
  ?>