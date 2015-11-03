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
	
		if ($email && $username && $password) { // Tests to see that everything is filled in correctly.
		
		// Make the query.
		$query = "UPDATE users SET email='$email', password='$password' WHERE username='$username'";
		$result = @mysql_query ($query); // Run the query.
		if ($result) { // If it ran OK.
		
			// Send an email, if desired.
			echo "<p>The user's details were successfully updated.</p>";

}

}

}

if (isset($_POST['delete'])) { // Handle the form.

		if (isset($_POST['user_id'])) {
		
			$id = $_POST['user_id'];

      if ($id == '1') {
      
      echo "<p>This user cannot be deleted as they are the original user.</p>";
      
      }
      
      else {

          $update = "DELETE from users WHERE user_id = $id";
          $result = @mysql_query ($update);
          if (mysql_affected_rows() == 1) {
			
              echo "<p>The database has been successfully updated.</p>";

          }

          else {

              echo "<p>Error. The database was not updated correctly.</p>";

          }
			
			}

		}

		else {

			echo "<p>An id was not assigned. The system does not know what to update.</p>";

		}
		
		}

	else if (isset($_POST['update'])) {

		if (isset($_POST['user_id'])) {
		
			$id = $_POST['user_id'];
			
			$query = "SELECT * FROM users WHERE user_id='$id'";
			
			$result = @mysql_query ($query);
			$num = mysql_num_rows ($result);
			if ($num == 1) {
			
			$row = mysql_fetch_array ($result, MYSQL_ASSOC);
			
      echo "<form id=\"newuser\" action=\""; echo $_SERVER['PHP_SELF']; echo "\" method=\"post\">
      <fieldset>
      <legend>Update A User</legend>
      <table>
      <tr>
      <td><label>Username:</label></td>
      <td><input type=\"text\" name=\"username\" size=\"30\" maxlength=\"20\" value=\""; echo $row['username']; echo"\" readonly=\"readonly\" /></td>
      </tr>
      <tr>
      <td><label>Email Address:</label></td>
      <td><input type=\"text\" name=\"email\" size=\"30\" maxlength=\"40\" value=\""; echo $row['email']; echo "\" /></td>
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
      <div align=\"center\"><input type=\"submit\" name=\"submit\" value=\"Update\" /></div>
      </form>";

      }

			else {

				echo "<p>Error. The record was not found in the database.</p>";

			}

		}

		else {

			echo "<p>An id was not assigned. The system does not have any records to return.</p>";

		}

	}

    else {
    
    echo "<p>You have not specified a valid action: you must either 'edit' or 'delete'!</p>";
    
    }

?>
