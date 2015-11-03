<?php

session_start(); // Start the session.

// If no session is present, redirect the user.
if (!isset($_SESSION['username'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/../login.php");
	exit(); // Quit the script.
}

?>





<?php

// File specific variables go here.

$pagetitle="To Do List: Update";

?>





<?php include '../../includes/variables.php'; ?>
<?php include '../../includes/connection.php'; ?>
<?php include '../includes/header.php'; ?>

<h1>Noel's To Do List: Record Update</h1>

<?php

if (isset($_GET['action'])) {

	if ($_GET['action'] == 'delete') {

		if (isset($_GET['id'])) {
		
			$id = $_GET['id'];

			$update = "DELETE from todo WHERE id = $id";
			$result = @mysql_query ($update);
			if (mysql_affected_rows() == 1) {
			
				echo "<p>The database has been successfully updated.</p>";
			
			}
			
			else {
			
				echo "<p>Something didn't work. The database has not been updated.</p>";
			
			}
		
		}
		
		else {
		
			echo '<p>Your request is incomplete: please select a task to delete. Try following one of the links from the <a href="index.php">index page</a>.</p>';
		
		}

	}
	
	else if ($_GET['action'] == 'started') {
	
		if (isset($_GET['id'])) {
		
			$id = $_GET['id'];
			$update = "UPDATE todo SET status='In Progress', updated=NOW() WHERE id='$id'";
			$result = @mysql_query ($update);
			if (mysql_affected_rows() == 1) {
			
				echo "<p>The database has been successfully updated.</p>";
			
			}
			
			else {
			
				echo "<p>Something didn't work. The database has not been updated.</p>";
			
			}
		
		}
		
		else {
		
			echo '<p>Your request is incomplete: please select the task you have started. Try following one of the links from the <a href="index.php">index page</a>.</p>';
		
		}



	}
	
	else if ($_GET['action'] == 'finished') {
	
		if (isset($_GET['id'])) {

			$id = $_GET['id'];		
			$update = "UPDATE todo SET status='Implemented', updated=NOW() WHERE id='$id'";
			$result = @mysql_query ($update);
			if (mysql_affected_rows() == 1) {
			
				echo "<p>The database has been successfully updated.</p>";
			
			}
			
			else {
			
				echo "<p>Something didn't work. The database has not been updated.</p>";
			
			}
			
		}
		
		else {
		
			echo '<p>Your request is incomplete: please select the completed task. Try following one of the links from the <a href="index.php">index page</a>.</p>';
		
		}



	}

}

else {

echo '<p>Your request is incomplete: you have not specified a valid request. This page does nothing unless an action in specified. To use this page, follow one of the links from the <a href="index.php">index page</a>.</p>';

}

?>



<?php include '../includes/footer.php'; ?>
