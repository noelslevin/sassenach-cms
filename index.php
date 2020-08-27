<?php

session_start(); // Start the session.

include 'includes/variables.php';

function get_sassenach_function($function) {
	global $backend;
	$sassenach_function = $backend.'/functions/'.$function.'.php';
	include $sassenach_function;
	}

include 'includes/db-config.php';
include 'includes/database.class.php';
include $backend.'styles/'.$style.'header.php';

echo "<div class=\"content\">";

if ($status == "up") {
	include $backend.'styles/'.$style.'index.php';
	}
else {
	echo $offline;
	}
	
echo "</div>";

include $backend.'styles/'.$style.'footer.php';

?>
