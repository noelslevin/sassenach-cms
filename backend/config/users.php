<?php

if (isset($_POST['submit'])) { // Handle the form.

	// Create a function for escaping the data.
	function escape_data ($data) {
		global $dbh; // Need the connection.
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		return mysql_real_escape_string($data, $dbh);
	} // End of function.

	$message = NULL; // Create an empty new variable.
	
	// Check for a first name.
	if (empty($_POST['first_name'])) {
		$firstname = FALSE;
		$message .= '<p>A first name must be specified.</p>';
	} else {
		$firstname = escape_data($_POST['first_name']);
	}
	
	// Check for a last name.
	if (empty($_POST['last_name'])) {
		$lastname = FALSE;
		$message .= '<p>A surname must be specified.</p>';
	} else {
		$lastname = escape_data($_POST['last_name']);
	}
	
	// Check for an email address.
	if (empty($_POST['email'])) {
		$email = FALSE;
		$message .= '<p>An email address must be specified.</p>';
	} else {
		$email = escape_data($_POST['email']);
	}

	// Check for a username.
	if (empty($_POST['username'])) {
		$username = FALSE;
		$message .= '<p>A username must be specified.</p>';
	} else {
		$username = escape_data($_POST['username']);
	}
	
	// Check for a password and match against the confirmed password.
	if (empty($_POST['password1'])) {
		$password = FALSE;
		$message .= '<p>A password must be specified.</p>';
	} else {
		if ($_POST['password1'] == $_POST['password2']) {
			$password = escape_data($_POST['password1']);
			$password = md5($password);

		} else {
			$password = FALSE;
			$message .= '<p>Your passwords do not match.</p>';
		}
	}
	
	if ($firstname && $lastname && $email && $username && $password) { // Tests to see that everything is filled in correctly.
		
		// Make the query.
		$query = "INSERT INTO users (username, firstname, lastname, email, password, registered) VALUES ('$username', '$firstname', '$lastname', '$email', '$password', NOW() )";		
		$result = @mysql_query ($query); // Run the query.
		if ($result) { // If it ran OK.
		
			// Send an email, if desired.
			echo '<h2>Registration successful</h2>';
			echo '<p>.</p>';


include ('../includes/footer.php'); // Include the HTML footer.
			exit(); // Quit the script.
			
		} else { // If it did not run OK.
			$message = '<p>Registration unsuccessful. The error is returned below.</p><p>' . mysql_error() . '</p>'; 
		}
		
		mysql_close(); // Close the database connection.

	} else {
		$message .= '<p>The script will continue when these errors are rectified.</p>';		
	}

} // End of the main Submit conditional.

// Print the message if there is one.
if (isset($message)) {
	echo '<p>The following errors have been found:</p>', $message;
}

echo "<p>You can use this page to register new users and to administrate users who already exist on the database.</p>

<strong>Existing Users</strong>\n";

	$query = "SELECT * FROM users ORDER BY 'id' DESC";
	$result = @mysql_query($query);
	$num = mysql_num_rows($result);
	if ($num > 0) {
	
		echo "<table>
		<tr>
		<td><strong>Username</strong></td>
		<td><strong>First Name</strong></td>
		<td><strong>Last Name</strong></td>
		<td><strong>Email</strong></td>
		<td><strong>Administrate</strong></td>
		</tr>\n";
	
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
			echo "<tr>
			<td>".$row['username']."</td>
			<td>".$row['firstname']."</td>
			<td>".$row['lastname']."</td>
			<td>".$row['email']."</td>
			<td><form action=\"edit_user.php\" method=\"post\"><input type=\"hidden\" name=\"user_id\" value=\"".$row['user_id']."\" /><input type=\"submit\" name=\"update\" value=\"Edit\" /><input type=\"hidden\" name=\"user_id\" value=\"".$row['user_id']."\" /><input type=\"submit\" name=\"delete\" value=\"Delete\" /></form></td>
			</tr>\n";
					
		}
		
		echo "</table>\n";
	
	}

echo "<form id=\"newuser\" action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">

<fieldset>

<legend>Register A User</legend>

<table>

<tr>

<td><label>First Name:</label></td>
<td><input type=\"text\" name=\"first_name\" size=\"30\" maxlength=\"30\" value=\""; if (isset($_POST['first_name'])) echo $_POST['first_name']; echo "\" /></td>

</tr>

<tr>

<td><label>Last Name:</label></td>
<td><input type=\"text\" name=\"last_name\" size=\"30\" maxlength=\"30\" value=\""; if (isset($_POST['last_name'])) echo $_POST['last_name']; echo "\" /></td>

</tr>

<tr>

<td><label>Email Address:</label></td>
<td><input type=\"text\" name=\"email\" size=\"30\" maxlength=\"40\" value=\""; if (isset($_POST['email'])) echo $_POST['email']; echo "\" /></td>

</tr>

<tr>

<td><label>Username:</label></td>
<td><input type=\"text\" name=\"username\" size=\"30\" maxlength=\"20\" value=\""; if (isset($_POST['username'])) echo $_POST['username']; echo "\" /></td>

</tr>

<tr>

<td><label>Password:</label></td>
<td><input type=\"password\" name=\"password1\" size=\"30\" maxlength=\"16\" /></td>

</tr>

<tr>

<td><label>Confirm Password:</label></td>
<td><input type=\"password\" name=\"password2\" size=\"30\" maxlength=\"16\" /></td>

</tr>

</table>

</fieldset>

<div align=\"center\"><input type=\"submit\" name=\"submit\" value=\"Register\" /></div>

</form>\n";

?>
