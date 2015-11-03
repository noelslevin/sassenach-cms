<?php

                $url = $_GET['title'];
                $query = "SELECT * FROM posts WHERE url = '$url' AND substring(timestamp,1,10) = '$fulldate' AND STATUS = 'published'";
                $result = @mysql_query ($query);
                $num = mysql_num_rows ($result);
                if ($num > 0) {
		
                    while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		
                        ?>
                        
                        <?php
		
                        echo "<h1>".$row['title']."</h1>\n";
                        $php = 'on';
			if ($php == 'on') {
			eval ('?>' . $row['content'] . '<?php ');

			}
			else {

                        echo $row['content']."\n";
                        $post_id = $row['post_id'];

			}

			if ($comments == on) {
                        include $backend.'styles/'.$style.'comments.php';
			}
			
			}
		}
		
		else {
		
		
			echo "<h2>Error: Invalid Request</h2>";
			echo "<p>The post could not be found. If this page has been found via a link on the website, please report it as a broken link.</p>";
		
		}	
		
?>
