<div id="left_sidebar">

		<h2>Recent Posts</h2>

		<?php

		$query = "SELECT * FROM posts WHERE status='published' AND frontpage = 'yes' ORDER BY post_id DESC LIMIT 0, 10";
		$result = @mysql_query($query);
		$num = @mysql_num_rows($result);
		if ($num > 0) {

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

?>



		<!--<h2>Recent Comments</h2>

		<?php

		$query = "SELECT * FROM comments WHERE status='approved' ORDER BY timestamp DESC LIMIT 0, 10";
		$result = @mysql_query($query);
		$num = mysql_num_rows($result);
		if ($num > 0) {

		echo "<ul>";

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$year = substr($searchrow['timestamp'], 0, 4);
			$month = substr($searchrow['timestamp'], 5, 2);
				$day = substr($searchrow['timestamp'], 8, 2);
				echo "<li><a href=\"".$globalhome.$year."/".$month."/".$day."/".$row['url']."/\">".$row['title']."</a></li>\n";

			}

		echo "</ul>";

		}

		else {

		echo "<ul><li>There are no comments in the database.</li></ul>";

		}

?>
-->

<h2>Post Categories</h2>

<?php

$query = "SELECT * FROM categories WHERE type='post' AND parent='Yes' ORDER BY name ASC";
$result = @mysql_query ($query);
$num = @mysql_num_rows ($result);
if ($num > 0) {

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

?>

	
</div>
