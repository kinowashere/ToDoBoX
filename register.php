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
  require 'lib/user.php';
  require 'lib/box.php';
  ?>
  <div class="container">
    <div class="row center">
      <div class="col s12 m8 offset-m2">
        <div class="loginContainer z-depth-1">
          <h3>ToDoBoX</h3>
          <form action="register.php" method="post">
            <div class="row blue-text text-darken-2">
              <div class="input-field col s8 offset-s2">
                <i class="material-icons prefix">account_box</i>
                <input type="text" name="name" id="name" class="validate" required>
                <label for="name">Name</label>
              </div>
              <div class="input-field col s8 offset-s2">
                <i class="material-icons prefix">mail</i>
                <input type="text" name="email" id="email" class="validate" required>
                <label for="email">Email</label>
              </div>
              <div class="input-field col s8 offset-s2">
                <i class="material-icons prefix">vpn_key</i>
                <input type="password" name="password" id="password" class="validate" minlength="8" required>
                <label for="password">Password</label>
              </div>

              <div class="input-field col s8 offset-s2">
                <i class="material-icons prefix">spellcheck</i>
                <input type="text" name="captcha_code" id="captcha_code" class="validate" required>
                <label for="captcha_code">Captcha</label>
                <img id="captcha" src="lib/securimage/securimage_show.php">
                <i class="material-icons suffix" onclick="document.getElementById('captcha').src = 'lib/securimage/securimage_show.php?' + Math.random(); return false;">autorenew</i>
              </div>


            </div>
            <button class="btn waves-effect waves-light blue" type="submit">Register
              <i class="material-icons right">add</i>
            </button>
          </form>
          <br>

          <p><a href="login.php">If you already have an account?</a></p>

          <br>
          <?php
          require "lib/registerEngine.php";
          ?>
          <br>
        </div>
      </div>
    </div>
  </div>

  <!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
  <?php
  require "lib/toasts/loginAndRegisterToasts.php";
  ?>
</body>

</html>