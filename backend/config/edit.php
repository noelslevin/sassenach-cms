<?php

session_start(); // Start the session.

// If no session is present, redirect the user.
if (!isset($_SESSION['username'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/../login.php");
	exit(); // Quit the script.
}

// File specific variables go here.

$pagetitle="Options: Edit Options";

include '../../includes/variables.php';
include '../../includes/connection.php';
include '../includes/header.php';

?>

<h1>Options: Edit Variable</h1>

<?php

if (isset($_POST['variablesubmit'])) {

	// Create a function for escaping the data.
	function escape_data ($data) {
		global $dbh; // Need the connection.
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		return mysql_real_escape_string($data, $dbh);
	} // End of function.

	$message = NULL; // Create an empty new variable.

	if (empty($_POST['variable'])) {
		$variable = FALSE;
		$message .= '<p>Your variable needs a name.</p>';
	} 
	
	else {
		$variable = escape_data($_POST['variable']);
	}
	
	if (empty($_POST['value'])) {
		$value = FALSE;
		$message .= '<p>Your variable needs a value.</p>';
	} 
	
	else {
		$value = escape_data($_POST['value']);
	}
	
	if (empty($_POST['function'])) {
		$function = FALSE;
		$message .= '<p>Your variable needs an explanation.</p>';
	} 
	
	else {
		$function = escape_data($_POST['function']);
	}
	
	if ($variable && $value && $function) {
	
	$id = $_POST['id'];
	
	$updatequery = "UPDATE options SET variable='$variable', value='$value', function='$function' WHERE id='$id'";
	$updateresult = mysql_query($updatequery);
	if (mysql_affected_rows() > 0) { // If it ran OK.

    echo "<p>The option was successfully updated in the database.</p>";

}

else {

    echo "<p>The option was not updated. The was an error updating the record in the database.</p>";

}

}

else {

    echo "<p>There is a problem with the data you submitted. Please check the data and re-submit.</p>";

}

}

else if (isset($_GET['id'])) {
$id = $_GET['id'];

$query = "SELECT * FROM options WHERE id = '$id'";
$result = mysql_query($query);
$num = mysql_num_rows($result);
if ($num > 0) {

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="todo">

<fieldset>

<legend>Update a Variable</legend>

<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>" />

<table>

<tr>

<td><label>Variable Name</label></td>
<td><input type="text" name="variable" size="40" tabindex="1" id="variable" value="<?php echo $row['variable']; ?>" /></td>
</tr>

<tr>

<td><label>Value</label></td>
<td><input type="text" name="value" size="40" tabindex="1" id="value" value="<?php echo $row['value']; ?>" /></td>

</tr>


<tr>

<td><label>Function</label></td>
<td><textarea name="function" cols="5" rows="3" id="function"><?php echo $row['function']; ?></textarea><br/><br/></td>

</tr>

</table>


</fieldset>

<div align="center"><input type="submit" name="variablesubmit" value="Save" /></div>

</form>

<?php

}

}

else {

    echo "<p>Nothing found.</p>";

}

}

else {

    echo "<p>You have not accessed this page appropriately.</p>";

}

?>

<?php include '../includes/footer.php'; ?>
