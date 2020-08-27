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
include '../includes/db-config.php';
include '../includes/database.class.php';
$pagetitle = $sitename;

if (isset($_GET['page'])) {
	$page = rtrim($_GET['page'], "/");
    $parts = explode("/", $page);
    if (count($parts) == 1) {
        $pagetitle .= ": Backend";
        get_sassenach_function('backend_header');
        echo "<h1>".$sitename.": Dashboard</h1>
        <p>Welcome back, ".$_SESSION['username'].".</p>\n";
    }
    
    elseif (count($parts) == 2) {
        $pagetitle .= ": Backend: ".ucwords($parts[1]);
        get_sassenach_function('backend_header');
        echo "<h1>".$sitename.": ".ucwords($parts[1])."</h1>\n";
        include $parts[1].'/index.php';
    }
    elseif (count($parts) == 3) {
        $pagetitle .= ": Backend: ".ucwords($parts[1]).": ".ucwords($parts[2]);
        get_sassenach_function('backend_header');
        echo "<h1>".$sitename.": ".ucwords($parts[1]).": ".ucwords($parts[2])."</h1>\n";
        include $parts[1].'/'.$parts[2].'.php';
    }

}

get_sassenach_function('backend_footer');

?>