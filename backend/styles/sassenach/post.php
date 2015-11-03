<?php

                $url = $_GET['title'];
                $query = "SELECT * FROM posts WHERE url = '$url' AND substring(timestamp,1,10) = '$fulldate' AND STATUS = 'published'";
                $result = @mysql_query ($query);
                $num = mysql_num_rows ($result);
                if ($num > 0) {
		
                    while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
		
                        ?>
                        
                        <div class="creativecommons">
                        <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.0/uk/"><img alt="Creative Commons License" src="http://i.creativecommons.org/l/by-nc-nd/2.0/uk/88x31.png"/></a>
                        </div>
                        
                        <?php
		
                        echo "<h1>".$row['title']."</h1>\n";
                        
                        echo $row['content']."\n";
                        $post_id = $row['post_id'];
                        ?>
                        
                        <div class="licence">This work by <a href="http://www.noelinho.org">Noel Slevin</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.0/uk/">Creative Commons Attribution-Non-Commercial-No Derivative Works 2.0 UK: England &amp; Wales License</a>.
                        </div>
                        
                        <?php
                        
                        include $backend.'styles/'.$style.'comments.php';
			
			}
		}
		
		else {
		
		
			echo "<h2>Error: Invalid Request</h2>";
			echo "<p>The post could not be found. If this page has been found via a link on the website, please report it as a broken link.</p>";
		
		}	
		
?>