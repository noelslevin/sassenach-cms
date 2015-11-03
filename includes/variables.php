<?php
$globalhome = ''; // This is the home page for the main site. 
$mysqlconnect = 'includes/connection.php'; // This is the path to the MySQL database connection. 
$sitename = ''; // The name of the website, to appear in the title bar. 
$globalrss = 'rss.xml'; // The location of the site\'s main RSS file. 
$backend = 'backend/'; // The location of the backend admin pages. 
$write = 'write/'; // The location of the \'write\' backend pages. 
$manage = 'manage/'; // The location of the \'manage\' admin pages. 
$options = 'config/'; // The layout of the \'options\' admin pages (like this one!). 
$help = 'documentation/'; // The location of the admin documentation and general help. 
$todo = 'todo/'; // The location of the task list for administrators. 
$style = 'sassenach/'; // The active administration theme. 
$uploads = 'uploads/'; // The location of the uploads directory, relative to the root installation of the software. 
$global = '/'; // This is the global home, relative to the root public directory. 
$categorybase = 'category/'; // This is the base url, relative to the variable, for the category archives. If left undefined, it will clash with page urls, unless page urls are altered. 
$status = 'up'; // This determines whether the site is enabled or disabled. If status is set to \'up\', it is enabled, but for any other value, it is disabled. 
$offline = '<h1>Down For Maintenance</h1>

<p>The site is currently down whilst an upgrade is installed.</p>'; // This is the message that is shown to people when the website is offline for upgrades and maintenance. 
$comment_status = 'on'; // This determines whether comments can be left and seen on the website. 
?>
