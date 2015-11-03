<?php

if (!function_exists('pages')) {

	function pages() {

		global $globalhome;
		echo "<div id=\"links\">";
		echo "<ul>";
		echo "<li><a href=\"".$globalhome."\">Home</a></li>";
		$query = "SELECT * FROM pages WHERE parent='0' AND status='published' ORDER BY title ASC";
		$result = @mysql_query ($query);
		$num = mysql_num_rows ($result);
		if ($num > 0) {

			while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
				echo "<li><a href=\"".$globalhome.$row['url']."/\">".$row['title']."</a></li>\n";
    				}
			}
		echo "</ul>";
		echo "</div>";
		}
	}

pages();

?>
