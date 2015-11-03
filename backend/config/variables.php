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
	
		$query = "INSERT INTO options (variable, value, function) VALUES ('$variable', '$value', '$function')";
		$result = @mysql_query ($query);
		if ($result) { // If it ran OK.
		
			echo "<p>Your task was successfully entered into the database.</p>\n";

			$query = "SELECT * FROM options ORDER BY id ASC";
			$result = @mysql_query($query);
			if ($result) {
			
				echo "<table class=\"todo\">
				<tr>
				<td><strong>Variable</strong></td>
				<td><strong>Value</strong></td>
				<td><strong>Function</strong></td>
				</tr>\n";
				
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

					echo "<tr>
					<td>".$row['variable']."</td>
					<td>".$row['value']."</td>
					<td>".$row['function']."</td>
					</tr>\n";

				}

				echo "</table>\n";

			}			

			include '../includes/footer.php';
			exit();
			
		} 
		
		else {
			$message = "<p>Your database submission was unsuccessful. Details are given below.</p><p>" . mysql_error() . "</p>\n";
		}
		
		mysql_close();

	}
	
	 else {
		$message .= "<p>Please rectify these issues before re-submitting.</p>";
	}
	
}

echo "<p>You can use this page to update options that affect your Sassenach CMS installation, from where uploads are stored, to the active theme, and even to how permalinks are implemented. Information about each of these variables is avaliable in your documentation.</p>

<p>Once these are updated in the database, you can <a href=\"write_variables.php\">write them</a> to the variables file.</p>\n";


$query = "SELECT * FROM options ORDER BY id ASC";
$result = @mysql_query($query);
if ($result) {

	echo "<strong>Current Variables</strong><br/>
	<table class=\"todo\">
	<tr>
	<td><strong>Variable</strong></td>
	<td><strong>Value</strong></td>
	<td><strong>Function</strong></td>
	<td><strong>Edit</strong></td>
	</tr>\n";
	
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		echo "<tr>
		<td>".$row['variable']."</td>
		<td>".$row['value']."</td>
		<td>".$row['function']."</td>
		<td><a href=\"edit.php?id=".$row['id']."\">Edit</a></td>
		</tr>\n";

	}
	
	echo "</table>\n\n";

}
				
echo "<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" id=\"todo\">

<fieldset>

<legend>Create a New Variable</legend>

<table>

<tr>

<td><label>New Variable</label></td>
<td><input type=\"text\" name=\"variable\" size=\"40\" tabindex=\"1\" id=\"variable\" /></td>

</tr>

<tr>

<td><label>Value</label></td>
<td><input type=\"text\" name=\"value\" size=\"40\" tabindex=\"1\" id=\"value\" /></td>

</tr>


<tr>

<td><label>Function</label></td>
<td><textarea name=\"function\" cols=\"5\" rows=\"3\" id=\"function\">What does this function do?</textarea><br/><br/></td>

</tr>

</table>


</fieldset>

<div align=\"center\"><input type=\"submit\" name=\"variablesubmit\" value=\"Save\" /></div>

</form>\n";

?>
