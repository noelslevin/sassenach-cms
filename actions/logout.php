<?php

session_start(); // Access the existing session.

// If no first_name variable exists, redirect the user.
if (!isset($_SESSION['username'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/login.php");
	exit(); // Quit the script.
} else {
	
	$_SESSION = array(); // Destroy the variables.
	session_destroy(); // Destroy the session itself.
	setcookie ('PHPSESSID', '', time()-300, '/', '', 0); // Destroy the cookie.

	$pagetitle="Log Out";
	
	include '../includes/variables.php';

	function get_sassenach_function($function) {
	global $backend;
	$sassenach_function = '../'.$backend.'functions/'.$function.'.php';
	include $sassenach_function;
	}

	include '../includes/connection.php';
	include '../'.$backend.'styles/'.$style.'header.php';

	echo "<div class=\"content\">";

	echo "<h1>Log Out</h1>\n";
	echo "<p>You have been successfully logged out.</p>";
	
	echo "</div>";

	include '../'.$backend.'styles/'.$style.'footer.php';

	}

?>
