<!DOCTYPE html>
<html>

<head>
  <title>ToDoBoX</title>
  <?php
  require "lib/templates/header_render.php";
  ?>
</head>

<body>
  <?php
  require "lib/open_session.php";
  if($_SESSION["is_admin"] == 0) {
    header('Location: index.php?not_an_admin');
    die();
  }
  require "lib/sql_data.php";
  //Classes
  require 'lib/user.php';
  require 'lib/box.php';
  //Get POST Data
  require 'lib/admin.php';
  require_once "lib/change_user_data.php";
  // Render website
  require_once 'lib/templates/modals_render.php';
  require_once 'lib/templates/admin_panel_render.php';
  ?>

  <!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
  <?php
  require "lib/toasts/index_toasts.php";
  ?>
</body>

</html>