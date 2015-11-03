<?php

if (!function_exists('recent_posts')) {

	function recent_posts() {

		$query = "SELECT * FROM posts WHERE status='published' AND frontpage = 'yes' ORDER BY post_id DESC LIMIT 0, 10";
		$result = mysql_query($query);
		$num = mysql_num_rows($result);
		if ($num > 0) {

			echo "<h2>Recent Posts</h2>";
			echo "<ul>";

			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$year = substr($row['timestamp'], 0, 4);
				$month = substr($row['timestamp'], 5, 2);
				$day = substr($row['timestamp'], 8, 2);
				echo "<li><a href=\"".$globalhome.$year."/".$month."/".$day."/".$row['url']."/\">".$row['title']."</a></li>\n";
				}
			echo "</ul>";
			}
		else {
			echo "<ul><li>There are no posts in the database.</li></ul>";
			}
		}
	}

recent_posts();

?>
