<?php

if (!function_exists('subpage')) {

	function subpage() {

		global $page;
	        $subpage = $_GET['subpage'];
	        $parentquery = "SELECT * FROM pages WHERE url = '$page' AND status='published'";
	        $parentresult = mysql_query($parentquery);
	        $num = mysql_num_rows ($parentresult);
	        if ($num == 1) {
        
			while ($row = mysql_fetch_array($parentresult, MYSQL_ASSOC)) {
            
		                $parentcategory = $row['id'];
		                $subpagequery = "SELECT * FROM pages WHERE url = '$subpage' AND parent = '$parentcategory' AND status='published'";
		                $subpageresult = mysql_query ($subpagequery);
		                $num = mysql_num_rows ($subpageresult);
		                if ($num == 1) {
                
					while ($row = mysql_fetch_array($subpageresult, MYSQL_ASSOC)) {
                    
						echo "<h2>".$row['title']."</h2>";
			                        echo $row['content'];
						}
			                }
				else {
					echo "<p>The page was not found in the database.</p>";
					}
				}
			}
		else {
			echo "<p>Nothing was found in the database.</p>";
			}
		}
	}

subpage();

?>
