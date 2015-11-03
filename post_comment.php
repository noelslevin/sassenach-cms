<?php

include 'includes/variables.php';
include 'includes/connection.php';
include $backend.'styles/'.$style.'header.php';
include $backend.'styles/'.$style.'left_sidebar.php';

echo '<div id="content">';

if (isset($_POST[submitcomment])) {
	$message = NULL;
	
	
	if ($_POST['trap'] != NULL) {
    echo "<h1>Error: Comment Rejected</h1>";
		echo "<p>Your comment has been assessed as spam and has been rejected.</p>";
	}
	
	else {
		
		$post_id = $_POST['post_id'];
		$site = $_POST['site'];
		$site = addslashes($site);
			
		if ($_POST['name'] != NULL) {
			$name = $_POST['name'];
			$name = addslashes($name);
		}
		else {
			$message .= "<p>You have not filled in your name.</p>";
		}
		
		if ($_POST['email'] != NULL) {
			$email = $_POST['email'];
			$email = addslashes($email);
		}
		else {
			$message .= "<p>You have not filled in your email address.</p>";
		}
		
		if ($_POST['comment'] != NULL) {
			$comment = $_POST['comment'];
			$comment = addslashes($comment);
		}
		else {
			$message .= "<p>You have not expressed any opinions or commented on the post!</p>";
		}
		
		if ($message == NULL) {
		
			$query = "INSERT INTO comments (name, email, website, timestamp, comment, post_id) VALUES ('$name', '$email', '$site', NOW(), '$comment', '$post_id')";
			$result = @mysql_query($query);
			if ($result) {
        echo "<h1>Comment Submitted</h1>";
				echo "<p>Your comment submission was successful. It will appear on the website after moderation.</p>";
				echo $website;
			}
		
			else {
				echo "<p>Your comment submission was not successful. Please try again.</p>";
			}
		
		}
		
		else {
      echo "<h1>Error: Comment Not Submitted</h1>";
			echo "<p>There are problems with your comment. These are detailed below.</p>";
			echo $message;
		}
		
	}

}

else {
  echo "<h1>Error: Nothing Here</h1>";
	echo "<p>You have arrived at this page in error. This page does nothing more than process comments.</p>";
}

echo "</div>";

include $backend.'styles/'.$style.'right_sidebar.php';
include $backend.'styles/'.$style.'footer.php';

?>
