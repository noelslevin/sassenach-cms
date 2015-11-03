<?php

$pagetitle="Sign Up";

include '../includes/variables.php';

function get_sassenach_function($function) {
	global $backend;
	$sassenach_function = '../'.$backend.'functions/'.$function.'.php';
	include $sassenach_function;
	}

include '../includes/connection.php';
include '../'.$backend.'styles/'.$style.'header.php';

echo "<div class=\"content\">";

echo "<h1>Sign Up</h1>

<p>You can't do this yet. The system isn't quite ready. How did you get here anyway?</p>";

echo "</div>";

include '../'.$backend.'styles/'.$style.'footer.php';

?>
