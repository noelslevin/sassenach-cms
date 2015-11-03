<?php

if (isset($_GET['action'])) {
	$action = $_GET['action'];
	include "actions/".$action.".php";
	}
else {
	echo "<h1>Welcome to ".$sitename."</h1>

	<p>More content will be added soon!</p>";
	}
?>
