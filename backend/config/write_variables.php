<?php

if (isset($_POST['submit'])) {

// open a file pointer to an RSS file
    $fp = fopen ("../includes/variables.php", "w");

    fwrite ($fp, "<?php\n");

$query = "SELECT * FROM options";
$result = @mysql_query($query);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $variable = addslashes($row['variable']);
    $value = addslashes($row['value']);
    $function = addslashes($row['function']);

    echo "<blockquote>
    <p>". $variable. " = '". $value. "' // ". $function. ";</p>
    </blockquote>\n";
    
    fwrite ($fp, "$$variable = '$value'; // $function \n");

}

    fwrite ($fp, "?>");
    fclose ($fp);
    
echo "<p>The variables in the database should have been succesfully updated to the variables file.</p>\n";

}

else {
	echo "<p>If you are happy with the variables as they appear in the database, you can now write them to the variables file. Only when the variables have been written to that file are the changes applied to the website.</p>
	
	<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" id=\"write_variables\">
	<input type=\"submit\" name=\"content\" value=\"Write Variables\" />
	</form>";
	}

?>
