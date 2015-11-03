<?php

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

	// Create a function for escaping the data.
	function escape_data ($data) {
		global $dbh; // Need the connection.
		if (ini_get('magic_quotes_gpc')) {
			$data = stripslashes($data);
		}
		return mysql_real_escape_string($data, $dbh);
	} // End of function.

	$message = NULL; // Create an empty new variable.
	
	// Check post or page name.
	if (empty($_POST['title'])) {
		$title = FALSE;
		$message .= '<p>Your post or page needs a title.</p>';
	} else {
		$title = escape_data($_POST['title']);
		$url = $title;
		$url = strtolower($url);
		$url = str_replace(" ", "-", $url);
		$url = ereg_replace("[^A-Za-z0-9-]", "", $url);

	}
	
	// Check for content to the post or page.
	if (empty($_POST['content'])) {
		$content = FALSE;
		$message .= '<p>Your post or page is blank. This is not allowed. Please write something for people to read!</p>';
	}

	else if ($_POST['content']== '<p>&nbsp;</p>') {
	
		$message.= '<p>Your post or page is blank. This is not allowed. Please write something for people to read!</p>';
	
	}
	
	 else {
		$content = trim(escape_data($_POST['content']));

	}

	$postcategories = NULL;
	if (isset($_POST['categories'])) {
	
		foreach ($_POST['categories'] as $key => $value) {
		
			$postcategories .= "$value, ";
		
		}
	
		$postcategories = substr($postcategories, 0, -2);
		
		}
		
		else {
		
			$postcategories = 1;
		
		}
   $frontpage = $_POST['frontpage'];
	$status = $_POST['status'];

	
	// Check for an author. It should not be possible to fail this test!
	if (empty($_POST['author'])) {
		$author = FALSE;
		$message .= '<p>This post appears to have no author. This is not possible! A critical error has occurred. Please inform the application developer immediately.</p>';
	} else {
		$author = escape_data($_POST['author']);
	}
	
	if ($title && $content && $author && $postcategories) { // Tests to see that everything is filled in correctly.
		
		// Make the query.
		$query = "INSERT INTO posts (author, timestamp, title, content, categories, status, url, frontpage) VALUES ('$author', NOW(), '$title', '$content', '$postcategories', '$status', '$url', '$frontpage')";		
		$result = @mysql_query ($query); // Run the query.
		if ($result) { // If it ran OK.
		
			// Inform the user.
			echo '<h1>Post Successful</h1>';
			echo '<p>Your post was successfully submitted to the database. Hurrah!</p>';
			include '../rss_create.php';
include ('../includes/footer.php'); // Include the HTML footer.
			exit(); // Quit the script.
			
		} else { // If it did not run OK.
			$message = '<p>Your database submission was unsuccessful. Details are given below.</p><p>' . mysql_error() . '</p>'; 
		}
		
		mysql_close(); // Close the database connection.

	} else {
		$message .= '<p>These issues must be rectified before your submission to the database is successful.</p>';		
	}

} // End of the main Submit conditional.

// Print the message if there is one.
if (isset($message)) {
	echo '<p>Unfortunately, there were errors with your database submission. These are described below.</p>'.$message;
}

echo "<div id=\"tinymce\">

<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" id=\"write\">

<fieldset>

<legend>Write a New Post</legend>

<label for=\"title\">Title: </label>
	<input type=\"text\" name=\"title\" size=\"50\" tabindex=\"1\" value=\""; if (isset($_POST['title'])) echo $_POST['title']; echo "\" id=\"title\" /><br/><br/>

<div id=\"categories\">

<label>Categories</label><br/><br/>\n";

$linkquery = "SELECT * FROM categories WHERE type='post' ORDER BY name ASC";

$result = @mysql_query ($linkquery); // Run the query through the database

if ($result) { // If anything is found

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

$category = $row['name'];
$categoryid = $row['id'];

echo "<input type=\"checkbox\" name=\"categories[]\" value=\"".$categoryid."\" tabindex=\"3\"/>".$category."<br/>\n";

}

}

echo "<br/>

<label>Status</label><br/><br/>

<input type=\"radio\" name=\"status\" value=\"draft\" checked=\"checked\" tabindex=\"4\"/>Draft
<br/>
<input type=\"radio\" name=\"status\" value=\"published\" tabindex=\"4\"/>Published
<br/>
<br/>

<label>Frontpage Post?</label><br/><br/>
                        
                        <input type=\"radio\" name=\"frontpage\" value=\"yes\" tabindex=\"4\"/>Yes
                        <br/>
                        
                        <input type=\"radio\" name=\"frontpage\" value=\"no\" checked=\"checked\" tabindex=\"4\"/>No
                        <br/>
                        
                        <br/>

<input type=\"submit\" name=\"content\" value=\"Save\" />

<input type=\"hidden\" name=\"author\" value=\"".$_SESSION['user_id']."\" />

</div>

<textarea name=\"content\" id=\"post\" class=\"mceEditor\" cols=\"130\" rows=\"25\">\n";

	if (isset($_POST['content'])) { 
	
	$content = $_POST['content']; 
	
	$content = stripslashes($content);
	
	echo $content; }
	
	echo "</textarea>

</fieldset>

</form>

</div>\n";

?>
