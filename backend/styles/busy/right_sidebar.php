<div id="right_sidebar">

<h2>Search BUSY.org.uk</h2>

<div class="announcement">
<div class="search">

<form action="<?php echo $globalhome; ?>" method="post" id="searchbox">

<p>Use this search box to search the post archives.</p>

<p><input type="text" name="search" size="40" tabindex="1" id="search" /></p>

<div class="center"><input type="submit" value="Search BUSY.org.uk"/></div>

</form>

</div>
</div>

<?php

$categoriesquery = "SELECT * FROM categories WHERE type='link'";
$categoriesresult = mysql_query ($categoriesquery);
$num = mysql_num_rows ($categoriesresult);
if ($num > 0) {

    while ($row = mysql_fetch_array ($categoriesresult, MYSQL_ASSOC)) {
    
        $category = $row['name'];
        $id = $row['id'];

        echo "<h2>Links: ".$category."</h2>";

		$query = "SELECT * FROM links WHERE category ='$id' ORDER BY name ASC";
		$result = @mysql_query($query);
		$num = mysql_num_rows($result);
		if ($num > 0) {

		echo "<ul>";

		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

			echo "<li><a href=\"".$row['link']."\" title=\"".$row['description']."\">".$row['name']."</a></li>";

			}

		echo "</ul>";

		}

		else {

		echo "<ul><li>There are no links in the database.</li></ul>";

		}
		
		}
		
		}

		?>




</div>
