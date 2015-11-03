<?php

echo "<script language=\"javascript\" type=\"text/javascript\" src=\"".$globalhome.$backend."/tinymce/jscripts/tiny_mce/tiny_mce.js\"></script>
<script language=\"javascript\" type=\"text/javascript\">
tinyMCE.init({
	theme : \"advanced\",
	skin : \"o2k7\",
	mode : \"textareas\",
	relative_urls : false,
	remove_script_host : false,
	document_base_url : \"".$globalhome.$uploads."\"

});
</script>\n";

if (isset($_POST['content'])) { // Handle the form.

	// Create a function for escaping the data.
	function escape_data ($data) {
		global $dbh; // Need the connection.
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		return mysql_real_escape_string($data, $dbh);
	} // End of function.

	$message = NULL; // Create an empty new variable.
	
	// Check post or page name.
	if (empty($_POST['title'])) {
		$title = FALSE;
		$message .= '<p>Your post or page needs a title.</p>';
	} else {
		$title = escape_data($_POST['title']);
		$url = $title;
		$url = strtolower($url);
		$url = str_replace(" ", "-", $url);
		$url = ereg_replace("[^A-Za-z0-9-]", "", $url);

	}
	
	// Check for content to the post or page.
	if (empty($_POST['content'])) {
		$content = FALSE;
		$message .= '<p>Your post or page is blank. This is not allowed. Please write something for people to read!</p>';
	}

	else if ($_POST['content']== '<p>&nbsp;</p>') {
	
		$message.= '<p>Your post or page is blank. This is not allowed. Please write something for people to read!</p>';
	
	}
	
	 else {
		$content = trim(escape_data($_POST['content']));

	}

	$parent = NULL;
	if (isset($_POST['parent'])) {
	
		foreach ($_POST['parent'] as $key => $value) {
		
			$parent .= "$value, ";
		
		}
	
		$parent = substr($parent, 0, -2);
		
		}
		
		else {
		
			$parent = '0';
		
		}

	$status = $_POST['status'];
	$page_id = $_POST['page_id'];

	
	// Check for an author. It should not be possible to fail this test!
	if (empty($_POST['author'])) {
		$author = FALSE;
		$message .= '<p>This post appears to have no author. This is not possible! A critical error has occurred. Please inform the application developer immediately.</p>';
	} else {
		$author = escape_data($_POST['author']);
	}
	
	if ($title && $content && $author && $status) { // Tests to see that everything is filled in correctly.
		
		// Make the query.
		$query = "UPDATE pages SET author = '$author', content = '$content', title = '$title', status = '$status', parent = '$parent', updated = NOW() WHERE id = '$page_id'";
		$result = @mysql_query ($query); // Run the query.
		if ($result) { // If it ran OK.
		
			// Inform the user.
			echo '<h1>Page Update Successful</h1>';
			echo '<p>Your page was successfully updated in the database. Hurrah!</p>';

include ('../includes/footer.php'); // Include the HTML footer.
			exit(); // Quit the script.
			
		} else { // If it did not run OK.
			$message = '<p>Your database submission was unsuccessful. Details are given below.</p><p>' . mysql_error() . '</p>'; 
		}
		
		mysql_close(); // Close the database connection.

	} else {
		$message .= '<p>These issues must be rectified before your submission to the database is successful.</p>';		
	}

} // End of the main Submit conditional.

else if (isset($_GET['action'])) {

	if (isset($_GET['id'])) {

	$id = $_GET['id'];
	
	if ($_GET['action'] == 'delete') {
		$query = "DELETE FROM pages WHERE id = '$id'";
		$result = @mysql_query ($query);
		if (mysql_affected_rows() == 1) {
			echo "<p>The page was deleted from the database.</p>";
			}
		else {
			echo "<p>The page was not deleted from the database. The page probably does not exist.</p>";
			}
		}
	else if ($_GET['action'] == 'edit') {		
	
	$query = "SELECT * FROM pages WHERE id='$id'";
	$result = @mysql_query ($query);
	$num = mysql_num_rows ($result);
	if ($num == 1) {

	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {

	$content = $row['content'];
	$content = stripslashes($content);
	$title = $row['title'];
	$parent = $row['parent'];
	$status = $row['status'];

?>

<div id="tinymce">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="write">

<fieldset>

<legend>Edit A Page</legend>

<label for="title">Title: </label>
	<input type="text" name="title" size="50" tabindex="1" value="<?php echo $title; ?>" id="title" /><br/><br/>

<div id="categories">

<label>Parent Page</label><br/><br/>

<?php

if ($parent == '0') {
echo "<input type=\"radio\" name=\"parent[]\" value=\"0\" checked=\"checked\" tabindex=\"3\"/>None<br/>\n";
}
else {
echo "<input type=\"radio\" name=\"parent[]\" value=\"0\" tabindex=\"3\"/>None<br/>\n";
}

$pagequery = "SELECT * FROM pages";

$result = @mysql_query ($pagequery); // Run the query through the database

if ($result) { // If anything is found
$page_id = $row['id'];
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

$page = $row['title'];
$pageid = $row['id'];

if ($parent == $pageid) {
echo "<input type=\"radio\" name=\"parent[]\" value=\"".$pageid."\" checked=\"checked\" tabindex=\"3\"/>".$page."<br/>\n";
}
else {
echo "<input type=\"radio\" name=\"parent[]\" value=\"".$pageid."\" tabindex=\"3\"/>".$page."<br/>\n";
}

}

}

?>

<br/>

<label>Status</label><br/><br/>

<input type="radio" name="status" value="draft" <?php if ($status == 'draft') { echo "checked=\"checked\""; } ?> tabindex="4"/>Draft
<br/>
<input type="radio" name="status" value="published" <?php if ($status == 'published') { echo "checked=\"checked\""; } ?> tabindex="4"/>Published
<br/>
<br/>

<input type="submit" name="content" value="Save" />

<input type="hidden" name="author" value="<?php echo $_SESSION['user_id']; ?>" />
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />

</div>

<textarea name="content" id="post" class="mceEditor" cols="130" rows="25">

<?php echo htmlentities($content); ?>
	
	</textarea>

</fieldset>

</form>

</div>

<?php

				}

			}

			else {
				echo "<p>No page could be found to match your request.</p>";
				}

		}

		else {
			echo "<p>Incorrect action specified.</p>";
			}

		}
		
	else {
		echo "<p>No page id specified.</p>";
		}

	}

else {
	$query = "SELECT * FROM pages";
	$result = @mysql_query ($query);
	$num = mysql_num_rows ($result);
	if ($num > 0) {
		echo "<table>";
		echo "<tr>";
		echo "<td>Page Name</td>";
		echo "<td>Status</td>";
		echo "<td>Edit</td>";
		echo "<td>Delete</td>";
		echo "</tr>";
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			echo "<tr>";
			echo "<td>".$row['title']."</td>";
			echo "<td>".$row['status']."</td>";
			echo "<td><a href=\"page.php?action=edit&amp;id=".$row['id']."\">Edit</a></td>";
			echo "<td><a href=\"page.php?action=delete&amp;id=".$row['id']."\">Delete</a></td>";
			echo "</tr>";
			}
		echo "</table>";
		}
	else {
		echo "<p>No pages found in the database.</p>";
		}
}

?>

<?php

// Print the message if there is one.
if (isset($message)) {
	echo '<p>Unfortunately, there were errors with your database submission. These are described below.</p>'.$message;
}

?>
