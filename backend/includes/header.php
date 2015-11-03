<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="distribution" content="global" />
<meta name="robots" content="follow, all" />
<meta name="language" content="en" />

<title><?php echo $sitename; ?>: Backend: <?php echo $pagetitle; ?></title>

<link rel="Shortcut Icon" href="<?php echo $globalhome; ?>includes/images/favicon.ico" type="image/x-icon" />
   
<style type="text/css" media="screen">
@import url( <?php echo $globalhome, $backend; ?>/includes/style.css );
</style>
</head>
<body>

<?php get_sassenach_function(backend_dashboard); ?>

<div id="page">

<div id="content">

<div id="wrap">
