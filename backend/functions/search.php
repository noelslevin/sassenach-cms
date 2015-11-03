<?php

if (!function_exists('search')) {

	function search() {
	
		global $globalhome;
		echo "<h2>Search ".$sitename."</h2>";
		echo "<div class=\"announcement\">";
		echo "<div class=\"search\">";
		echo "<form action=\"".$globalhome."search.php\" method=\"get\" id=\"searchbox\">";
		echo "<p>Use this search box to search the post archives.</p>";
		echo "<p><input type=\"text\" name=\"search\" size=\"40\" tabindex=\"1\" id=\"search\" /></p>";
		echo "<div class=\"center\"><input type=\"submit\" value=\"Search BUSY.org.uk\"/></div>";
		echo "</form>";
		echo "</div>";
		echo "</div>";
		}
	}

search();

?>
