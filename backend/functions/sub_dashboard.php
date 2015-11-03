<?php

if (!function_exists('sub_dashboard')) {
	function sub_dashboard() {
		
		global $globalhome, $backend, $write, $manage, $help, $options, $page;
		echo "<div id=\"sub_dashboard\">
		<ul>\n";
		if ($page == 'write') {
			echo "<li><a href=\"".$globalhome.$backend.$page."/post.php\">Post</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/page.php\">Page</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/link.php\">Link</a></li>\n";
			}
		else if ($page == 'manage') {
			echo "<li><a href=\"".$globalhome.$backend.$page."/posts.php\">Posts</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/pages.php\">Pages</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/links.php\">Links</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/comments.php\">Comments</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/files.php\">Files</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/categories.php\">Categories</a></li>\n";
			}
		else if ($page == 'config') {
			echo "<li><a href=\"".$globalhome.$backend.$page."/users.php\">Users</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/variables.php\">Variables</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/phpinfo.php\">PHP Config</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/write_variables.php\">Write Variables</a></li>
			<li><a href=\"".$globalhome.$backend.$page."/console.php\">Console</a></li>\n";
			echo "<li><a href=\"".$globalhome.$backend.$options."profile.php\">Profile</a></li>\n";
			}			
		else if ($page == NULL) {
			echo "<li><a href=\"".$globalhome.$backend.$options."profile.php\">Profile</a></li>\n";
			}
		echo "</ul>
		</div>\n";
		
		}
	}

sub_dashboard();

?>
