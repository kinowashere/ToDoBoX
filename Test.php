<!DOCTYPE html>
<html>

<head>
  <title>Test</title>
</head>

<body>
  <?php
  require 'lib/user.php';
  require 'lib/box.php';

  // Add testing stuff here

  if (isset($_POST['view'])) {

    $retval = mysqli_query($conn, $sql);
    $userArray = array();
    $counter = 0;

    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
      $userArray[$counter]['user_id'] = $row['user_id'];
      $userArray[$counter]['name'] = $row['name'];
      $userArray[$counter]['email'] = $row['email'];
      $userArray[$counter]['recovery_code'] = $row['recovery_code'];
      $userArray[$counter]['is_admin'] = $row['is_admin'];
      $counter++;
    }

    // Twig Engine
    $loader = new Twig_Loader_Filesystem('lib/templates/views');
    $twig = new Twig_Environment($loader);

    echo $twig->render(
      'user_views.html',
      array('users' => $userArray)
    );
  }

  //Henlo gitlab

  ?>
</body>


</html>