  <?php
  // GET

  if(isset($_GET["email_success"])) {
    $javascript = '<script> M.toast({html: \'Email sent!\'}); </script>';
    echo($javascript);
  }
  ?>