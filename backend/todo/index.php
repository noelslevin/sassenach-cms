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
	
	// Check post or page name.
	if (empty($_POST['title'])) {
		$title = FALSE;
		$message .= '<p>Your task needs a title.</p>';
	} else {
		$title = escape_data($_POST['title']);
//		echo $title; echo "<br/>";
	}
	
	// Check for task content.
	if (empty($_POST['description'])) {
		$description = FALSE;
		$message .= '<p>Your task needs a description.</p>';

	}
	
	 else {
		$description = escape_data($_POST['description']);
//		echo $description; echo "<br/>";

	}
	
	// Check status.
	if (empty($_POST['status'])) {
		$status = FALSE;
		$message .= '<p>You need to specify the status of this task.</p>';
	} else {
		$status = escape_data($_POST['status']);
//		echo $status; echo "<br/>";
	}
	
	// Check importance.
	if (empty($_POST['importance'])) {
		$title = FALSE;
		$message .= '<p>You need to specify the importance of this task.</p>';
	} else {
		$importance = escape_data($_POST['importance']);
//		echo $importance; echo "<br/>";
	}

	if ($title && $description && $status && $importance) { // Tests to see that everything is filled in correctly.
		
		$author = $_SESSION['username'];
		$query = "SELECT * FROM users WHERE username='$author'";
		$result = @mysql_query ($query);
		if ($result) {
			while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
				$author = $row['user_id'];
				}
			}
		
		// Make the query.
		$query = "INSERT INTO todo (name, description, status, importance, author, timestamp) VALUES ('$title', '$description', '$status', '$importance', '$author', NOW())";		
		$result = @mysql_query ($query); // Run the query.
		if ($result) { // If it ran OK.
		
			// Inform the user.
			echo '<p>Your task was successfully entered into the database</p>';

			include '../includes/footer.php';
			exit(); // Quit the script.
			
		} else { // If it did not run OK.
			$message = '<p>Your database submission was unsuccessful. Details are given below.</p><p>' . mysql_error() . '</p>'; 
		}
		
		mysql_close(); // Close the database connection.

	} else {
		$message .= '<p>Please rectify these issues before re-submitting.</p>';		
	}

} // End of the main Submit conditional.

?>








<h1>Noel's To Do List</h1>

<p>This is a list of things that I aim to implement on this content management system. Some of these things may take a while, but it's good to have them all written down anyway, since they'll only get lost in the middle of my head!</p>

<?php

$todoquery1 = "SELECT * FROM todo WHERE status = 'stalled' ORDER BY importance ASC";

$todoresult1 = @mysql_query ($todoquery1); // Run the query through the database

$num = mysql_num_rows ($todoresult1);

if ($num > 0) { // If anything is found

echo "<strong>Tasks Not Yet Started</strong> (".$num.")";

echo '<table class="todo"><tr><td><strong>Task</strong></td><td><strong>Description</strong></td><td><strong>Importance</strong></td><td><strong>Update</strong></td></tr>';

while ($row = mysql_fetch_array($todoresult1, MYSQL_ASSOC)) {

echo '<tr><td>',$row['name'], '</td><td>', $row['description'], '</td><td>', $row['importance'], '</td><td><a href="update.php?action=started&amp;id=',$row['id'],'">Started</a></td></tr>';

}

echo '</table>';

}

?>



<?php

$todoquery1 = "SELECT * FROM `todo` WHERE `status` = 'in progress' ORDER BY `importance` ASC";

$todoresult1 = @mysql_query ($todoquery1); // Run the query through the database

$num = mysql_num_rows ($todoresult1);

if ($num > 0) { // If anything is found

echo "<strong>Tasks In Progress</strong> (".$num.")";

echo '<table class="todo"><tr><td><strong>Task</strong></td><td><strong>Description</strong></td><td><strong>Importance</strong></td><td><strong>Update</strong></td></tr>';

while ($row = mysql_fetch_array($todoresult1, MYSQL_ASSOC)) {

echo '<tr><td>',$row['name'], '</td><td>', $row['description'], '</td><td>', $row['importance'], '</td><td><a href="update.php?action=finished&amp;id=',$row['id'],'">Completed</a></td></tr>';

}

echo '</table>';

}

?>



<?php

$todoquery1 = "SELECT * FROM `todo` WHERE `status` = 'implemented' ORDER BY `importance` ASC";

$todoresult1 = @mysql_query ($todoquery1); // Run the query through the database

$num = mysql_num_rows ($todoresult1);

if ($num > 0) { // If anything is found

echo "<strong>Implemented Tasks</strong> (".$num.")";

echo "<table class=\"todo\">\n<tr>\n<td><strong>Task</strong></td>\n<td><strong>Description</strong></td>\n<td><strong>Importance</strong></td>\n<td><strong>Update</strong></td>\n</tr>";

while ($row = mysql_fetch_array($todoresult1, MYSQL_ASSOC)) {

echo '<tr><td>',$row['name'], '</td><td>', $row['description'], '</td><td>', $row['importance'], '</td><td><a href="update.php?action=delete&amp;id=',$row['id'],'">Delete</a></td></tr>';
echo "\n";

}

echo '</table>';

}

?>






<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="todo">

<fieldset>

<legend>Submit a Task</legend>

<table>

<tr>

<td><label>Title</label></td>
<td><input type="text" name="title" size="40" tabindex="1" value="" id="title" /></td>

</tr>
<tr>

<td><label>Description</label></td>
<td><textarea name="description" cols="5" rows="5" id="description"></textarea><br/><br/></td>

</tr>
<tr>

<td><label>Status</label></td>
<td><select name="status" size ="1">

<?php

$query = "DESCRIBE todo status";

$result = @mysql_query ($query); // Run the query through the database

if ($result) { // If anything is found

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

$oldstring = $row['Type']; // This prints the ENUM record of categories
$newstring = strstr($oldstring, "'"); // Removes the reference to SET and opening bracket
$newerstring = substr($newstring, 0, -1); // Removes the closing bracket, leaving just the enclosed variables
$neweststring = explode(",", $newerstring);


foreach ($neweststring as $category) {

$category = substr($category, 1, -1); // Removes the slashes on both sides, finally leaving us with the category from the database! Hurrah!

echo '<option value="', $category, '">', $category, '</option>';

//echo '<input type="radio" name="status" />', $category, '<br/>', "\n";

}

}

}

else {

echo 'There appear to be no status options the database.';

}

?>

</select></td>

</tr>
<tr>

<td><label>Importance</label></td>
<td><select name="importance" size="1">

<?php

$query = "DESCRIBE todo importance";

$result = @mysql_query ($query); // Run the query through the database

if ($result) { // If anything is found

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

$oldstring = $row['Type']; // This prints the ENUM record of categories
$newstring = strstr($oldstring, "'"); // Removes the reference to SET and opening bracket
$newerstring = substr($newstring, 0, -1); // Removes the closing bracket, leaving just the enclosed variables
$neweststring = explode(",", $newerstring);


foreach ($neweststring as $category) {

$category = substr($category, 1, -1); // Removes the slashes on both sides, finally leaving us with the category from the database! Hurrah!

echo '<option value="', $category, '">', $category, '</option>';

}

}

}

else {

echo 'There appear to be no priority values in the database.';

}

?>

</select></td>

</tr>

</table>


</fieldset>

<div align="center"><input type="submit" name="submit" value="Save" /></div>

</form>
