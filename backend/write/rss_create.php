    <?php

    // open a file pointer to an RSS file
    $fp = fopen ($_SERVER['DOCUMENT_ROOT']."/rss.xml", "w");

    // Now write the header information
    fwrite ($fp, "<?xml version=\"1.0\" ?>\n<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n<channel>\n");

    fwrite ($fp, "<atom:link href=\"http://www.noelinho.org/rss.xml\" rel=\"self\" type=\"application/rss+xml\" />\n");

    fwrite ($fp, "<title>$sitename</title>\n");

    fwrite ($fp, "<link>$globalhome</link>\n");

    fwrite ($fp, "<description>The site feed for $sitename</description>\n");

    fwrite ($fp, "<language>en-gb</language>\n");

    fwrite ($fp, "<docs>$globalhome$globalrss</docs>\n");

$content_sql = "SELECT * FROM posts WHERE status='published' ORDER BY timestamp DESC LIMIT 0,10";

$content_result = mysql_query($content_sql);
    
while ($row = mysql_fetch_array($content_result, MYSQL_ASSOC)) {
    
        fwrite ($fp, "<item>\n");

        $headline = $row['title'];
        $pubDate = $row['timestamp'];
        
        $date = strtotime($pubDate);
        $newdate = date("D, j M Y H:i:s O", $date);
        
        $content_1 = $row['content'];
        $content = htmlspecialchars($content_1);
        
	$old = "nbsp;";
	$new = "#160;";
	$content = str_replace($old, $new, $content);
        
        fwrite ($fp, "<title>$headline</title>\n");
        fwrite ($fp, "<description>$content</description>\n");

        $item_link1 = $globalhome;
        
        $item_link2 = substr($row['timestamp'], 0, 4);
        $item_link3 = substr($row['timestamp'], 5, 2);
        $item_link4 = substr($row['timestamp'], 8, 2);
        $item_link5 = $row['url'];
        $forwardslash = "/";
        
        /*$date = $row['timestamp'];
        
        $day_query = "SELECT DATE_FORMAT('$date', '%a')";
        $day_result = mysql_query($day_query);
        if ($day_result) {
            while ($rows = mysql_fetch_array ($day_result, MYSQL_ASSOC)) {
            
            $day = $rows[0];
            
            }
        }*/

        fwrite ($fp, "<link>$item_link1$item_link2$forwardslash$item_link3$forwardslash$item_link4$forwardslash$item_link5$forwardslash</link>\n");
        fwrite ($fp, "<guid>$item_link1$item_link2$forwardslash$item_link3$forwardslash$item_link4$forwardslash$item_link5$forwardslash</guid>\n");
        fwrite ($fp, "<pubDate>$newdate</pubDate>\n");

        fwrite ($fp, "</item>\n");
    }

    fwrite ($fp, "</channel>\n</rss>\n");
    fclose ($fp);
    echo "<p>RSS feed updated.</p>";

    ?>
