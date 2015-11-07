<?php

$message = NULL;
$postcategories = NULL;

echo "<script language=\"javascript\" type=\"text/javascript\" src=\"".$globalhome.$backend."/tinymce/jscripts/tiny_mce/tiny_mce.js\"></script>
<script language=\"javascript\" type=\"text/javascript\">
tinyMCE.init({
	theme : \"advanced\",
	skin : \"o2k7\",
	mode : \"textareas\",
	relative_urls : false,
	remove_script_host : false,
	document_base_url : \"".$globalhome.$uploads."\"

});
</script>\n";

if (isset($_POST['content'])) { // Handle the form.
	
	// Check post or page name.
	if (empty($_POST['title'])) {
		$title = FALSE;
        $message .= '<p>Your post or page needs a title.</p>';
    }
    else {
		$title = trim($_POST['title']);
		$url = strtolower($title);
		$url = str_replace(" ", "-", $url);
		$url = ereg_replace("[^A-Za-z0-9-]", "", $url);
    }
	
	// Check for content to the post or page.
	if (empty($_POST['content'])) {
		$content = FALSE;
		$message .= '<p>Your post or page is blank. This is not allowed. Please write something for people to read!</p>';
	}
	elseif ($_POST['content']== '<p>&nbsp;</p>') {
        $content = FALSE;
		$message.= '<p>Your post or page is blank. This is not allowed. Please write something for people to read!</p>';
    }
	 else {
		$content = trim($_POST['content']);
     }
	
    if (isset($_POST['categories'])) {
        foreach ($_POST['categories'] as $key => $value) {
            $postcategories .= "$value, ";
        }
		$postcategories = substr($postcategories, 0, -2);
    }
    else {
        // Assign to the General category
        $postcategories = 1;
    }
    
    if (isset($_POST['frontpage'])) {
        $frontpage = $_POST['frontpage'];
    }
    else {
        // Do not display on homepage
        $frontpage = 'no';
    }
    
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
    }
    else {
        // Do not publish
        $status = 'draft';
    }
    
    if ($status == 'published') {
        // Only set timestamp if publishing
        $timestamp = time();
    }
    else {
        $timestamp = NULL;
    }
	
	if ($title && $content && $postcategories && $status && $frontpage && $url) { // Tests to see that everything is filled in correctly.
        $database->query('INSERT INTO `posts` (`title`, `url`, `content`, `categories`, `frontpage`, `status`, `author`, `published`) VALUES (:title, :url, :content, :categories, :frontpage, :status, :author, FROM_UNIXTIME(:timestamp))');
        $database->bind(':title', $title);
        $database->bind(':url', $url);
        $database->bind(':content', $content);
        $database->bind(':categories', $postcategories);
        $database->bind(':frontpage', $frontpage);
        $database->bind(':status', $status);
        $database->bind(':author', $_SESSION['user_id']);
        $database->bind(':timestamp', $timestamp);
        $database->execute();
        
        if ($database->rowCount() == 1) {
            // Inform the user.
			echo '<h1>Post Successful</h1>';
			echo '<p>Your post was successfully submitted to the database. Hurrah!</p>';
			include 'rss_create.php';
            include $_SERVER['DOCUMENT_ROOT'].'/backend/includes/footer.php'; // Include the HTML footer.
			exit(); // Quit the script.
        }
        
        else { // If it did not run OK.
			$message = '<p>Your database submission was unsuccessful.</p>'; 
		}
    }
    
    else {
		$message .= '<p>These issues must be rectified before your submission to the database is successful.</p>';		
	}

} // End of the main Submit conditional.

// Print the message if there is one.
if (isset($message)) {
	echo '<p>Unfortunately, there were errors with your database submission. These are described below.</p>'.$message;
}

echo "<div id=\"tinymce\">

<form action=\"/".$page."\" method=\"post\" id=\"write\">

<fieldset>

<legend>Write a New Post</legend>

<label for=\"title\">Title: </label>
	<input type=\"text\" name=\"title\" size=\"50\" tabindex=\"1\" value=\""; if (isset($_POST['title'])) echo $_POST['title']; echo "\" id=\"title\" /><br/><br/>

<div id=\"categories\">

<label>Categories</label><br/><br/>\n";

$database->query('SELECT * FROM `categories` WHERE `type`=:post ORDER BY `name` ASC');
$database->bind(':post', 'post');
$rows = $database->resultSet();
if ($database->rowCount() > 0) {
    foreach ($rows as $row) {
        $category = $row['name'];
        $categoryid = $row['id'];
        echo "<input type=\"checkbox\" name=\"categories[]\" value=\"".$categoryid."\" tabindex=\"3\"/>".$category."<br/>\n";
    }
}

echo "<br/>

<label>Status</label><br/><br/>

<input type=\"radio\" name=\"status\" value=\"draft\" checked=\"checked\" tabindex=\"4\"/>Draft<br/>

<input type=\"radio\" name=\"status\" value=\"published\" tabindex=\"4\"/>Published<br/><br/>

<label>Frontpage Post?</label><br/><br/>

<input type=\"radio\" name=\"frontpage\" value=\"yes\" tabindex=\"4\"/>Yes<br/>

<input type=\"radio\" name=\"frontpage\" value=\"no\" checked=\"checked\" tabindex=\"4\"/>No<br/><br/>

<input type=\"submit\" name=\"submitnewpost\" value=\"Save\" />

</div>

<textarea name=\"content\" id=\"post\" class=\"mceEditor\" cols=\"130\" rows=\"25\">\n";

if (isset($_POST['content'])) {
    echo $_POST['content'];
}
	
echo "</textarea>

</fieldset>

</form>

</div>\n";

?>
