<?php

// Page specific variables

$pagetitle="Log In";

include '../includes/variables.php';

function get_sassenach_function($function) {
	global $backend;
	$sassenach_function = '../'.$backend.'functions/'.$function.'.php';
	include $sassenach_function;
	}

include '../includes/db-config.php';
include '../includes/database.class.php';
include '../'.$backend.'styles/'.$style.'header.php';

echo "<div class=\"content\">";

echo "<h1>Authentication Required</h1>\n";

echo "<form action=\"process.php\" method=\"post\" id=\"login\">

<fieldset>
<legend>Please Log In</legend>

<div align=\"center\">
<table>
<tr>
<td><label>User Name:</label></td>
<td><input type=\"text\" name=\"username\" size=\"30\" maxlength=\"20\" value=\""; if (isset($_POST['username'])) echo $_POST['username']; echo "\" /></td>
</tr>
<tr>
<td><label>Password:</label></td>
<td><input type=\"password\" name=\"password\" size=\"30\" maxlength=\"16\" /></td>
</tr>
</table>
<input type=\"submit\" name=\"login\" value=\"Login\" />
</div>
</fieldset>
</form>

<a href=\"reset-password.php\">I can't remember my password</a>";

echo "</div>";

include '../'.$backend.'styles/'.$style.'footer.php';

?>
