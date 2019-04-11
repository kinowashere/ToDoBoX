  <?php
  if (isset($_GET["delete_box"])) {
    $javascript = '<script> M.toast({html: \'Box deleted!\'}); </script>';
  }
  elseif (isset($_GET["archive_restore"])) {
    // Note has been restored from the archive
    $javascript = '<script> M.toast({html: \'Note restored.\'}); </script>';
  }
  if(isset($javascript)) {
    echo($javascript);
  }
  ?>