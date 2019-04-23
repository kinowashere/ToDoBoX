<!DOCTYPE html>
<html>

<head>
  <title>ToDoBoX</title>
  <?php
  require "lib/templates/header_render.php";
  ?>
</head>

<body>
  <div class="container">
    <div class="row center">
      <div class="col s12 m6 offset-m3">
        <div class="deleted_container z-depth-1">
          <div class="btn-floating shiba_deleted">
          </div>
          <h3 style="font-weight: bold;">ToDoBoX</h3>
          <br>
          <h5>Account deleted</h5>
          <h5>
            Aroof woo woof woo!
            <br>
            <small>(You're always welcome)</small>
          </h5>
        </div>
      </div>
    </div>
  </div>
  <script>
    mnt = 3; // 3 seconds to redirect
    url = "login.php";

    function jumpPage() {
      location.href = url;
    }
    setTimeout("jumpPage()", mnt * 1000)
  </script>
</body>

</html>