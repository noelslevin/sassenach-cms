<?php

// File specific variables go here.

$pagetitle="Install Sassenach CMS: New User";

?>

<?php include 'header.php'; ?>

<h1>Setting Up Your Username</h1>

<?php

if (isset($_POST['submit'])) {

	// Check for a first name.
	if (empty($_POST['firstname'])) {
		$firstname = FALSE;
		$message .= '<p>A first name must be specified.</p>';
	} else {
		$firstname = addslashes($_POST['firstname']);
	}
	
	// Check for a last name.
	if (empty($_POST['lastname'])) {
		$lastname = FALSE;
		$message .= '<p>A surname must be specified.</p>';
	} else {
		$lastname = addslashes($_POST['lastname']);
	}
	
	// Check for an email address.
	if (empty($_POST['email'])) {
		$email = FALSE;
		$message .= '<p>An email address must be specified.</p>';
	} else {
		$email = addslashes($_POST['email']);
	}

	// Check for a username.
	if (empty($_POST['username'])) {
		$username = FALSE;
		$message .= '<p>A username must be specified.</p>';
	} else {
		$username = addslashes($_POST['username']);
	}
	
	// Check for a password and match against the confirmed password.
	if (empty($_POST['password'])) {
		$password = FALSE;
		$message .= '<p>A password must be specified.</p>';
	} else {
		if ($_POST['password'] == $_POST['password2']) {
			$password = addslashes($_POST['password']);
			$password = md5($password);

		} else {
			$password = FALSE;
			$message .= '<p>Your passwords do not match.</p>';
		}
	}
	
	if ($firstname && $lastname && $email && $username && $password) { // Tests to see that everything is filled in correctly.
		include ('../../includes/connection.php');		
		// Make the query.
		$query = "INSERT INTO users (username, firstname, lastname, email, password, registered) VALUES ('$username', '$firstname', '$lastname', '$email', '$password', NOW() )";		
		$result = @mysql_query ($query); // Run the query.
		if ($result) { // If it ran OK.
	echo "<p>The user was successfully added to the database.</p>";
	echo "<p><a href=\"finished.php\">Continue</a></p>";
	}
	else {
	echo "<p>The user could not be added.</p>";
	echo "<p>".mysql_error()."</p>";
	}
	
	}
	else {
	echo "<p>Something went wrong.</p>";
	}
	
	}
else {
	echo "<p>We're nearly there now, but we still haven't set up a user, so you can't log in yet. We need to set up a default user. This user cannot be deleted through the system, although their details can be updated. The provided email address will be used for any mailings from the CMS.</p>";
	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">";
	echo "<fieldset>";
	echo "<p>First Name<br/>";
	echo "<input type=\"text\" name=\"firstname\" size=\"40\" maxlength=\"30\"/></p>";
	echo "<p>Last Name<br/>";
	echo "<input type=\"text\" name=\"lastname\" size=\"40\" maxlength=\"30\"/></p>";
	echo "<p>Username<br/>";
	echo "<input type=\"text\" name=\"username\" size=\"40\" maxlength=\"20\"/></p>";
	echo "<p>Email Address<br/>";
	echo "<input type=\"text\" name=\"email\" size=\"40\" maxlength=\"40\"/></p>";
	echo "<p>Password<br/>";
	echo "<input type=\"text\" name=\"password\" size=\"40\" maxlength=\"16\"/></p>";
	echo "<p>Confirm Password<br/>";
	echo "<input type=\"text\" name=\"password2\" size=\"40\" maxlength=\"16\"/></p>";
	echo "<input type=\"submit\" name=\"submit\" value=\"Add User\" />";
	echo "</fieldset>";
	echo "</form>";	
	}

?>

<?php include 'footer.php'; ?>
