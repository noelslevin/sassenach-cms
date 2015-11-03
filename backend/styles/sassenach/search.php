<h1>Search Noelinho.org</h1>

<?php

if (isset($_POST['sitesearch'])) {

    $searchstring = $_POST['search'];
    $searchstring = addslashes($searchstring);

    $searchquery = "SELECT * FROM posts WHERE MATCH (content, title) AGAINST ('+\"$searchstring\"' IN BOOLEAN MODE) ORDER BY timestamp DESC";
    $searchresult = @mysql_query ($searchquery);
    $num = @mysql_num_rows ($searchresult);
    if ($num > 0) {
        
        echo "<p>Your search returned ".$num." results. They are listed below with the most recent returned first.</p>";
        
        while ($searchrow = mysql_fetch_array ($searchresult, MYSQL_ASSOC)) {
            $year = substr($searchrow['timestamp'], 0, 4);
            $month = substr($searchrow['timestamp'], 5, 2);
            $day = substr($searchrow['timestamp'], 8, 2);
            echo "<h2><a href=\"".$globalhome.$year."/".$month."/".$day."/".$searchrow['url']."/\">".$searchrow['title']."</a></h2>";
        
        }
    
    }
    
    else {
    
        echo "<p>Your search returned nothing from the database.</p>";
    
    }

}

else {

    echo "<p>Please use the search box located in the right sidebar to search the website. Please note, only posts are searched using this feature.</p>";

}

?>
