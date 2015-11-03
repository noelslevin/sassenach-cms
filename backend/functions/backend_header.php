<?php

global $pagetitle, $globalhome, $backend;
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head profile=\"http://gmpg.org/xfn/11\">
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<meta name=\"distribution\" content=\"global\" />
<meta name=\"robots\" content=\"follow, all\" />
<meta name=\"language\" content=\"en\" />

<title>".$pagetitle."</title>

<link rel=\"Shortcut Icon\" href=\"".$globalhome."includes/images/favicon.ico\" type=\"image/x-icon\" />
<link rel=\"stylesheet\" type=\"text/css\" href=\"".$globalhome.$backend."includes/style.css\" />
</head>
<body>\n";

get_sassenach_function('dashboard');

echo "<div id=\"page\">
<div id=\"content\">\n";
get_sassenach_function('sub_dashboard');
echo "<div id=\"wrap\">\n";
?>
