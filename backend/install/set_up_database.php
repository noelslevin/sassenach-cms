<?php

// File specific variables go here.

$pagetitle="Install Sassenach CMS: Setting Up The Database";

?>

<?php include 'header.php'; ?>

<h1>Setting Up The Database</h1>

<?php

if (isset($_POST['submit'])) {
	include ('../../includes/db-config.php');
	include ('../../includes/database.class.php');
  
  $sql = file_get_contents('sassenach.sql');
  $database->query($sql);
  $database->execute();
  echo "<p>The database is now ready to use.</p>";
  echo "<p><a href=\"site_details.php\">Continue</a></p>";
}
  
else {

	echo "<p>Having connected to the database, we now need to create the database structure the system uses. Please note, any tables with the same names as the Sassenach tables will be overwritten, and so it is recommended that you use an empty database.</p>";

	echo "<p>If you are using a database that is not empty, please back it up before continuing, and check that the tables Sassenach is about to create will not interfere with any existing data.</p>";

	echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
	echo "<input type=\"submit\" name=\"submit\" value=\"Populate Database\" />";
	echo "</form>";
	}

?>

<?php include 'footer.php'; ?>
