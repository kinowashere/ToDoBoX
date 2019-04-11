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
	//Get POST Data
	require 'lib/postNotes.php';
	require_once "lib/changeUserData.php";
	// Render website
	require_once 'lib/templates/indexBoxRender.php';
	require_once 'lib/templates/modalsRender.php';
	?>

	<!--JavaScript at end of body for optimized loading-->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<?php
	require "lib/toasts/indexToasts.php";
	?>
</body>

</html>