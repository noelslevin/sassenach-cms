<?php

// File specific variables go here.

$pagetitle="Install Sassenach CMS: Site Details";

?>

<?php include 'header.php'; ?>

<h1>Site Details</h1>

<?php

if (isset($_POST['submit'])) {
	include ('../../includes/db-config.php');
	include ('../../includes/database.class.php');
	$sitename = $_POST['sitename'];
	$siteaddress = $_POST['siteaddress'];
	$query = "UPDATE options SET value='$siteaddress' WHERE id=1"; 
	$query2 = "UPDATE options SET value='$sitename' WHERE id=3";
	
	$database->query($query);
	$database->execute();

	$database->query($query2);
	$database->execute();

	echo "<p>The details were successfully updated in the database.</p>";
	include ('write_variables.php');
	if ($fp) {
		echo "<p><a href=\"new_user.php\">Continue</a></p>";
	}

	}

else {

	echo "<p>Now we have set up the base system, we need to add a couple of details about your website.</p>";

	echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">";
	echo "<fieldset>";

	echo "<p>Site Name:<br/>";
	echo "<input type=\"text\" name=\"sitename\" size=\"40\" value=\"\" /></p>";

	echo "<p>Site Address:<br/>";
	echo "<input type=\"text\" name=\"siteaddress\" size=\"40\" value=\"\" /></p>";

	echo "</fieldset>";

	echo "<input type=\"submit\" name=\"submit\" value=\"Submit\" />";

	echo "</form>";
	}

?>

<?php include 'footer.php'; ?>
