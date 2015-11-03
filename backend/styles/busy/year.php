<?php

    $yeararchive = "SELECT * FROM posts WHERE substring(timestamp,1,4) = '$year' ORDER BY timestamp DESC";
    $year_result = mysql_query ($yeararchive);
    $num = mysql_num_rows ($year_result);
    if ($num > 0) {

	echo "<h1>Post Archives: ".$year."</h1>";
    
        while ($year_row = mysql_fetch_array ($year_result, MYSQL_ASSOC)) {

		$month = substr($year_row['timestamp'], 5, 2);
		$date = substr($year_row['timestamp'], 8, 2);        
            echo "<h2><a href=\"".$globalhome.$year."/".$month."/".$date."/".$year_row['url']."/\">".$year_row['title']."</a></h2>";
		$excerpt = explode("</p>", $year_row['content']);
		echo $excerpt[0]."<br/>";
		echo "<small><a href=\"".$globalhome.$year."/".$month."/".$date."/".$year_row['url']."/\">Read the full post</a></small></p>\n";
		
        
        }
    
    }
    
    else {
    
        echo "<h2>Archive Results: ".$year."</h2>";
        echo "<p>Nothing was found in the database. There are no entries for that year.</p>";
    
    }
    
?>
