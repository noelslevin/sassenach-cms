<?php

session_start(); // Start the session.

// If no session is present, redirect the user.
if (!isset($_SESSION['username'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . "/actions/login.php");
	exit(); // Quit the script.
}

function get_sassenach_function($function) {
	$sassenach_function = 'functions/'.$function.'.php';
	include $sassenach_function;
	}

include '../includes/variables.php';
include '../includes/connection.php';

if (isset($_GET['page'])) { // If accessing a top-level admin page
	$page = $_GET['page'];
	$pagetitle = $sitename.": Backend: ".ucwords($page);
	if (isset($_GET['subpage'])) { // If accessing a secondary-level admin page
		$subpage = $_GET['subpage'];
		$pagetitle .= ": ".ucwords(preg_replace ("/_/", " ", $_GET['subpage']));
		get_sassenach_function('backend_header');
		echo "<h1>".$sitename.": ".ucwords($page).": ".ucwords(preg_replace ("/_/", " ", $_GET['subpage']))."</h1>\n";
		@include $page."/".$subpage.".php";
		}
	else {
		get_sassenach_function('backend_header');
		echo "<h1>".$sitename.": ".ucwords($page)."</h1>\n";
		include $page."/index.php";
		}
	}
else { // If directly accessing the admin page
	$pagetitle = $sitename.": Backend";
	get_sassenach_function('backend_header');
	echo "<h1>".$sitename.": Dashboard</h1>
	<p>Welcome back, ".$_SESSION['username'].".</p>\n";
	}

get_sassenach_function('backend_footer');

?>