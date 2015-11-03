<?php

session_start(); // Start the session.

// If no session is present, redirect the user.
if (!isset($_SESSION['username'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/../login.php");
	exit(); // Quit the script.
}

// File specific variables go here.

$pagetitle="Comment Moderation";

include '../../includes/variables.php';
include '../../includes/connection.php';
include '../includes/header.php';

echo "<h1>Comment Moderation</h1>";

if (isset($_POST['submit'])) {
	$comment = ($_POST['comment']);
	$comment = htmlentities($comment);
	$email = $_POST['email'];
	$website = $_POST['website'];
	$name = $_POST['name'];
	$id = $_POST['comment_id'];
	if ($comment && $email && $name && $id) {
		$query = "UPDATE comments SET name = '$name', website = '$website', email = '$email', comment = '$comment' WHERE id = '$id'";
		$result = @mysql_query ($query);
		if (mysql_affected_rows() == 1) {
			echo "<p>The comment was successfully updated.</p>";
			}
		else {
			echo "<p>The comment was not updated.</p>";
			echo "<p>".mysql_error()."</p>";
			}
		}
	}

else if (isset($_GET['action'])) {


	if ($_GET['action'] == 'approve') {

		if (isset($_GET['comment_id'])) {

			$comment_id = $_GET['comment_id'];
			$query = "UPDATE comments SET status = 'approved' WHERE id = '$comment_id'";
			$result = @mysql_query($query);

			if (mysql_affected_rows() > 0) {
				echo "<p>The comment was successfully approved.</p>";
				}

			else {
				echo "<p>The comment could not be approved.</p>";
				}
			}
		
		else {
			echo "<p>No comment has been selected. No action can be taken.</p>";
			}
		}

	
	else if ($_GET['action'] == 'delete') {
	
		if (isset($_GET['comment_id'])) {
			$comment_id = $_GET['comment_id'];
			$query = "DELETE FROM comments WHERE id = '$comment_id'";
			$result = @mysql_query ($query);
			if ($result) {
				echo "<p>The comment was deleted.</p>";
				}
			else {
				echo "<p>The comment was not deleted.</p>";
				echo "<p>".mysql_error()."</p>";
				}
			}
		else {
			echo "<p>No comment has been selected. No action can be taken.</p>";
			}
		}
	
	else if ($_GET['action'] == 'edit') {
		if (isset($_GET['comment_id'])) {
			$comment_id = $_GET['comment_id'];
			$query = "SELECT * FROM comments WHERE id = '$comment_id'";
			$result = @mysql_query ($query);
			if ($result) {
				echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">";
				echo "<fieldset>";
				while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
					echo "<p>Name:<br/>";
					echo "<input type=\"text\" name=\"name\" value=\"".$row['name']."\" /></p>";
					echo "<p>Email:<br/>";
					echo "<input type=\"text\" name=\"email\" value=\"".$row['email']."\" /></p>";
					echo "<p>Website:<br/>";
					echo "<input type=\"text\" name=\"website\" value=\"".$row['website']."\" /></p>";
					echo "<p>Comment:</p>";
					echo "<textarea name=\"comment\" cols=\"60\" rows=\"10\">".htmlentities($row['comment'])."</textarea>";
					echo "<input type=\"hidden\" name=\"comment_id\" value=\"".$row['id']."\" />";
					}

				echo "<p><input type=\"submit\" value=\"Edit Comment\" name=\"submit\" /></p>";
				echo "</fieldset>";
				echo "</form>";
				}
			else {
				echo "<p>The requested comment was not found in the database.</p>";
				echo "<p>".mysql_error()."</p";
				}
			}
		else {
			echo "<p>No comment has been selected. No action can be taken.</p>";
			}
		}
	}

?>



<?php include '../includes/footer.php'; ?>
