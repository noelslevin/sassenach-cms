<?php

$id = 0;
$feedquery = "SELECT * FROM categories WHERE parent='yes' AND type='post' ORDER BY 'id' ASC";
$feedresult = @mysql_query ($feedquery);
$feednum = @mysql_num_rows ($feedresult);
if ($feednum > 0) {

    while ($feedrow = mysql_fetch_array ($feedresult, MYSQL_ASSOC)) {


        $category_id = $feedrow['id'];
        $postquery = "SELECT * FROM posts WHERE status = 'published' AND categories = '$category_id' OR categories LIKE '%, $category_id' OR categories LIKE '$category_id,%' OR categories LIKE '%, $category_id,%' ORDER BY timestamp DESC LIMIT 0,1";
        $postresult = @mysql_query ($postquery);
        $postnum = @mysql_num_rows ($postresult);
        if ($postnum == 1) {
        
            while ($postrow = mysql_fetch_array ($postresult, MYSQL_ASSOC)) {
                
                $year = substr($postrow['timestamp'], 0, 4);
                $month = substr($postrow['timestamp'], 5, 2);
                $day = substr($postrow['timestamp'], 8, 2);
                
                echo "<div class=\"lastpost\" id=\"".$feedrow['name']."\">";
                echo "<h4><a href=\"".$globalhome.$categorybase.$feedrow['url']."/\">".$feedrow['name']."</a></h4>";
                echo "<h3><a href=\"".$globalhome.$year."/".$month."/".$day."/".$postrow['url']."/\">".$postrow['title']."</a></h3>";
                echo "<div class=\"text\">";
                echo $postrow['content'];
                echo "</div>";
                echo "</div>";
            
            }
        
        }
        
        else {
        
		echo "<h1>Error</h1>";
		echo "<p>Nothing was found in the database.</p>";
        
        }
    
    }

}

else {

    echo "<p>No categories found. This page will do nothing.</p>";

}

?>
