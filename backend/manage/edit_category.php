<?php

session_start(); // Start the session.

// If no session is present, redirect the user.
if (!isset($_SESSION['username'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 

"/../login.php");
	exit(); // Quit the script.
}

// File specific variables go here.

$pagetitle="Links: Categories";

include '../../includes/variables.php';
include '../../includes/connection.php';
include '../includes/header.php';

?>

<h1>Update A Category</h1>

<?php

if (isset($_POST['submit'])) {
	$name = addslashes($_POST['name']);
	$type = addslashes($_POST['type']);
	$url = addslashes($_POST['url']);
	$parent = addslashes($_POST['parent']);
	$id = $_POST['id'];
	$query = "UPDATE categories SET name='$name', url='$url', parent='$parent' WHERE id='$id'";
		$result = mysql_query ($query);
		if (mysql_affected_rows() > 0) {
			echo "<p>The category was successfully updated.</p>";
			}
			
		else {
			echo "<p>The category was not updated. Either an error occurred, or you did not change any of the details already stored in the database.</p>";
			}
	
	}

else if (isset($_GET['action'])) {
	if ($_GET['action'] == 'edit') {
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$query = "SELECT * FROM categories WHERE (id='$id') AND (type='link')";
			$result = mysql_query($query);
			if ($result) {			
				while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
					$name = stripslashes($row['name']);
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
				echo "<p>Nothing was found in the database</p>";
				}
			}
		else {
			echo "<p>No I.D. set. This script will not work.</p>";
			}
		}
	else {
		echo "<p>Incorrect action set. This script will do nothing.</p>";
		}
	}
else {
	echo "<p>No action set. This script will do nothing.</p>";
	}

?>

<?php include '../includes/footer.php'; ?>
