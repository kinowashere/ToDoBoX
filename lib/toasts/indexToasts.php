  <?php

  if (isset($_GET["email_success"])) {
    // Sent an email
    $javascript = '<script> M.toast({html: \'Thank you for your woof! ▼・ᴥ・▼\'}); </script>';
  }
  elseif (isset($_GET["archive_box"])) {
    // Archived box
    $javascript = '<script> M.toast({html: \'Box archived!\'}); </script>';
  }
  elseif (isset($_GET["update_name"])) {
    // Updated display name
    $javascript = '<script> M.toast({html: \'Name updated!\'}); </script>';
  }
  elseif (isset($_GET["empty_name"])) {
    // Name is not updated because it is empty (for IE)
    $javascript = '<script> M.toast({html: \'Name was not set because it is empty\'}); </script>';
  }
  elseif (isset($_GET["update_email"])) {
    // Email is updated
    $javascript = '<script> M.toast({html: \'Email updated!\'}); </script>';
  }
  elseif (isset($_GET["empty_email"])) {
    // Email form was empty (for IE)
    $javascript = '<script> M.toast({html: \'Email was not set because it is empty\'}); </script>';
  }
  elseif (isset($_GET["password_too_short"])) {
    // Password wasn't changed because it's too short (for IE)
    $javascript = '<script> M.toast({html: \'Password was not set because it is too short\'}); </script>';
  }
  elseif (isset($_GET["different_passwords"])) {
    // Passwords don't match (change later to html5!!!)
    $javascript = '<script> M.toast({html: \'Password was not set because they do not match!\'}); </script>';
  }
  elseif (isset($_GET["updated_password"])) {
    // password has been updated
    $javascript = '<script> M.toast({html: \'Password updated!\'}); </script>';
  }
  elseif (isset($_GET["incorrect_password_delete"])) {
    // Couldn't delete account because the password was incorrect (change later to html5!!!)
    $javascript = '<script> M.toast({html: \'Could not delete because password is incorrect!\'}); </script>';
  }
  elseif (isset($_GET["edited_note"])) {
    // Note has been edited
    $javascript = '<script> M.toast({html: \'Note edited.\'}); </script>';
  }
  if(isset($javascript)) {
    echo($javascript);
  }
  ?>