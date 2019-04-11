<!DOCTYPE html>
<html>
<head>
  <title>ToDoBoX</title>
  <?php
  require "lib/templates/headerRender.php";
  ?>
</head>
<body>
  <?php
  require "lib/SQLConnection.php";
  ?>
  <div class="container">
    <div class="row center">
      <div class="col s12 m8 offset-m2">
        <div class="loginContainer z-depth-1">
          <h3>ToDoBoX</h3>
          <form action="recoverPassword.php" method="post">
            <div class="row blue-text text-darken-2">
              <div class="input-field col s8 offset-s2">
                <i class="material-icons prefix">mail</i>
                <input type="text" name="email" id="email" class="validate" required>
                <label for="email">Email</label>
              </div>
              <div class="input-field col s8 offset-s2">
                <i class="material-icons prefix">vpn_key</i>
                <input type="text" name="recovery_code" id="recovery_code" class="validate" required>
                <label for="recovery_code">Recovery Code</label>
              </div>
            </div>
            <button class="btn waves-effect waves-light blue" type="submit">Recover
              <i class="material-icons right">autorenew</i>
            </button>
          </form>
          <br>
          <p><a href="login.php">Go back to login page</a></p>
          <br>
          <?php
          require "lib/recoverPasswordEngine.php";
          ?>
          <br>
        </div>
      </div>
    </div>
  </div>
  <!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
</body>
</html>