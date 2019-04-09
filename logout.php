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
  <?php
  // セッション開始
  session_start();
  // セッション変数を全て削除
  $_SESSION = array();
  // セッションクッキーを削除
  if (isset($_COOKIE["PHPSESSID"])) {
    setcookie("PHPSESSID", '', time() - 1800, '/');
  }
  // セッションの登録データを削除
  session_destroy();
  ?>
  <div class="container">
    <div class="row center">
      <div class="col s12 m6 offset-m3">
        <div class="logoutContainer z-depth-1">
          <div class="btn-floating shibaLogout">
          </div>
          <h3 style="font-weight: bold;">ToDoBoX</h3>
          <br>
          <h5>Logged out successfully!</h5>
          <h5>See you soon!</h5>
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