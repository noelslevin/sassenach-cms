<?php

session_start(); // Start the session.

// If no session is present, redirect the user.
if (!isset($_SESSION['username'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/../login.php");
	exit(); // Quit the script.
}

// File specific variables go here.

$pagetitle="Links";

include '../../includes/variables.php';
include '../../includes/connection.php';
include '../includes/header.php';

?>

<h1>Update Links</h1>

<?php

if (isset($_POST['updatelink'])) {

  $id = $_POST['id'];
	// Create a function for escaping the data.
	function escape_data ($data) {
		global $dbh; // Need the connection.
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		return mysql_real_escape_string($data, $dbh);
	} // End of function.

	$message = NULL; // Create an empty new variable.
	
	// Check the link has a title.
	if (empty($_POST['linkname'])) {
		$linkname = FALSE;
		$message .= '<p>Your link needs a name.</p>';
	} else {
		$linkname = escape_data($_POST['linkname']);
	}
	
	// Check the link has an address.
	if (empty($_POST['linkurl'])) {
		$linkurl = FALSE;
		$message .= '<p>Your link needs an address.</p>';
	} else {
		$linkurl = escape_data($_POST['linkurl']);
	}
	
	// Check the link has a description.
	if (empty($_POST['linkdescription'])) {
		$linkdescription = FALSE;
		$message .= '<p>Your link needs a short description.</p>';
	} else {
		$linkdescription = escape_data($_POST['linkdescription']);
	}
	
	
	$linkcategories = NULL;
	if (isset($_POST['categoryid'])) {
	
		foreach ($_POST['categoryid'] as $key => $value) {
		
			$linkcategories .= "$value, ";
		
		}
	
		$linkcategories = substr($linkcategories, 0, -2);
		
		}
		
		else {
		
			$linkcategories = NULL;
			echo "<p>No categories have been selected.</p>";
		
		}

	if ($linkname && $linkdescription && $linkurl && $linkcategories) {

		$linksubmission = "UPDATE links SET name='$linkname', description='$linkdescription', link='$linkurl', category='$linkcategories' WHERE id='$id'";
		$result = @mysql_query ($linksubmission);

		if ($result) {

			echo "<p>The link was successfully updated in the database</p>";

		}
		
		else {
		
		echo "<p>An error occurred, and the database was not updated.</p>";
		
		}

	}

	else {

		echo "<p>There are problems with your form. Please sort these out before continuing</p>.", $message;

	}    

}

?>

<?php

if (isset($_GET['action'])) { // Handle the form.

	if ($_GET['action'] == 'delete') {

		if (isset($_GET['id'])) {
		
			$id = $_GET['id'];

			$update = "DELETE from links WHERE id = $id";
			$result = @mysql_query ($update);
			if (mysql_affected_rows() == 1) {
			
				echo "<p>The database has been successfully updated.</p>";

			}

			else {

				echo "<p>Error. The database was not updated correctly.</p>";

			}

		}

		else {

			echo "<p>An id was not assigned. The system does not know what to update.</p>";

		}

	}

	else if ($_GET['action'] == 'edit') {

		if (isset($_GET['id'])) {
		
			$id = $_GET['id'];

			$query = "SELECT * FROM links WHERE id='$id'";
			$result = @mysql_query ($query);
			$num = mysql_num_rows ($result);
			if ($num == 1) {
			
			$row = mysql_fetch_array ($result, MYSQL_ASSOC);
			
			echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" id=\"newlink\">
      <fieldset>
      <legend>Update a Link</legend>
      <table class=\"newlink\">
      <tr>
      <td><label>Link</label></td>
      <td><input type=\"text\" name=\"linkurl\" size=\"50\" tabindex=\"1\" value=\"".$row['link']."\" id=\"url\" /></td>
      </tr>
      <tr>
      <td><label>Name</label></td>
      <td><input type=\"text\" name=\"linkname\" size=\"50\" tabindex=\"1\" value=\"".$row['name']."\" id=\"name\" /></td>
      </tr>
      <tr>
      <td><label>Description</label></td>
      <td><input type=\"text\" name=\"linkdescription\" size=\"50\" tabindex=\"1\" value=\"".$row['description']."\" id=\"description\" /></td>
      </tr>
      <tr>
      <td><label>Categories</label></td>
      <td>";

      $linkquery = "SELECT * FROM categories WHERE type = 'link'";
      $result = @mysql_query ($linkquery); // Run the query through the database
      if ($result) { // If anything is found
      while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
          $category = $row['name'];
          $categoryvalue = $row['id'];
          echo "<input type=\"radio\" name=\"categoryid[]\" value=\"".$categoryvalue."\" />".$category."<br/>", "\n";

      }

    }

echo "</td>
</tr>
</table>
<input type=\"hidden\" name=\"id\" value=\"".$id."\" />\n
</fieldset>
<div align=\"center\"><input type=\"submit\" name=\"updatelink\" value=\"Update Link\" /></div>
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

}

?>

<?php include '../includes/footer.php'; ?>
