<?php

if (!function_exists('category')) {

	function category() {

		$category = $_GET['category'];
		$catquery = "SELECT * FROM categories WHERE url = '$category'";
		$catresult = mysql_query($catquery);
		$num = mysql_num_rows ($catresult);
		if ($num > 0) {

			while ($catrow = mysql_fetch_array ($catresult, MYSQL_ASSOC)) {
				$category_id = $catrow['id'];
				$category_name = $catrow['name'];
				}

			$categoryquery = "SELECT * FROM posts WHERE categories = '$category_id' OR categories LIKE '%, $category_id' OR categories LIKE '$category_id,%' ORDER BY timestamp DESC LIMIT 0, 10";
			$categoryresult = mysql_query($categoryquery);
			$num = mysql_num_rows ($categoryresult);
			if ($num > 0) {

				echo "<h1>Category: ".$category_name."</h1>";
				while ($row = mysql_fetch_array ($categoryresult, MYSQL_ASSOC)) {
					echo "<h2>".$row['title']."</h2>";
					echo $row['content'];
					}
				}
			else {
				echo "<h2>Category: ".$category_name."</h2>";
				echo "<p>There do not appear to be any posts in this category.</p>";
				}
			}
		else {
			echo "<h2>Error</h2>";
			echo "<p>The category you are looking for does not exist. Try one of the others listed below.</p>";
			$query = "SELECT * FROM categories WHERE type='post' ORDER BY name ASC";
			$result = mysql_query ($query);
			$num = mysql_num_rows ($result);
			if ($num > 0) {
				while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
					echo "<h2><a href=\"".$globalhome.$categorybase.$row['url']."\">".$row['name']."</a></h2>";
					}
				}
			}
		}
	}

category();

?>
