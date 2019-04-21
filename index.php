<!DOCTYPE html>
<html>

<head>
	<title>ToDoBoX</title>
	<?php
	require "lib/templates/header_render.php";
	?>
</head>

<body>
	<?php
	require "lib/open_session.php";
	require "lib/sql_data.php";
	//Classes
	require 'lib/user.php';
	require 'lib/box.php';
	//Get POST Data
	require 'lib/admin.php';
	require 'lib/post_index.php';
	require_once "lib/change_user_data.php";
	// Render website
	require_once 'lib/templates/modals_render.php';
	require_once 'lib/templates/index_box_render.php';
	?>

	<!--JavaScript at end of body for optimized loading-->
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<?php
	require "lib/toasts/index_toasts.php";
	?>
</body>

</html>