<!DOCTYPE html>
<html>

<head>
  <title>ToDoBoX</title>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css?family=Baloo|Montserrat" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
  <div class="container">
    <div class="row center">
      <div class="col s12 m6 offset-m3">
        <div class="loginContainer z-depth-1">
          <h3>ToDoBoX</h3>
          <form action="login.php" method="post">
            <div class="row blue-text text-darken-2">
              <div class="input-field col s8 offset-s2">
                <i class="material-icons prefix">mail</i>
                <input type="text" name="email" id="email" class="validate"></input>
                <label for="email">Email</label>
              </div>
              <div class="input-field col s8 offset-s2">
                <i class="material-icons prefix">vpn_key</i>
                <input type="password" name="password" id="password" class="validate">
                <label for="password">Password</label>
              </div>
            </div>
            <button class="btn waves-effect waves-light blue" type="submit" name="action">Submit
              <i class="material-icons right">send</i>
            </button>
          </form>
          <br>
          <p><a href="#">Forgot my password</a></p>
          <?php
          require "lib/loginEngine.php";
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