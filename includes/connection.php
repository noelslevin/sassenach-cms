<?php

header ("Location:  backend/install/");
	exit(); // Quit the script.

$dbusername = "";
$dbpassword = "";
$dbhostname = "localhost";

$dbh = @mysql_connect($dbhostname, $dbusername, $dbpassword)
or die ("Unable to connect to MySQL.");

mysql_select_db ()

?>