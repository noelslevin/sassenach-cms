<?php

if (!function_exists('page')) {

	function page() {

		global $page;
		$pagequery = "SELECT * FROM pages WHERE url = '$page' AND status='published'";
		$pageresult = mysql_query($pagequery);
		$num = mysql_num_rows($pageresult);
		if ($num > 0) {
    
			while ($row = mysql_fetch_array($pageresult, MYSQL_ASSOC)) {
        
				echo "<h1>".$row['title']."</h1>\n";
				echo $row['content']."\n";            
				}
			}        
		else {
			echo "<p>The page you requested could not be found in the database.</p>";
			}
		}
	}

page();

?>
