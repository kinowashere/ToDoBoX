<!DOCTYPE html>
<html>

<head>
  <title>ToDoBoX | Wizard</title>
  <?php
  require "lib/templates/header_render.php";
  ?>
</head>

<body>
  <?php
  require 'lib/sql_data.php';
  require 'lib/user.php';
  require 'lib/box.php';
  require 'lib/setup_install_engine.php';
  require 'lib/setup_update_engine.php';
  ?>
  <div class="container">
    <div class="row center">
      <div class="col s12 m8 offset-m2">
        <div class="setup_wizard_container z-depth-1">
          <h4>ToDoBoX</h4>
          <h6>Setup Wizard | Install database and tables</h6>
          <br>

          <div class="row">
            <div class="col s12">
              <ul class="tabs">
                <li class="tab col s4" style="line-height: 1.5;">
                  <a class="active" href="#first_time">First Time</a>
                </li>
                <li class="tab col s4" style="line-height: 1.5;">
                  <a href="#update_tables">Update Tables</a>
                </li>
              </ul>
            </div>

            <div id="first_time" class="col s12">
              <form method="post" action="setup_wizard.php">
                <div class="row blue-text text-darken-2">
                  <h5 class="col s12 grey-text text-darken-4">Server Data</h5>

                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">computer</i>
                    <input id="server_name" type="text" name="server_name" class="validate">
                    <label for="server_name">Server Name</label>
                  </div>

                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">account_box</i>
                    <input id="server_username" type="text" class="validate" name="server_username" required>
                    <label for="server_username">Server Username</label>
                  </div>

                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">vpn_key</i>
                    <input id="server_password" type="password" name="server_password" class="validate">
                    <label for="server_password">Server Password</label>
                  </div>

                  <br>
                  <div class="divider"></div>
                  <br>
                  <h5 class="col s12 grey-text text-darken-4">Admin User Data</h5>

                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">account_box</i>
                    <input id="name" type="text" class="validate" name="name" required>
                    <label for="name">Admin Name</label>
                  </div>
                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">mail</i>
                    <input type="text" name="email" id="email" class="validate" required>
                    <label for="email">Email</label>
                  </div>
                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">vpn_key</i>
                    <input id="password" type="password" name="password" class="validate">
                    <label for="password">Admin Password</label>
                  </div>
                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">spellcheck</i>
                    <input type="text" name="captcha_code" id="captcha_code" class="validate" required>
                    <label for="captcha_code">Captcha</label>
                    <img id="captcha" src="lib/securimage/securimage_show.php">
                    <i class="material-icons suffix" onclick="document.getElementById('captcha').src = 'lib/securimage/securimage_show.php?' + Math.random(); return false;">autorenew</i>
                  </div>
                  <button type="submit" name="install" class="btn-large waves-effect blue">
                    <i class="material-icons left">check</i>Install database and tables
                  </button>
                  <br>
                  <br>
                  <p><a href="login.php">If you already have everything set up?</a></p>

                </div>
              </form>
            </div>

            <div id="update_tables" class="col s12">
              <form method="post" action="setup_wizard.php">
                <button type="submit" name="update" class="btn-large waves-effect blue">
                  <i class="material-icons left">check</i>Update tables
                </button>
              </form>
            </div>

          </div>
          <br>
        </div>
      </div>
    </div>
  </div>
  <!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
  <?php
  require "lib/toasts/setup_wizard_toasts.php";
  ?>
</body>

</html>