<?php

		$query = "SELECT * FROM posts WHERE DATE_FORMAT(timestamp, '%Y, %m') = '$year, $month' AND STATUS = 'published'";
		$result = @mysql_query ($query);
		$num = mysql_num_rows ($result);
		if ($num > 0) {
		
		echo "<h1>Post Archives: ".$month."/".$year."</h1>";

			while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			
				$date = substr($row['timestamp'], 8,2);
				echo "<h2><a href=\"".$globalhome.$year."/".$month."/".$date."/".$row['url']."/\">".$row['title']."</a></h2>\n";
				echo "<p><small>".$row['timestamp']."</small></p>\n";
				$excerpt = explode("</p>", $row['content']);
				echo $excerpt[0]."<br/>";
				echo "<small><a href=\"".$globalhome.$year."/".$month."/".$date."/".$row['url']."/\">Read the full post</a></small></p>\n";				

			}
		}
		
		else {
		
			echo 	"<h2>Error: Invalid Request</h2>";
			echo	"<p>There are no posts in the database that meet your request.</p>";
		
		}
	
?>
