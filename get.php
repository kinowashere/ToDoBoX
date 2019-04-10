  <?php
  // GET

  if (isset($_GET["email_success"])) {
    $javascript = '<script> M.toast({html: \'Thank you for your woof! ▼・ᴥ・▼\'}); </script>';
  } 
  elseif (isset($_GET["delete_box"])) {
    $javascript = '<script> M.toast({html: \'Box deleted!\'}); </script>';
  } 
  elseif (isset($_GET["archive_box"])) {
    $javascript = '<script> M.toast({html: \'Box archived!\'}); </script>';
  }
  elseif (isset($_GET["update_name"])) {
    $javascript = '<script> M.toast({html: \'Name updated!\'}); </script>';
  }
  elseif (isset($_GET["empty_name"])) {
    $javascript = '<script> M.toast({html: \'Name was not set because it is empty\'}); </script>';
  }
  elseif (isset($_GET["update_email"])) {
    $javascript = '<script> M.toast({html: \'Email updated!\'}); </script>';
  }
  elseif (isset($_GET["empty_email"])) {
    $javascript = '<script> M.toast({html: \'Email was not set because it is empty\'}); </script>';
  }
  elseif (isset($_GET["password_too_short"])) {
    $javascript = '<script> M.toast({html: \'Password was not set because it is too short\'}); </script>';
  }
  elseif (isset($_GET["different_passwords"])) {
    $javascript = '<script> M.toast({html: \'Password was not set because they do not match!\'}); </script>';
  }
  elseif (isset($_GET["updated_password"])) {
    $javascript = '<script> M.toast({html: \'Password updated!\'}); </script>';
  }
  elseif (isset($_GET["incorrect_password_delete"])) {
    $javascript = '<script> M.toast({html: \'Could not delete because password is incorrect!\'}); </script>';
  }
  elseif (isset($_GET["login_incorrect"])) {
    $javascript = '<script> M.toast({html: \'Wrong email or password.\'}); </script>';
  }
  elseif (isset($_GET["register_email_exists"])) {
    $javascript = '<script> M.toast({html: \'Email already exists.\'}); </script>';
  }
  elseif (isset($_GET["edited_note"])) {
    $javascript = '<script> M.toast({html: \'Note edited.\'}); </script>';
  }
  if(isset($javascript)) {
    echo($javascript);
  }
  ?>