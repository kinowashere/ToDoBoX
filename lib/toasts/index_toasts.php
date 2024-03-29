  <?php
  require "toast_engine.php";

  if (isset($_GET["email_success"])) {
    // Sent an email
    toaster("Thank you for your woof! ▼・ᴥ・▼");
  } elseif (isset($_GET["archive_box"])) {
    // Archived box
    toaster("Box archived!");
  } elseif (isset($_GET["update_name"])) {
    // Updated display name
    toaster("Name updated!");
  } elseif (isset($_GET["empty_name"])) {
    // Name is not updated because it is empty (for IE)
    toaster("Name was not set because it is empty!");
  } elseif (isset($_GET["update_email"])) {
    // Email is updated
    toaster("Email updated.");
  } elseif (isset($_GET["empty_email"])) {
    // Email form was empty (for IE)
    toaster("Email was not set because it is empty.");
  } elseif (isset($_GET["email_already_exists"])) {
    // Email form was empty (for IE)
    toaster("Email was not set because it already exists.");
  } elseif (isset($_GET["password_too_short"])) {
    // Password wasn't changed because it's too short (for IE)
    toaster("Password was not set because it is too short!");
  } elseif (isset($_GET["different_passwords"])) {
    // Passwords don't match (change later to html5!!!)
    toaster("Password was not set because it does not match!");
  } elseif (isset($_GET["updated_password"])) {
    // password has been updated
    toaster("Password updated!");
  } elseif (isset($_GET["incorrect_password_delete"])) {
    // Couldn't delete account because the password was incorrect (change later to html5!!!)
    toaster("Could not delete because password is incorrect!");
  } elseif (isset($_GET["incorrect_password_admin"])) {
    // Couldn't delete account because the password was incorrect (change later to html5!!!)
    toaster("Could not access because password is incorrect");
  } elseif (isset($_GET["edited_note"])) {
    // Note has been edited
    toaster("Note edited!");
  } elseif (isset($_GET["archive_restore"])) {
    // Note has been restored from the archive
    toaster("Box restored!");
  } elseif (isset($_GET["delete_box"])) {
    // Box has been deleted from database
    toaster("Box deleted!");
  } elseif (isset($_GET["not_an_admin"])) {
    // Regular user tried to access admin tools
    toaster("You\'re not an admin! >:(");
  } elseif (isset($_GET["new_profile_photo"])) {
    // New profile photo is set
    toaster("Updated your profile photo!");
  }
  ?>