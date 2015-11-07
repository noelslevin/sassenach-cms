<?php

echo "<h1>Links</h1>\n";

$message = NULL;

if (isset($_POST['submitnewcategory'])) { // Handle the form.
	
	// Check the link has a title.
	if (empty($_POST['newcategory'])) {
		$newcategory = FALSE;
		$message .= '<p>Your new category needs a name.</p>';
	}
    else {
		$newcategory = trim($_POST['newcategory']);
	}
	
	$type = ($_POST['newcategorytype']);
	$parent = ($_POST['parent']);
    
    if ($newcategory && $type && $parent) {
    
        $database->query('INSERT INTO `categories` (`name`, `parent`, `type`) VALUES (:newcategory, :parent, :type)');
        $database->bind(':newcategory', $newcategory);
        $database->bind(':parent', $parent);
        $database->bind(':type', $type);
        $database->execute();
        if ($database->rowCount() == 1) {
            echo "The new category has been added to the database.<br/><br/>";
        }
        else {
            echo "<p>The new category has not been added to the database.", $message."</p>";
        }
    }
} // End of submitnewcategory conditional

if (isset($_POST['submitnewlink'])) { // Handle the form.
	
	// Check the link has a title.
	if (empty($_POST['linkname'])) {
		$linkname = FALSE;
		$message .= '<p>Your link needs a name.</p>';
	} 
    else {
		$linkname = trim($_POST['linkname']);
	}
	
	// Check the link has an address.
	if (empty($_POST['linkurl'])) {
		$linkurl = FALSE;
		$message .= '<p>Your link needs an address.</p>';
	}
    else {
		$linkurl = trim($_POST['linkurl']);
	}
	
	// Check the link has a description.
	if (empty($_POST['linkdescription'])) {
		$linkdescription = FALSE;
		$message .= '<p>Your link needs a short description.</p>';
	} else {
		$linkdescription = trim($_POST['linkdescription']);
	}
	
	$linkcategories = NULL;
	if (isset($_POST['categoryid'])) {
		foreach ($_POST['categoryid'] as $key => $value) {
			$linkcategories .= "$value, ";
		}
		$linkcategories = substr($linkcategories, 0, -2);
    }
    else {
        $linkcategories = NULL;
        echo "<p>No categories have been selected.</p>";
    }
	
	if ($linkname && $linkdescription && $linkurl && $linkcategories) {
        $database->query('INSERT INTO `links` (`name`, `description`, `link`, `category`) VALUES (:linkname, :linkdescription, :linkurl, :linkcategories)');
        $database->bind(':linkname', $linkname);
        $database->bind(':linkdescription', $linkdescription);
        $database->bind(':linkurl', $linkurl);
        $database->bind(':linkcategories', $linkcategories);
        $database->execute();
        
        if ($database->rowCount() == 1) {
			echo "The link was successfully entered into the database";
        }
    }
	else {
		echo "There are problems with your form. Please sort these out before continuing.<br/><br/>", $message;
    }
	
} // End of submitnewlink conditional

$database->query('SELECT * FROM `links` ORDER BY :name');
$database->bind(':name', 'name');
$rows = $database->resultSet();

if ($database->rowCount() > 0) {
	echo "<table>
	<tr>
	<td><strong>Name</strong></td>
	<td><strong>Link</strong></td>
	<td><strong>Description</strong></td>
	<td><strong>Category</strong></td>
	<td><strong>Edit</strong></td>
	<td><strong>Delete</strong></td>
	</tr>";
    foreach ($rows as $row) {	
		echo "<tr>
		<td>".$row['name']."</td>
		<td><a href=\"".$row['link']."\">".$row['link']."</a></td>
		<td>".$row['description']."</td>
		<td>".$row['category']."</td>
		<td><a href=\"edit_link.php?action=edit&amp;id=".$row['id']."\">Edit</a></td>
		<td><a href=\"edit_link.php?action=delete&amp;id=".$row['id']."\">Delete</a></td>
		</tr>";
    }
    echo "</table>";
}

$database->query('SELECT * FROM `categories` WHERE `type` = :link');
$database->bind(':link', 'link');
$rows = $database->resultSet();

if ($database->rowCount() > 0) {
	echo "<table>
	<tr>
	<td><strong>Category</strong></td>
	<td><strong>Edit</strong></td>
	<td><strong>Delete</strong></td>
	</tr>";
    foreach ($rows as $row) {	
		echo "<tr>
		<td>".$row['name']."</td>
		<td><a href=\"edit_category.php?action=edit&amp;id=".$row['id']."\">Edit</a></td>
		<td><a href=\"edit_category.php?action=delete&amp;id=".$row['id']."\">Delete</a></td>
		</tr>";
	}
	echo "</table>";
}

?>

<form action="<?php echo "/".$page; ?>" method="post" id="newlink">

<fieldset>

<legend>Insert a New Link</legend>

<table class="newlink">
<tr>

<td><label>Link</label></td>
<td><input type="text" name="linkurl" size="50" tabindex="1" value="<?php if (isset($_POST['linkurl'])) { echo $_POST['linkurl']; } ?>" id="url" /></td>

</tr>
<tr>

<td><label>Name</label></td>
<td><input type="text" name="linkname" size="50" tabindex="1" value="<?php if (isset($_POST['linkname'])) { echo $_POST['linkname']; } ?>" id="name" /></td>

</tr>
<tr>

<td><label>Description</label></td>

<td><input type="text" name="linkdescription" size="50" tabindex="1" value="<?php if (isset($_POST['linkdescription'])) { echo $_POST['linkdescription']; } ?>" id="description" /></td>

</tr>
<tr>

<td><label>Categories</label></td>

<td>

<?php

$database->query('SELECT * FROM `categories` WHERE `type` = :link');
$database->bind(':link', 'link');
$rows = $database->resultSet();
if ($database->rowCount() > 0) {
    foreach ($rows as $row) {
        $category = $row['name'];
        $categoryvalue = $row['id'];
        echo "<input type=\"radio\" name=\"categoryid[]\" value=\"".$categoryvalue."\" />".$category."<br/>", "\n";
    }
}

?>

</td>
</tr>

</table>

</fieldset>

<div align="center"><input type="submit" name="submitnewlink" value="Insert Link" /></div>

</form>

<br/><br/>

<form action="<?php echo "/".$page; ?>" method="post" id="newcategory">

<fieldset>

<legend>Submit a New Category</legend>

<table>
<tr>

<td><label>Category</label></td>
<td><input type="text" name="newcategory" size="50" tabindex="1" id="newcategoryname" /></td>

</tr>
<tr>

<td><label>Parent Category</label></td>
<td>

<?php

$database->query('SELECT * FROM `categories` WHERE `type`=:link');
$database->bind(':link', 'link');
$rows = $database->resultSet();
if ($database->rowCount() > 0) {
		echo "<select name=\"parent\" size=\"1\">\n";
		echo "<option value=\"0\">None</option>\n";
    foreach ($rows as $row) {
			$value = $row['id'];
			$name = $row['name'];
			echo "<option value=\"$value\">$name</option>\n";
    }
    echo "</select>\n";
}
	
?>

</td>

</tr>

</table>

<input type="hidden" name="newcategorytype" size="30" tabindex="1" id="type" value="link" />

</fieldset>

<div align="center"><input type="submit" name="submitnewcategory" value="Insert Category" /></div>

</form>
