<?php

		$fulldate = $year."-".$month."-".$date;

            if (isset($_GET['title'])) {
		
                include $backend.'styles/'.$style.'post.php';
		
		}
		
		else {
		
		$query = "SELECT * FROM posts WHERE DATE_FORMAT(timestamp, '%Y, %m, %d') = '$year, $month, $date' AND STATUS = 'published'";
		$result = @mysql_query ($query);
		$num = mysql_num_rows ($result);

		echo "<h1>Post Archives: ".$date."/".$month."/".$year."</h1>";

		if ($num > 0) {
		
			while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			
				echo "<h2><a href=\"".$globalhome.$year."/".$month."/".$date."/".$row['url']."/\">".$row['title']."</a></h2>\n";
				$excerpt = explode("</p>", $row['content']);
				echo $excerpt[0]."<br/>";
				echo "<small><a href=\"".$globalhome.$year."/".$month."/".$date."/".$row['url']."/\">Read the full post</a></small></p>\n";
			
			}
		}
		
		else {
		
		
		
			echo 	"<h2>Error: Invalid Request</h2>";
			echo	"<p>There are no posts from ".$month."/".$year.".</p>";
		
		}
		
	
	}
	
?>
