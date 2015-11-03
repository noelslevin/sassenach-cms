<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="distribution" content="global" />
<meta name="robots" content="follow, all" />
<meta name="language" content="en" />

<title><?php echo $sitename; ?>: Backend: <?php echo $pagetitle; ?></title>

<script language="javascript" type="text/javascript" src="<?php echo $globalhome; ?>backend/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	theme : "advanced",
	skin : "o2k7",
	mode : "textareas",
	relative_urls : false,
	remove_script_host : false,
	document_base_url : "<?php echo $globalhome; ?>uploads/"

});
</script>

<link rel="Shortcut Icon" href="<?php echo $globalhome; ?>includes/images/favicon.ico" type="image/x-icon" />
   
<style type="text/css" media="screen">
<!-- @import url( <?php echo $globalhome, $backend; ?>/includes/style.css ); -->
</style>
</head>
<body>

<div id="navbar">

	<ul>
		<li><a href="<?php echo $globalhome, $backend, $write; ?>">Write</a></li>
		<li><a href="<?php echo $globalhome, $backend, $manage; ?>">Edit</a></li>
		<li><a href="<?php echo $globalhome, $backend, $files; ?>">Files</a></li>
		<li><a href="<?php echo $globalhome, $backend, $links; ?>">Links</a></li>
		<li><a href="<?php echo $globalhome, $backend, $users ?>">Users</a></li>
		<li><a href="<?php echo $globalhome, $backend, $options; ?>">Options</a></li>
		<li><a href="<?php echo $globalhome, $backend, $comments; ?>">Comments</a></li>
		<li><a href="<?php echo $globalhome, $backend, $help; ?>">Docs</a></li>
		<li><a href="<?php echo $globalhome, $backend, $todo; ?>">To Do</a></li>
		<li><a href="<?php echo $globalhome, $backend, $logout; ?>">Log Out</a></li>
		<li><a href="<?php echo $globalhome; ?>">Site Home</a></li>
			</ul>
</div>

<div id="content">

<div id="wrap">
