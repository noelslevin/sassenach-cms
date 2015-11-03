<?php

// open a file pointer to an RSS file
    $fp = fopen ("../../includes/variables.php", "w");

    fwrite ($fp, "<?php\n");

$query = "SELECT * FROM options";
$result = @mysql_query($query);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $variable = addslashes($row['variable']);
    $value = addslashes($row['value']);
    $function = addslashes($row['function']);
    fwrite ($fp, "$$variable = '$value'; // $function \n");

}

    fwrite ($fp, "?>");
    fclose ($fp);
    echo "<p>The variables in the database should have been succesfully updated to the variables file.</p>";  
?>
