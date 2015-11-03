<?php

session_start(); // Start the session.

// If no session is present, redirect the user.
if (!isset($_SESSION['username'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/../login.php");
	exit(); // Quit the script.
}

// Page specific variables go here.

$pagetitle="Manage: Categories";

include '../../includes/variables.php';
include '../../includes/connection.php';
include '../includes/header.php';

?>

<h1>Manage: Categories</h1>

<p>This page allows you to create new categories and to delete unwanted categories from your database.</p>

<?php

if (isset($_POST['submit'])) {
	$name = addslashes($_POST['name']);
	$type = addslashes($_POST['type']);
	$url = addslashes($_POST['url']);
	$parent = addslashes($_POST['parent']);
	$id = $_POST['id'];
		$query = "UPDATE categories SET name='$name', url='$url', parent='$parent' WHERE id=$id";
		$result = mysql_query ($query);
		if (mysql_affected_rows() > 0) {
			echo "<p>The category was successfully updated.</p>";
			}
			
		else {
			echo "<p>The category was not updated. Either an error occurred, or you did not alter the details already stored in the database.</p>";
			}
	
	}

else if (isset($_GET['action'])) {
	if ($_GET['action'] == 'delete') {

		$category_id = $_GET['id'];
		if ($category_id != 1) {
		$sqlquery = "DELETE FROM categories WHERE id = '$category_id'";
		$sqlresult = mysql_query($sqlquery) or die(mysql_error()); // Run the query through the database

		if (mysql_affected_rows() > 0) {

			echo "MySQL query successful. The category has been deleted.<br/><br/>\n";

		}

		else {

			echo "Query unsuccessful. The category has not been deleted from the database. The category probably doesn't exist.<br/><br/>\n";

		}
		
		}
		
	else {
	echo "<p>Sorry, but that category cannot be deleted as it is the original category.</p>";
	}
		

	}

else if ($_GET['action']=='edit') {
	$category_id = $_GET['id'];
	$query = "SELECT * FROM categories WHERE id='$category_id'";
	$result = mysql_query ($query);
	if ($result) {
	while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
	
		$name = $row['name'];
		$parent = $row['parent'];
		$type = $row['type'];
		$url = $row['url'];
		$id = $row['id'];
		
		echo "<form name=\"edit_category\" method=\"post\" action = \"".$_SERVER['PHP_SELF']."\">";
		echo "<fieldset>";
		echo "<p>Category Name</p>";
		echo "<input type =\"text\" value =\"".$name."\" name=\"name\" />\n";
		echo "<p>Parent Category?</p>";
		echo "<input type =\"text\" value =\"".$parent."\" name=\"parent\" />\n";
		echo "<p>Category Type</p>";
		echo "<input type =\"text\" value =\"".$type."\" name=\"type\" readonly=\"readonly\" />\n";
		echo "<p>Category URL</p>";
		echo "<input type =\"text\" value =\"".$url."\" name=\"url\" />\n";
		echo "</fieldset>";
		echo "<input type = \"submit\" value =\"Submit\" name = \"submit\" />\n";
		echo "<input type=\"hidden\" name=\"id\" value =\"".$id."\" />";
		echo "</form>";
		}
	}
	else {
		echo "<p>Nothing found.</p>";
		}
	}

}

else {

$query = "SELECT * FROM categories WHERE type = 'post' ORDER BY name";

$queryresult = @mysql_query ($query);

if ($queryresult) { // If anything is found

		echo "<table>";
		echo "<tr>";
		echo "<td>Category</td>";
		echo "<td>Edit</td>";
		echo "<td>Delete</td>";
		echo "</tr>";

		while ($row = mysql_fetch_array($queryresult, MYSQL_ASSOC)) {
		
		echo "<tr>";
		echo "<td>".$row['name']."</td>";
		echo "<td><a href=\"categories.php?action=edit&amp;id=", $row['id'], "\" title=\"Edit this category\">Edit</a></td>";
		echo "<td><a href=\"categories.php?action=delete&amp;id=", $row['id'], "\" title=\"Delete this category\">Delete</a></td>";
		echo "</tr>";
		}

	echo "</table>";
	}

$newcategory = NULL;
$post_id = NULL;
$category = NULL;

if (isset($_POST['submitnewcategory'])) {

	$newcategory = $_POST['newcategory'];
	if ($newcategory == NULL) {

		echo "You did not enter a value for your new category. Blank values are not allowed.<br/><br/>\n";

	}

	else {

    $url = $newcategory;
		$url = strtolower($url);
		$url = str_replace(" ", "-", $url);
		$url = ereg_replace("[^A-Za-z0-9-]", "", $url);

		$parent = $_POST['parent'];

		$sql = "INSERT INTO categories (name, url, type, parent) VALUES ('$newcategory', '$url', 'post', '$parent');";

		$result = @mysql_query ($sql); // Run the query on the database! Important!

		if ($result) {

			echo "Your MySQL submission was successful.<br/><br/>\n";

		}

		else {

			echo "<p>Your MySQL submission was unsuccessful. Does the category already exist?</p>";
			echo "<p><blockquote>".mysql_error()."</blockquote></p>";

		}

	}

}

?>

<strong>Create a New Category</strong>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

	<input type="text" name="newcategory" size="30" tabindex="1" id="title" /><br/><br/>

	<label>Parent Category</label>

<?php
	$parentquery = "SELECT * FROM categories WHERE type='post' AND parent='Yes'";

	$result = @mysql_query ($parentquery); // Run the query through the database

	if ($result) { // If anything is found

		echo "<select name=\"parent\" size=\"1\">\n";
		echo "<option value=\"Yes\">None</option>\n";

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

			$value = $row['id'];
			$name = $row['name'];

			echo "<option value=\"$value\">$name</option>\n";

		}

		echo "</select>\n";

	}
	
?>
	
	<input type="submit" name="submitnewcategory" value="Insert Category" />

</form>

<?php

}

include '../includes/footer.php'; ?>
