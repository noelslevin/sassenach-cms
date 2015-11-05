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
		$username = $_POST['username'];

	}
	if (empty($_POST['password'])) {
		$password = FALSE;
		$message .= "<p>You forgot to enter your password!</p>\n";
	} else {
        $password = $_POST['password'];
    }
	
	if ($username && $password) { // If everything's OK.
        $database->query('SELECT user_id, username, password FROM users WHERE username = :username');
        $database->bind(':username', '$username');
        $row = $database->single();
        
        //$query = "SELECT user_id, username, password FROM users WHERE username = '$username'";
        //$result = @mysql_query($query);
        //$row = mysql_fetch_array ($result, MYSQL_ASSOC);
        if ($row) {
            if (password_verify($_POST['password'], $row['password'])) {
                session_start();
                $_SESSION['user_id'] = $row['user_id'];
				$_SESSION['username'] = $row['username'];
                header ("Location:  $globalhome$backend");
				exit();
            }
            else {
                $message .= "<p>The username and password do not match those on the database.</p>\n";
            }
        }
        else {
            $message .= "<p>Nothing returned from the database.</p>";
        }
        mysql_close();
	} else {
		$message .= "<p>Please try again.</p>\n";		
	}
}

if (isset($message)) {
    echo $message;
}

?>
