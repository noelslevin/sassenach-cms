<?php

if (!function_exists('dashboard')) {
	function dashboard() {
		
		global $globalhome, $backend, $write, $manage, $help, $options;
		if (isset($row['role'])) { 
		$role = $row['role']; 
		}
		else {
		$role = "user";
		}
		echo "<div id=\"dashboard\">
		<ul>\n";
		if (isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$query = "SELECT * FROM users WHERE username = '$username'";
		$result = @mysql_query ($query);
		$num = mysql_num_rows ($result);
		if ($num > 0) {
		
			while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
				echo "<li><a href=\"".$globalhome."\">Home</a></li>
				<li><a href=\"".$globalhome.$backend."\">Dashboard</a></li>
				<li><a href=\"".$globalhome.$backend.$write."\">Write</a></li>
				<li><a href=\"".$globalhome.$backend.$manage."\">Manage</a></li>
				<li><a href=\"".$globalhome.$backend.$help."\">Help</a></li>\n";
				if ($role == 'superuser' OR 'administrator') {
					echo "<li><a href=\"".$globalhome.$backend.$options."\">Config</a></li>\n";
					}
				echo "<li><a href=\"".$globalhome."actions/logout.php\">Log Out</a></li>\n";
				}
			}
			
			}
		else {
			echo "<li><a href=\"".$globalhome."\">Home</a></li>
			<li><a href=\"".$globalhome."actions/login.php\">Log In</a></li>
			<li><a href=\"".$globalhome."actions/sign-up.php\">Sign Up!</a></li>\n";
			}
		
		echo "</ul>
		</div>\n";
		
		}
	}

dashboard();

?>
