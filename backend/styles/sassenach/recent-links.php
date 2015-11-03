<?php

$query = "SELECT * FROM recent_links ORDER BY timestamp DESC LIMIT 0,5";
$result = mysql_query ($query);
if ($result) {

	echo "<h2>Recent Links</h2>";
	echo "<ul>";

	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

		$link = $row['link'];
		$title = $row['title'];
		$description = $row['description'];
		$timestamp = $row['timestamp'];

		echo "<li><a href=\"".$link."\" title=\"".$description."\">".$title."</a> (<small>".$timestamp.")</small></li>";

	}

	echo "</ul>";
	echo "<small><a href=\"http://www.noelinho.org/recent-links/index.php\">View all recent links</a></small>";

}

?>
