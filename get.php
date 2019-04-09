  <?php
  // GET

  if(isset($_GET["email_success"])) {
    $javascript = '<script> M.toast({html: \'Thank you for your woof! ▼・ᴥ・▼\'}); </script>';
    echo($javascript);
  }
  ?>