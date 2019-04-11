  <?php
  require "toastEngine.php";

  if (isset($_GET["delete_box"])) {
    // Box has been deleted from database
    toaster("Box deleted!");
  }
  elseif (isset($_GET["archive_restore"])) {
    // Note has been restored from the archive
    toaster("Box restored!");
  }
  ?>