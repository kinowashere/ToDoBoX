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
	require "lib/openSession.php";
	require "lib/SQLConnection.php";
	// Classes
	require 'lib/user.php';
	require 'lib/box.php';
	//Get POST data
	require 'lib/postNotes.php';
	// Render website
	require 'lib/templates/archiveBoxRender.php';
	require 'lib/templates/modalsRender.php';
	?>

	<!--JavaScript at end of body for optimized loading-->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<?php
	require "lib/toasts/archiveToasts.php";
	?>
</body>

</html>