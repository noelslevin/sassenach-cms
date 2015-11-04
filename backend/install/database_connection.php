<?php

// File specific variables go here.

$pagetitle="Install Sassenach CMS: Database Connection";

?>

<?php include 'header.php'; ?>

<h1>Connecting To The Database</h1>

<?php

if (isset($_POST['submit'])) {

	$db_name = $_POST['db_name'];
	$db_user = $_POST['db_user'];
	$db_password = $_POST['db_password'];
	$db_hostname = $_POST['db_hostname'];
	
	$dbh = @mysql_connect($db_hostname, $db_user, $db_password);
	if ($dbh) {
		echo "<p>User and password successfully connected. Attempting to connect to the database.</p>";
		$db_connect = mysql_select_db ($db_name);
		if ($db_connect) {
			echo "<p>Connection successfully established. Now attempting to write database connection file.</p>";
			$fp = @fopen ("../../includes/connection.php", "w");
			if ($fp) {
				fwrite ($fp, "<?php\n\n");
				fwrite ($fp, "\$dbusername = \"$db_user\";\n");
				fwrite ($fp, "\$dbpassword = \"$db_password\";\n");
				fwrite ($fp, "\$dbhostname = \"$db_hostname\";\n\n");
				fwrite ($fp, "\$dbh = @mysql_connect(\$dbhostname, \$dbusername, \$dbpassword)\n");
				fwrite ($fp, "or die (\"Unable to connect to MySQL.\");\n\n");
				fwrite ($fp, "mysql_select_db ('$db_name')\n\n");
				fwrite ($fp, "?>");
				fclose ($fp);
				
				echo "<p>The data was successfully written to the connection file.</p>";
				
				echo "<p><a href=\"set_up_database.php\">Continue</a></p>";
				}
			else {
				echo "<p>Could not write to file. You either need to make the connection file writeable, go back to the previous page and try again, or you should upload the file yourself. If you want to upload the file yourself, then copy the following text box into a plain text editor, save it as \"connection.php\" and upload it to \"includes/\" directory at the root of your Sassnenach installation.</p>\n\n";
				
				echo "<textarea cols=\"60\" rows=\"11\" id=\"description\" readonly=\"readonly\"><?php\n\n\$dbusername = \"$db_user\";\n\$dbpassword = \"$db_password\"\n\$dbhostname = \"$db_hostname\";\n\n\$dbh = @mysql_connect(\$dbhostname, \$dbusername, \$dbpassword)\nor die (\"Unable to connect to MySQL.\");\nmysql_select_db ($db_name)\n\n?></textarea>";
				
				echo "<p>So, either go back and try again, having made the file writeable, or upload the file yourself and <a href=\"test_connection.php\">confirm this</a> so that we can make sure that everything has worked properly!.</p>";
				}

			}
		else {
			echo "<p>Sorry, but the database did not appear to be found.</p>";
			echo "<p>".mysql_error()."</p>";
			}
	}
	
	else {
		echo "<p>Sorry, but the database connection could not be established.</p>";
		echo "<p>".mysql_error()."</p>";
		}

?>

<?php

}

else {

?>

<form name="database_details" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<fieldset>

<p>Database Name<br/><input type="text" name="db_name" value="<?php if (isset($_POST['db_name'])) echo $_POST['db_name'] ;?>" /><br/>
<small>This is the name of the database we are connecting to. You may need to just include the database name, e.g. 'db_name', or you may need to prefix it with your MySQL account's username, e.g. 'username_dbname'.</small></p>

<p>Database Username<br/><input type="text" name="db_user" value="<?php if (isset($_POST['db_user'])) echo $_POST['db_user'] ;?>" /><br/>
<small>This is the username used to connect to the database. This user needs full access privileges. Again, you may need to supply your MySQL account's username as a prefix.</small></p>

<p>Database Password<br/><input type="text" name="db_password" value="<?php if (isset($_POST['db_password'])) echo $_POST['db_password'] ;?>" /><br/>
<small>This is the password required for the database username supplied above.</small></p>

<p>Database Hostname<br/><input type="text" name="db_hostname" value="<?php if (isset($_POST['db_hostname'])) { echo $_POST['db_hostname']; } else { echo "localhost"; } ?>"/><br/>

<small>This value rarely needs changing. If you don't know what it is, leave it like this!</small></p>

<input type="submit" value="Set Up Connection" name="submit" />

</fieldset>
</form>

<?php

}

?>

<?php include 'footer.php'; ?>
