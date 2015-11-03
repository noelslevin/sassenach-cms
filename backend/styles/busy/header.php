<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="follow, all" />
<meta name="language" content="en, sv" />
<meta name="description" content="" />
<meta name="keywords" content="" />


<title><?php echo $sitename; ?></title>

<link rel="Shortcut Icon" href="<?php echo $globalhome.$backend.'styles/'.$style;?>/images/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="<?php echo $globalhome.$backend.'styles/'.$style.'style.css'; ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $sitename; ?>" href="<?php echo $globalhome, $globalrss; ?>" />
</head>



<body>

<?php get_sassenach_function('dashboard'); ?>

<div id="page">
<div id="header">
<h1><a href="<?php echo $globalhome; ?>"><?php echo $sitename; ?></a></h1>
</div>
<div id="links">

<ul>

<li><a href="<?php echo $globalhome; ?>">Home</a></li>

<?php

$query = "SELECT * FROM pages WHERE parent='0' AND status='published' ORDER BY title ASC";
$result = @mysql_query ($query);
$num = mysql_num_rows ($result);
if ($num > 0) {

    while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {
        echo "<li><a href=\"".$globalhome.$row['url']."/\">".$row['title']."</a></li>\n";
    
    }

}

?>

</ul>

</div>

<div id="wrap">
