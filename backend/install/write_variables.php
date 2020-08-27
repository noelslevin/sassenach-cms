<?php

// open a file pointer to an RSS file
$fp = @fopen ("../../includes/variables.php", "w");

if ($fp) {
    fwrite ($fp, "<?php\n");

    $query = "SELECT * FROM options";
    $database->query($query);
    $database->execute();

    $rows = $database->resultset();
    foreach ($rows as $row) {
        $variable = addslashes($row['variable']);
        $value = addslashes($row['value']);
        $function = addslashes($row['function']);
        fwrite ($fp, "$$variable = '$value'; // $function \n");
    }

    fwrite ($fp, "?>");
    fclose ($fp);
    echo "<p>The variables in the database have been succesfully updated to the variables file.</p>"; 
}

else {
    echo "<p>Could not write to file. Please make the file /includes/variables.php writable by your web server, then try again.</p>";
}

?>
