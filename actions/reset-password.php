<?php

// Page specific variables go here.

$pagetitle="Reset Password";

include '../includes/variables.php';

function get_sassenach_function($function) {
	global $backend;
	$sassenach_function = '../'.$backend.'functions/'.$function.'.php';
	include $sassenach_function;
	}

include '../includes/connection.php';
include '../'.$backend.'styles/'.$style.'header.php';

echo "<div class=\"content\">";

echo "<h1>Reset Password</h1>";

if (isset($_POST['new_password'])) {
	$user_id = $_POST['user_id'];
	$newpassword1 = addslashes($_POST['newpassword1']);
	$newpassword2 = addslashes($_POST['newpassword2']);
	$password = md5($newpassword1);
	if ($newpassword1 == $newpassword2) {
		$query = "UPDATE users SET string=NULL, password='$password' WHERE user_id='$user_id'";
		$result = @mysql_query($query);
		if ($result) {
			echo "<p>Your password was successfully changed. Hurrah! Don't forget it this time...</p>";
			}
		else {
			"<p>Your password was not changed.</p>";
			"<p>".mysql_error."</p>";
			}
		}
	else {
		echo "<p>Your passwords do not match. Your password has not been reset.</p>";
		}
	}

else if (isset($_GET['code'])) {
	$code = $_GET['code'];
	$user_id = $_GET['user_id'];
	$query = "SELECT * FROM users WHERE user_id='$user_id' AND string='$code'";
	$result = @mysql_query ($query);
	$num = mysql_num_rows ($result);
	if ($num == 1) {
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			echo "<p>We've managed to salvage your account! How about you keep the password in your mind this time?</p>";
			echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">
			<fieldset>
			<p>New Password:<br/>
			<input type=\"password\" name=\"newpassword1\" size=\"30\" maxlength=\"16\" /></p>
			<p>Just to make sure:<br/>
			<input type=\"password\" name=\"newpassword2\" size=\"30\" maxlength=\"16\" /></p>
			</fieldset>
			<input type=\"hidden\" name=\"user_id\" value=\"".$user_id."\" />
			<input type=\"submit\" name=\"new_password\" value=\"Reset Password\" />
			</form>\n";
			}
		}
	else {
		echo "<p>The requested user could not be found on the database, or the credentials you supplied are incorrect.</p>";
		}
	}

else if (isset($_POST['submit'])) {

	$email = $_POST['email'];
	$username = $_POST['username'];
    
	$query = "SELECT * FROM users WHERE username = '$username' AND email = '$email'";
	$result = mysql_query ($query);
	$num = mysql_num_rows($result);
	if ($num == 1) {
    
		while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
			$user_id = $row['user_id'];
			$registered = $row['registered'];
			$string = md5($username.$row['password'].time());
			
			$query2 = "UPDATE users SET string = '$string' WHERE username = '$username'";
			$result2 = mysql_query ($query2);
            
			if ($result2) {
    
				echo "<p>Well, at least you got that bit right. We're emailing you an activation code right now. You can use that to gain access to your account, where you will need to reset your password as it is encrypted in the system and, therefore, not retrievable.</p>";

				$to = $email;
				$subject = "Password reset request for ". $sitename;
				$body = "A request was made to reset the password for your account at ". $globalhome . ".\n\n Please follow the following link to reset your password:\n\n" . $globalhome . "backend/reset_password.php?user_id=". $user_id . "&amp;code=" . $string."\n\nIf you have not requested this, you can safely ignore this message.";
				$headers = 'From: support.no.reply@noelinho.org' . "\r\n" .
				'Reply-To: sassenach@noelinho.org' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
				
				if (mail($to, $subject, $body ,$headers)) {
					echo "<p>Message successfully sent!</p>";
					}

				else {
					echo "<p>Message delivery failed... The mail server is probably not set up properly. Please inform the system administrator.</p>";
					}
				}
    
			else {
				echo "<p>Sorry, the system was not able to activate your password at this time.</p>";
				}
			}
		}
	else {
		echo "<p>Sorry, the details you entered were not found in the database.</p>";
		}
	}
else {

	echo "<p>In order to reset your password, you will need to know your username, the email address registered to your account and have access to that email account.</p>

	<form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\" id=\"login\">

	<fieldset>
	<legend>Password Reset</legend>

	<div align=\"center\">
	<table>
	<tr>
	<td><label>User Name:</label></td>
	<td><input type=\"text\" name=\"username\" size=\"30\" maxlength=\"20\" value=\""; if (isset($_POST['username'])) echo $_POST['username']; echo "\" /></td>
	</tr>
	<tr>
	<td><label>Email Address:</label></td>
	<td><input type=\"text\" name=\"email\" size=\"30\" maxlength=\"50\" /></td>
	</tr>
	</table>
	<input type=\"submit\" name=\"submit\" value=\"Reset My Password!\" />
	</div>
	</fieldset>
	</form>\n";
	}
	
echo "</div>";

include '../'.$backend.'styles/'.$style.'footer.php';

?>
