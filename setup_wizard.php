<!DOCTYPE html>
<html>
<head>
  <title>ToDoBoX | Wizard</title>
  <?php
  require "lib/templates/headerRender.php";
  ?>
</head>
<body>
  <?php
  require "lib/SQLConnection.php";
  require "lib/toasts/toastEngine.php";
  require "lib/setupEngine.php";
  ?>
  <div class="container">
    <div class="row center">
      <div class="col s12 m8 offset-m2">
        <div class="setupWizardContainer z-depth-1">
          <h4>ToDoBoX</h4>
          <h6>Setup Wizard | Install necessary database and tables</h6>
          <br>

          <div class="row">
            <div class="col s12">
              <ul class="tabs">
                <li class="tab col s4" style="line-height: 1.5;">
                  <a class="active" href="#firstTime">First Time</a>
                </li>
                <li class="tab col s4" style="line-height: 1.5;">
                  <a href="#updateTables">Update Tables</a>
                </li>
              </ul>
            </div>

            <div id="firstTime" class="col s12">
              <form method="post" action="setup_wizard.php">
                <div class="row blue-text text-darken-2">
                  <h5 class="col s12 grey-text text-darken-4">Server Data</h5>

                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="servername" type="text" name="servername">
                    <label for="server">Server Name</label>
                  </div>

                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="serverUsername" type="text" class="validate" name="serverUsername" required>
                    <label for="serverUsername">Server Username</label>
                  </div>

                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="serverPassword" type="password" name="serverPassword">
                    <label for="serverPassword">Server Password</label>
                  </div>

                  <br>
                  <div class="divider"></div>
                  <br>
                  <h5 class="col s12 grey-text text-darken-4">Admin User Data</h5>

                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="username" type="text" class="validate" name="username" required>
                    <label for="username">Admin Username</label>
                  </div>

                  <div class="input-field col s8 offset-s2">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="password" type="password" name="password">
                    <label for="password">Admin Password</label>
                  </div>

                  <button type="submit" name="submit" class="btn-large waves-effect blue">
                    <i class="material-icons left">check</i>Install database and tables
                  </button>
                </div>
              </form>
            </div>

            <div id="updateTables" class="col s12">

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
  if (isset($_GET["hello"])) {
    // Box has been deleted from database
    echo("Hello");
  }
  ?>
</body>
</html>