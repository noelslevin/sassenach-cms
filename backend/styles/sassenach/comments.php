<?php

$commentsquery = "SELECT * FROM comments WHERE post_id = '$post_id' AND STATUS = 'approved' ORDER BY timestamp DESC";
                        $commentsresult = @mysql_query ($commentsquery);
                        $num = mysql_num_rows ($commentsresult);
                        if ($num > 0) {

                        if ($num == 1) {
			echo "<p>There is currently ".$num." comment on this article.</p>";

			}

			else {

			echo "<p>There are currently ".$num." comments on this article.</p>";

			}


                            while ($row = mysql_fetch_array ($commentsresult, MYSQL_ASSOC)) {
                                echo $row['name']."<br/>\n";
                                echo $row['website']."<br/>\n";
                                echo $row['comment']."<br/>\n";
                                echo $row['timestamp']."<br/>\n";
                                }
                             }
				
                             else {
				
                                echo "<p>There are currently no comments on this article.</p>";
				
                            }
		
				
				if (isset($_POST['name'])) {
					$name = $_POST['name'];
					echo $name;
				}
				if (isset($_POST['email'])) {
					$email = $_POST['email'];
				}
				if (isset($_POST['site'])) {
					$site = $_POST['site'];
				}
				if (isset($_POST['comment'])) {
					$comment = $_POST['comment'];
				}

        echo "<div id=\"comments\">
				<form action=\"".$globalhome."post_comment.php\" method=\"post\" id=\"comment\">
				<fieldset>
				<legend>Submit a Comment</legend>
				<label><small>Name</small></label>
				<p><input type=\"text\" name=\"name\" size=\"40\" tabindex=\"1\" value=\"".$name."\" id=\"name\" /></p>
        <label><small>Email Address</small></label>
				<p><input type=\"text\" name=\"email\" size=\"40\" tabindex=\"2\" value=\"".$email."\" id=\"email\" /></p>
				<label><small>Website</small></label>
				<p><input type=\"text\" name=\"site\" size=\"40\" tabindex=\"3\" value=\"".$site."\" id=\"site\" /></p>
        <label><small>Comment(s)</small></label>
				<p><textarea name=\"comment\" cols=\"50\" rows=\"5\" tabindex=\"4\" id=\"response\">".$comment."</textarea></p>
				<input type=\"hidden\" name=\"post_id\" value=\"".$post_id."\" id=\"post_id\" />
				<div class=\"hidden\">
				If you are human, do not fill this. It will cause your comment to be rejected!
				<input type=\"text\" name=\"trap\" id=\"trap\" />
				</div>
				</fieldset>
				<div class=\"center\">
				<input type=\"submit\" name=\"submitcomment\" tabindex=\"5\" value=\"Save\" />
				</div>
				</form>
				</div>";
				
?>
