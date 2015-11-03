<?php

    $yeararchive = "SELECT * FROM posts WHERE substring(timestamp,1,4) = '$year' ORDER BY timestamp DESC LIMIT 0,10";
    $year_result = mysql_query ($yeararchive);
    $num = mysql_num_rows ($year_result);
    if ($num > 0) {
    
        while ($year_row = mysql_fetch_array ($year_result, MYSQL_ASSOC)) {
        
            echo "<h2>".$year_row['title']."</h2>";
        
        }
    
    }
    
    else {
    
        echo "<h2>Archive Results: ".$year."</h2>";
        echo "<p>Nothing was found in the database. There are no entries for that year.</p>";
    
    }
    
?>