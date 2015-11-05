<?php

// File specific variables go here.

$pagetitle="Install Sassenach CMS: Setting Up The Database";

?>

<?php include 'header.php'; ?>

<h1>Setting Up The Database</h1>

<?php

if (isset($_POST['submit'])) {
	include ('../../includes/connection.php');
	$score = 0;
	$db_insert = mysql_query("DROP TABLE IF EXISTS `categories`");
	echo "<p>Dropping table 'categories': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query("CREATE TABLE IF NOT EXISTS `categories` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `parent` varchar(30) NOT NULL default '' COMMENT 'The parent category, if this is a subcategory',
  `type` enum('post','link') NOT NULL default 'post',
  `url` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `url` (`url`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3");
	echo "<p>Creating table 'categories': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query("INSERT INTO `categories` (`id`, `name`, `parent`, `type`, `url`) VALUES
(1, 'General', 'Yes', 'post', 'general'),
(2, 'General Links', 'Yes', 'link', 'general-links')");
	echo "<p>Inserting records into 'categories': ";
	if (mysql_affected_rows()  == 2) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query ("DROP TABLE IF EXISTS `comments`");
	echo "<p>Dropping table 'comments': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query ("CREATE TABLE IF NOT EXISTS `comments` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `email` varchar(40) NOT NULL default '',
  `website` varchar(50) default NULL,
  `status` enum('approved','unapproved') NOT NULL default 'unapproved',
  `post_id` mediumint(8) NOT NULL default '0',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `comment` longtext NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
	echo "<p>Creating table 'comments': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query("DROP TABLE IF EXISTS `files`");
	echo "<p>Dropping table 'files': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


$db_insert = mysql_query("CREATE TABLE IF NOT EXISTS `files` (
  `id` mediumint(9) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `filesize` varchar(10) NOT NULL default '',
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
	echo "<p>Creating table 'files': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query("DROP TABLE IF EXISTS `links`");
	echo "<p>Dropping table 'links': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}

	
	$db_insert = mysql_query("CREATE TABLE IF NOT EXISTS `links` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `description` varchar(64) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `category` mediumint(8) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2");
	echo "<p>Creating table 'links': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query("INSERT INTO `links` (`id`, `name`, `description`, `link`, `category`) VALUES
(1, 'Sassenach CMS', 'This website runs on Sassenach CMS!', 'http://www.sassenach-cms.org', 2)");
	echo "<p>Incerting records into 'links': ";
	if (mysql_affected_rows() == 1) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query("DROP TABLE IF EXISTS `options`");
	echo "<p>Dropping table 'options': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query("CREATE TABLE IF NOT EXISTS `options` (
  `id` mediumint(8) NOT NULL auto_increment,
  `variable` varchar(30) NOT NULL default '',
  `value` varchar(100) NOT NULL default '',
  `function` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `variable` (`variable`)
) ENGINE=INNODB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20");
	echo "<p>Creating table 'options': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query("INSERT INTO `options` (`id`, `variable`, `value`, `function`) VALUES
(1, 'globalhome', '', 'This is the home page for the main site.'),
(2, 'mysqlconnect', 'includes/connection.php', 'This is the path to the MySQL database connection.'),
(3, 'sitename', '', 'The name of the website, to appear in the title bar.'),
(4, 'globalrss', 'rss.xml', 'The location of the site''s main RSS file.'),
(5, 'backend', 'backend/', 'The location of the backend admin pages.'),
(6, 'write', 'write/', 'The location of the ''write'' backend pages.'),
(7, 'manage', 'manage/', 'The location of the ''manage'' admin pages.'),
(8, 'links', 'links/', 'The location of the ''links'' admin pages.'),
(9, 'users', 'users/', 'The location of the ''users'' admin pages.'),
(10, 'options', 'config/', 'The layout of the ''options'' admin pages (like this one!).'),
(11, 'comments', 'comments/', 'The location of the ''comments'' admin pages.'),
(12, 'help', 'documentation/', 'The location of the admin documentation and general help.'),
(13, 'logout', 'logout.php', 'The location of the logout script for the backend.'),
(18, 'todo', 'todo/', 'The location of the task list for administrators.'),
(14, 'style', 'busy/', 'The active administration theme.'),
(15, 'files', 'files/', 'The location of the ''files'' admin pages.'),
(16, 'uploads', 'uploads/', 'The location of the uploads directory, relative to the root installation of the software.'),
(17, 'global', '/', 'This is the global home, relative to the root public directory.'),
(19, 'categorybase', 'category/', 'This is the base url, relative to the $globalhome variable, for the category archives. If left undefined, it will clash with page urls, unless page urls are altered.'),
(20, 'status', 'down/', 'This determines whether the site is enabled or disabled. If status is set to ''up'', it is enabled, but for any other value, it is disabled.'),
(21, 'offline', '<h1>Down For Maintenance</h1>\n\n<p>The site is currently down whilst an upgrade is installed.</p>', 'This is the message that is shown to people when the website is offline for upgrades and maintenance.'),
(22, 'comment_status', 'on', 'This determines whether comments can be left and seen on the website.')");
	echo "<p>Inserting records into 'options': ";
	if (mysql_affected_rows() == 22) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


	$db_insert = mysql_query("DROP TABLE IF EXISTS `pages`");
	echo "<p>Dropping table 'pages': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}

		
	$db_insert = mysql_query("CREATE TABLE IF NOT EXISTS `pages` (
  `id` mediumint(8) NOT NULL auto_increment,
  `title` text NOT NULL,
  `url` varchar(100) NOT NULL default '',
  `author` mediumint(8) NOT NULL default '0',
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NULL default '0000-00-00 00:00:00',
  `status` enum('draft','published') NOT NULL default 'draft',
  `parent` mediumint(8) NOT NULL default '0',
  `content` longtext NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
	echo "<p>Creating table 'pages': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


$db_insert = mysql_query("DROP TABLE IF EXISTS `posts`");
echo "<p>Dropping table 'posts': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


$db_insert = mysql_query("CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` mediumint(8) unsigned NOT NULL auto_increment,
  `author` mediumint(8) NOT NULL default '0',
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime default NULL,
  `categories` varchar(255) NOT NULL default '1' COMMENT 'Each number refers to the relevant category id in the ''categories'' table.',
  `status` enum('draft','published') NOT NULL default 'draft',
  `frontpage` enum('yes','no') NOT NULL default 'yes',
  `url` varchar(100) NOT NULL default '',
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
echo "<p>Creating table 'posts': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


$db_insert = mysql_query("DROP TABLE IF EXISTS `todo`");
echo "<p>Dropping table 'todo': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


$db_insert = mysql_query("CREATE TABLE IF NOT EXISTS `todo` (
  `id` mediumint(8) NOT NULL auto_increment,
  `name` varchar(30) NOT NULL default '',
  `description` longtext NOT NULL,
  `status` enum('Implemented','In Progress','Stalled') NOT NULL default 'Implemented',
  `importance` enum('5','4','3','2','1') NOT NULL default '5',
  `author` mediumint(8) NOT NULL,
  `timestamp` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
echo "<p>Creating table 'todo': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


$db_insert = mysql_query("DROP TABLE IF EXISTS `users`");
echo "<p>Dropping table 'users': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}


$db_insert = mysql_query("CREATE TABLE IF NOT EXISTS `users` (
  `user_id` mediumint(8) unsigned NOT NULL auto_increment,
  `firstname` varchar(20) NOT NULL default '',
  `lastname` varchar(20) NOT NULL default '',
  `username` varchar(20) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `email` varchar(40) NOT NULL default '',
  `registered` datetime NOT NULL default '0000-00-00 00:00:00',
  `string` char(32) NULL,
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
echo "<p>Creating table 'users': ";
	if ($db_insert) {
		$score = $score+1;
		echo "<span style='background-color: green'>Success</span></p>";

		}
	else {
		echo $score = $score;
		echo "<span style='background-color: red'>Fail</span></p>";
		}

	if ($score == 21) {
		echo "<p>The database is now ready to use.</p>";
		echo "<p><a href=\"site_details.php\">Continue</a></p>";		
		}
	else {
		echo "<p>Not everything was imported properly. The script cannot continue until this has been successful. Either try again, or manually import the <a href=\"sassenach.sql\">SQL file</a> using a tool like <a href=\"http://www.phpmyadmin.net/\">phpMyAdmin</a>.</p>";
		echo "<p>Have you <a href=\"site_details.php\">done this</a>?</p>";
	
	}
	}
else {

	echo "<p>Having connected to the database, we now need to create the database structure the system uses. Please note, any tables with the same names as the Sassenach tables will be overwritten, and so it is recommended that you use an empty database.</p>";

	echo "<p>If you are using a database that is not empty, please back it up before continuing, and check that the tables Sassenach is about to create will not interfere with any existing data.</p>";

	echo "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
	echo "<input type=\"submit\" name=\"submit\" value=\"Populate Database\" />";
	echo "</form>";
	}

?>

<?php include 'footer.php'; ?>
