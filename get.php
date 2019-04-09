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
    $javascript = '<script> M.toast({html: \'Passwords were not set because they are the same!\'}); </script>';
  }
  elseif (isset($_GET["updated_password"])) {
    $javascript = '<script> M.toast({html: \'Password updated!\'}); </script>';
  }
  elseif (isset($_GET["incorrect_password_delete"])) {
    $javascript = '<script> M.toast({html: \'Could not delete because password is incorrect!\'}); </script>';
  }

  if(isset($javascript)) {
    echo($javascript);
  }
  ?>