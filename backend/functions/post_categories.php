<?php

if (!function_exists('post_categories')) {

	function post_categories() {

		$query = "SELECT * FROM categories WHERE type='post' AND parent='Yes' ORDER BY name ASC";
		$result = @mysql_query ($query);
		$num = mysql_num_rows ($result);
		if ($num > 0) {

			echo "<h2>Post Categories</h2>";
			echo "<ul>\n\n";
			while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {

			        echo "<li>\n<a href=\"".$globalhome.$categorybase.$row['url']."/\">".$row['name']."</a>\n";
			        $id = $row['id'];
			        $subquery = "SELECT * FROM categories WHERE type='post' AND parent='$id' ORDER BY name ASC";
			        $subresult = mysql_query ($subquery);
			        $num = mysql_num_rows ($subresult);
			        if ($num > 0) {
        
					echo "<ul>\n";
					while ($subrow = mysql_fetch_array ($subresult, MYSQL_ASSOC)) {
            
						echo "<li>\n<a href=\"".$globalhome.$categorybase.$subrow['url']."/\">".$subrow['name']."</a>\n</li>\n";
						}

					echo "</ul>\n";
					echo "</li>\n\n";
					}
				else {
					echo "</li>\n\n";
					}
				}
			echo "</ul>";
			}
		else {
			echo "<div class=\"announcement\">";
			echo "<p>No categories found.</p>";
			echo "</div>";
			}
		}
	}

post_categories();

?>
