<?php

$message = NULL;
$parentpage = NULL;
$content = NULL;
$author = $_SESSION['user_id'];

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

if (isset($_POST['submitnewpage'])) { // Handle the form
	
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
		$message.= '<p>Your post or page is blank. This is not allowed. Please write something for people to read!</p>';
	}
	 else {
		$content = trim($_POST['content']);
	}

	if (isset($_POST['parentpage'])) {
        foreach ($_POST['parentpage'] as $key => $value) {		
			$parentpage .= "$value, ";
		}
		$parentpage = substr($parentpage, 0, -2);
    }
		
    $status = $_POST['status'];
    $timestamp = time();
	
	if ($title && $content && $author) { // Tests to see that everything is filled in correctly.
		
		// Make the query.
        $database->query('INSERT INTO `pages` (`author`, `timestamp`, `title`, `content`, `parent`, `status`, `url`) VALUES (:author, FROM_UNIXTIME(:timestamp), :title, :content, :parentpage, :status, :url)');
        $database->bind(':author', $author);
        $database->bind(':timestamp', $timestamp);
        $database->bind(':title', $title);
        $database->bind(':content', $content);
        $database->bind(':parentpage', $parentpage);
        $database->bind(':status', $status);
        $database->bind(':url', $url);
        $database->execute();
        
        if ($database->rowCount() == 1) {
			echo '<h1>Post Successful</h1>';
			echo '<p>Your post was successfully submitted to the database. Hurrah!</p>';

            include $_SERVER['DOCUMENT_ROOT'].'/backend/includes/footer.php'; // Include the HTML footer.
			exit(); // Quit the script.
			
		} else { // If it did not run OK.
			$message .= '<p>Your database submission was unsuccessful. Details are given below.</p><p>' . mysql_error() . '</p>'; 
		}

	} else {
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

<legend>Write a New Page</legend>

<label for=\"title\">Title: </label>
	<input type=\"text\" name=\"title\" size=\"50\" tabindex=\"1\" value=\""; if (isset($_POST['title'])) echo $_POST['title']; echo "\" id=\"title\" /><br/><br/>

<div id=\"categories\">

<label>Parent Page</label><br/><br/>\n";

$database->query('SELECT * FROM `pages`');
$rows = $database->resultSet();
if ($database->rowCount() > 0) {
    foreach ($rows as $row) {
        $page_title= $row['title'];
        $page_id = $row['id'];
        echo "<input type=\"checkbox\" name=\"parentpage[]\" value=\"".$page_id."\" tabindex=\"3\"/>".$page_title."<br/>\n";
    }
}
else {
    echo "<p>There are no pages. This must be a parent page.</p>";
}

echo "<br/>

<label>Status</label><br/><br/>

<input type=\"radio\" name=\"status\" value=\"draft\" checked=\"checked\" tabindex=\"4\"/>Draft
<br/>
<input type=\"radio\" name=\"status\" value=\"published\" tabindex=\"4\"/>Published
<br/>
<br/>

<input type=\"submit\" name=\"submitnewpage\" value=\"Save\" />

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
