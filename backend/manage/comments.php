<h1>Comments</h1>

<p>This is the comments section, where you can moderate comments left on your website.</p>

<?php

$query = "SELECT * FROM comments WHERE status = 'unapproved' ORDER BY timestamp DESC";
$result = @mysql_query($query);
$num = mysql_num_rows ($result);
if ($num > 0) {
	echo "<table class=\"todo\">
	<tr>
	<td><strong>Name</strong></td>
	<td><strong>Email</strong></td>
	<td><strong>Website</strong></td>
	<td><strong>Comment</strong></td>
	<td><strong>Timestamp</strong></td>
	<td><strong>Edit</strong></td>
	<td><strong>Delete</strong></td>
	<td><strong>Approve</strong></td>
	</tr>";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		echo "<tr>
		<td>".$row['name']."</td>
		<td><a href=\"mailto:".$row['email']."\">Email</a></td>
		<td><a href=\"".$row['website']."\">Website</a></td>
		<td>".substr($row['comment'], '0', '50')."</td>
		<td>".$row['timestamp']."</td>
		<td><a href=\"edit_comment.php?action=edit&amp;comment_id=".$row[id]."\">Edit</a></td>
		<td><a href=\"edit_comment.php?action=delete&amp;comment_id=".$row[id]."\">Delete</a></td>
		<td><a href=\"edit_comment.php?action=approve&amp;comment_id=".$row[id]."\">Approve</a></td>
		</tr>";
	}
	echo "</table>";
}

else {

}

$query = "SELECT * FROM comments WHERE status = 'approved' ORDER BY timestamp DESC";
$result = @mysql_query($query);
$num = mysql_num_rows ($result);
if ($num > 0) {
	echo "<table class=\"todo\">
	<tr>
	<td><strong>Name</strong></td>
	<td><strong>Email</strong></td>
	<td><strong>Website</strong></td>
	<td><strong>Comment</strong></td>
	<td><strong>Timestamp</strong></td>
	<td><strong>Edit</strong></td>
	<td><strong>Delete</strong></td>
	</tr>";
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		echo "<tr>
		<td>".$row['name']."</td>
		<td><a href=\"mailto:".$row['email']."\">Email</a></td>";
		if ($row['website'] != '') {
			echo "<td><a href=\"".$row['website']."\">Website</a></td>";
			}
		else {
			echo "<td></td>";
			}
		echo "<td>".$row['comment']."</td>
		<td>".$row['timestamp']."</td>
		<td><a href=\"edit_comment.php?action=edit&amp;comment_id=".$row[id]."\">Edit</a></td>
		<td><a href=\"edit_comment.php?action=delete&amp;comment_id=".$row[id]."\">Delete</a></td>
		</tr>";
	}
	echo "</table>";
}

else {

}

?>
