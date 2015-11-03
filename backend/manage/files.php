<h1>Files</h1>

<p>In this section, you can manage the files that appear alongside posts and pages on your website.</p>

<?php

$searchquery = "SELECT * FROM files ORDER BY id DESC";
$searchresult = mysqL_query ($searchquery);
$num = mysql_num_rows ($searchresult);
if ($num > 0) {

    echo "<p>There are ".$num. " files in the database.</p>";
    echo "<table>";
    echo "<tr>";
    echo "<td>Title</td>";
    echo "<td>Type</td>";
    echo "<td>Description</td>";
    echo "<td>URL</td>";
    echo "<td>Filesize</td>";
    echo "<td>Preview</td>";
    echo "<td>Attach</td>";
    echo "</tr>";

    while ($row = mysql_fetch_array($searchresult, MYSQL_ASSOC)) {
    
        echo "<tr>";
        echo "<td>".$row['title']."</td>";
        echo "<td>".$row['type']."</td>";
        echo "<td>".$row['description']."</td>";
        echo "<td>".$row['url']."</td>";
        echo "<td>".$row['filesize']."</td>";
        echo "<td><a href=\"#\" onclick=\"window.open('".$globalhome.$uploads.$row['url']."','_blank','toolbar=no,menubar=no,location=no,directories=0,status=0,scrollbars=0,resize=0');\">Preview</a></td>";
        echo "<td><a href=\"#\" onclick=\"window.open('attach.php','_blank', 'width=600,height=300, toolbar=no,menubar=no,location=no,directories=0,status=0,scrollbars=0,resize=0');\">Attach</a></td>";
        
        echo "</tr>";
    
    }
    
    echo "</table>";

}

else {

    echo "<p>No files were found in the database.</p>";

}

?>

<form enctype="multipart/form-data" action="uploader.php" method="post">
<fieldset>
<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
<p>File Name:<br/><input type="text" name="title" id="title" /></p>
<p>File Description:<br/><input type="text" name="description" id="description" /></p>
<p>File:<br/><input name="uploadedfile" type="file" /></p>
</fieldset>
<input type="submit" value="Upload File" />
</form>
