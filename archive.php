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
	require "lib/openSession.php";
	require 'lib/postNotes.php';
	?>
	<a href="#" class="btn-flat btn-large waves-effect waves-light sidenav-trigger transparent" data-target="slide-out" id="menuButton">
		<i class="material-icons">menu</i>
	</a>

	<div class="container">
		<div class="row">
			<?php
			require_once 'archiveLoadEngine.php';
			?>
		</div>
	</div>

	<?php
	require 'modalsEngine.php';
	?>

	<!--JavaScript at end of body for optimized loading-->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
  <?php
  require "get.php";
  ?>
</body>

</html>