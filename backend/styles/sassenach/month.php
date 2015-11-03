<?php

		$query = "SELECT * FROM posts WHERE DATE_FORMAT(timestamp, '%Y, %m') = '$year, $month' AND STATUS = 'published'";
		$result = @mysql_query ($query);
		$num = mysql_num_rows ($result);
		if ($num > 0) {
		
			while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			
        $date = substr($row['timestamp'], 8,2);
				echo "<h1><a href=\"".$globalhome.$year."/".$month."/".$date."/".$row['url']."/\">".$row['title']."</a></h1>\n";
				echo $row['timestamp']."<br/>\n";
			
			}
		}
		
		else {
		
			echo 	"<h2>Error: Invalid Request</h2>";
			echo	"<p>There are no posts from the year ".$year.".</p>";
		
		}
	
?>