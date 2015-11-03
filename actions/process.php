<?php

if (isset($_POST['login'])) {
	require_once ('../includes/variables.php');
	require_once ('../includes/connection.php');
	function escape_data ($data) {
		global $dbh;
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		return mysql_real_escape_string($data, $dbh);
	}
	$message = NULL;
	if (empty($_POST['username'])) {
		$username = FALSE;
		$message .= "<p>You forgot to enter your username!</p>\n";
	} else {
		$username = escape_data($_POST['username']);

	}
	if (empty($_POST['password'])) {
		$password = FALSE;
		$message .= "<p>You forgot to enter your password!</p>\n";
	} else {
		$password = escape_data($_POST['password']);
		$password = md5($password);
	}
	
	if ($username && $password) { // If everything's OK.
		$query = "SELECT user_id, username FROM users WHERE username='$username' AND password='$password'";		
		$result = @mysql_query ($query);
		$row = mysql_fetch_array ($result, MYSQL_NUM); 
		if ($row) { 
				
				// Start the session, register the values & redirect.
				session_start();
				$_SESSION['username'] = $row[1];
				$_SESSION['user_id'] = $row[0];

				header ("Location:  $globalhome$backend");
				exit();
				
		} else {
			$message .= "<p>The username and password do not match those on the database.</p>\n";
		}
		mysql_close();
	} else {
		$message .= "<p>Please try again.</p>\n";		
	}
}

?>
