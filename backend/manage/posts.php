<?php

session_start(); // Start the session.

// If no session is present, redirect the user.
if (!isset($_SESSION['username'])) {
	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/../login.php");
	exit(); // Quit the script.
}

// Page specific variables go here.

$pagetitle="Manage";

include '../../includes/variables.php';
include '../../includes/connection.php';
include '../includes/tinymceheader.php'; ?>

<h1>Manage</h1>

<p>Here, you can manage and edit existing articles and/or pages on the website.</p>

<?php

if (isset($_POST['update'])) {

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
	$post_id = $_POST['post_id'];
	// Check for an author. It should not be possible to fail this test!
	if (empty($_POST['author'])) {
		$author = FALSE;
		$message .= '<p>This post appears to have no author. This is not possible! A critical error has occurred. Please inform the application developer immediately.</p>';
	}
	
	else {
		$author = escape_data($_POST['author']);
	}
	
	if ($title && $content && $postcategories) { // Tests to see that everything is filled in correctly.
				// Make the query.
		$query = "UPDATE posts SET title='$title', content='$content', categories='$postcategories', status='$status', frontpage='$frontpage', updated=NOW() WHERE post_id='$post_id'";		
		$result = @mysql_query ($query); // Run the query.
		if (mysql_affected_rows() > 0) { // If it ran OK.
		
			// Inform the user.
			echo '<h1>Post Successful</h1>';
			echo '<p>Your post was successfully updated. Hurrah!</p>';

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

else if (isset($_GET['action'])) {

    if (($_GET['action']) == 'delete') {
    
        if (($_GET['type']) == 'post') {
        
            if (isset($_GET['post_id'])) {
            
                $post_id = $_GET['post_id'];
                $query = "DELETE FROM posts WHERE post_id='$post_id'";
                $result = @mysql_query ($query);
                if (mysql_affected_rows() > 0) {
                
                    echo "<p>The post was successfully deleted from the database.</p>";
                
                }
                
                else {
                
                    echo "<p>Nothing appears to have happened. The post was not deleted from the database. Perhaps that post doesn't exist.</p>";
                
                }
            
            }
            
            else {
            
                echo "<p>No post id specified. No action can be taken without this.</p>";
            
            }
        
        }
    
    }
    
    else if (($_GET['action']) == 'publish') {
    
        if (($_GET['type']) == 'post') {
        
            if (isset($_GET['post_id'])) {

                    $post_id = $_GET['post_id'];
                    $query = "UPDATE posts SET status='published' WHERE post_id='$post_id'";
                    $result = @mysql_query ($query);
                    if (mysql_affected_rows() == 1) {
                    
                        echo "<p>The post was successfully published.</p>";
                    
                    }
                    
                    else {
                    
                        echo "<p>Nothing was updated. Does the post exist?</p>";
                    
                    }
            
            }
            
            else {
            
                    echo "<p>No post id specified. The system doesn't know which post to publish.</p>";
            
            }
            
        }
    
    }
    
    else if (($_GET['action']) == 'unpublish') {
    
        if (($_GET['type']) == 'post') {
        
            if (isset($_GET['post_id'])) {

                    $post_id = $_GET['post_id'];
                    $query = "UPDATE posts SET status='draft' WHERE post_id='$post_id'";
                    $result = @mysql_query ($query);
                    if (mysql_affected_rows() == 1) {
                    
                        echo "<p>The post was successfully unpublished.</p>";
                    
                    }
                    
                    else {
                    
                        echo "<p>Nothing was updated. Does the post exist?</p>";
                    
                    }
            
            }
            
            else {
            
                    echo "<p>No post id specified. The system doesn't know which post to unpublish.</p>";
            
            }
            
        }
    
    }
    
    
    else if (($_GET['action']) == 'edit') {
    
        if (($_GET['type']) == 'post') {
        
            if (isset($_GET['post_id'])) {

                    $post_id = $_GET['post_id'];
                    $query = "SELECT * FROM posts WHERE post_id='$post_id'";
                    $result = @mysql_query ($query);
                    $num = mysql_num_rows ($result);
                    if ($num > 0) {
                        
                        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                        
                        $content = $row['content'];
                        $author = $row['author'];
                        $post_id = $row['post_id'];
			$status = $row['status'];
			$frontpage = $row['frontpage'];
			$categories = $row['categories'];
                        
                        ?>
                        
                        <div id="tinymce">
                        
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="write">
                        
                        <input type="hidden" name="author" value="<?php echo $author; ?>" />
                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />

                        <fieldset>

                        <legend>Edit a Post</legend>

                        <label for="title">Title: </label>

                        <input type="text" name="title" size="30" tabindex="1" value="<?php echo $row['title']; ?>" id="title" /><br/><br/>

                        <div id="categories">
                        
                        <label>Categories</label><br/><br/>
                        
                        <?php
                        
                        $linkquery = "SELECT * FROM categories WHERE type='post' ORDER BY name ASC";

                        $result = @mysql_query ($linkquery); // Run the query through the database

                        if ($result) { // If anything is found

                            while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

                                $category = $row['name'];
                                $category_id = $row['id'];

                                echo '<input type="checkbox" name="categories[]" value="', $category_id, '" />', $category, '<br/>', "\n";

                                }

                        }
                        
                        ?>
                        
                        <br/>

                        <label>Status</label><br/><br/>
                        
                        <input type="radio" name="status" value="draft" <?php if ($status == 'draft') { echo "checked=\"checked\""; } ?> tabindex="4"/>Draft
                        <br/>
                        <input type="radio" name="status" value="published" <?php if ($status == 'published') { echo "checked=\"checked\""; } ?>tabindex="4"/>Published
                        <br/>
                        <br/>
                        
                        <label>Frontpage Post?</label><br/><br/>
                        
                        <input type="radio" name="frontpage" value="yes" <?php if ($frontpage == 'yes') { echo "checked=\"checked\""; } ?> tabindex="4"/>Yes
                        <br/>
                        
                        <input type="radio" name="frontpage" value="no" <?php if ($frontpage == 'no') { echo "checked=\"checked\""; } ?> tabindex="4"/>No
                        <br/>
                        
                        <br/>
                        
                        <input type="submit" name="update" value="Save" />
                        
                        </div>

                        <textarea name="content" id="post" class="mceEditor" cols="130" rows="25">
                        <?php echo htmlentities($content); ?></textarea>
                        </fieldset>
                        </form>
                        </div>
                        
                        <?php
                        
                        }
                    
                    }
                    
                    else {
                    
                        echo "<p>Nothing was found. Does the post exist?</p>";
                    
                    }
            
            }
            
            else {
            
                    echo "<p>No post id specified. The system doesn't know which post you want to edit.</p>";
            
            }
            
        }
    
    }

}

else {

$query = "SELECT * from posts WHERE status = 'draft' ORDER By timestamp ASC";
$result = @mysql_query ($query);

$num = @mysql_num_rows($result);

if ($num > 0) {

	if ($num == 1) {
	
	echo "<p>There is currently $num unpublished post in the database.</p>";
	
	}
	
	else {

	echo "<p>There are currently $num unpublished posts in the database.</p>";

	}

	echo "<table class=\"todo\"><tr><td><strong>Post Title</strong></td><td><strong>Timestamp</strong></td><td><strong>Edit</strong></td><td><strong>Delete</strong></td><td><strong>Publish</strong></td></tr>";

	while ($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
	
		echo "<tr><td>".$row['title']."</td><td>".$row['timestamp']."</td><td><a href=\"posts.php?action=edit&amp;type=post&amp;post_id=".$row['post_id']."\">Edit</a></td><td><a href=\"posts.php?action=delete&amp;type=post&amp;post_id=".$row['post_id']."\">Delete</a></td><td><a href=\"posts.php?action=publish&amp;type=post&amp;post_id=".$row['post_id']."\">Publish</a></td></tr>";
	
	}

	echo "</table>";

}

else {

	echo "<p>There are no unpublished posts.</p>";

}

$query = "SELECT * from posts WHERE status = 'published' ORDER By timestamp DESC";
$result = @mysql_query ($query);

$num = @mysql_num_rows($result);

if ($num > 0) {

	if ($num == 1) {
	
	echo "<p>There is currently $num published post in the database.</p>";
	
	}

	else {

	echo "<p>There are currently $num published posts in the database.</p>";

	}

	echo "<table class=\"todo\"><tr><td><strong>Post Title</strong></td><td><strong>Timestamp</strong></td><td><strong>Edit</strong></td><td><strong>Delete</strong></td><td><strong>Unpublish</strong></td></tr>";

	while ($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
	
		echo "<tr><td>".$row['title']."</td><td>".$row['timestamp']."</td><td><a href=\"posts.php?action=edit&amp;type=post&amp;post_id=".$row['post_id']."\">Edit</a></td><td><a href=\"posts.php?action=delete&amp;type=post&amp;post_id=".$row['post_id']."\">Delete</a></td><td><a href=\"posts.php?action=unpublish&amp;type=post&amp;post_id=".$row['post_id']."\">Unpublish</a></td></tr>";
	
	}

	echo "</table>";

}

else {

	echo "<p>No published posts found.</p>";

}

$query = "SELECT * from posts WHERE status = 'private' ORDER By timestamp DESC";
$result = @mysql_query ($query);

$num = @mysql_num_rows($result);

if ($num > 0) {

	echo "<p>There are currently $num private posts in the database.</p>";

	echo "<table class=\"todo\"><tr><td><strong>Post Title</strong></td><td><strong>Timestamp</strong></td><td><strong>Edit</strong></td><td><strong>Delete</strong></td><td><strong>Unpublish</strong></td></tr>";

	while ($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
	
		echo "<tr><td>".$row['title']."</td><td>".$row['timestamp']."</td><td><a href=\"posts.php?action=edit&amp;type=post&amp;post_id=".$row['post_id']."\">Edit</a></td><td><a href=\"posts.php?action=delete&amp;type=post&amp;post_id=".$row['post_id']."\">Delete</a></td><td><a href=\"posts.php?action=unpublish&amp;type=post&amp;post_id=".$row['post_id']."\">Unpublish</a></td></tr>";
	
	}

	echo "</table>";

}

}

?>

<?php include '../includes/footer.php'; ?>
