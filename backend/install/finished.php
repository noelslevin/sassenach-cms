<?php

// File specific variables go here.

$pagetitle="Install Sassenach CMS: Installation Complete";

?>

<?php include 'header.php'; ?>

<h1>Everything's Ready...</h1>

<?php

if (isset($_POST['submit'])) {
	include ('../../includes/connection.php');
	$query = "UPDATE options SET value='up' WHERE id=20";
	$result = @mysql_query ($query);
	if ($result) {
		include ('write_variables.php');
		include '../../includes/variables.php';
		echo "<p>And we're done. Easy, eh?</p>";
		echo "<p><a href=\"".$globalhome."\">Go to homepage</a></p>";
		}
	else {
		echo "<p>It didn't work. We were so close too!</p>";
		echo "<p>".mysql_error()."</p>";
		}
	}

else {
	echo "<p>Final step now. All we need to do is enable the site. All we need to do is hit the button!</p>";
	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">";
	echo "<input type=\"submit\" name=\"submit\" value=\"Let's go live!\" />";
	echo "</form>";
	}

?>

<?php include 'footer.php'; ?>