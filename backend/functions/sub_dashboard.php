<?php

if (!function_exists('sub_dashboard')) {
	function sub_dashboard() {
		
        $subdashdata = NULL;
        $subpages = NULL;
        $parsedpart = NULL;
		global $globalhome, $backend, $write, $manage, $help, $options, $parts;
        
        if (isset($parts[1])) {
            $parsedpart = $parts[1];
        }
        else {
            $parsedpart = 'dashboard';
        }
        
        $subdashdata .= "<div id=\"sub_dashboard\">\n";
        if ($parsedpart == 'write') {
            $subpages = array('post', 'page', 'link');
        }
        elseif ($parsedpart == 'manage') {
            $subpages = array('posts', 'pages', 'links', 'comments', 'files', 'categories');
        }
        elseif ($parsedpart == 'documentation') {

        }
        elseif ($parsedpart == 'config') {
            $subpages = array('users', 'variables', 'php-config');
        }
        elseif ($parsedpart == 'dashboard') {
            $subpages = array('profile');
        }
        
        if (isset($subpages)) {
            $subdashdata .= "<ul>\n";
            foreach ($subpages as $subpage) {
                $subdashdata .= "<li><a href=\"".$globalhome.$backend.$parts[1]."/".$subpage."\">".$subpage."</a></li>\n";
            }
            $subdashdata .= "</ul>\n";
        }
        $subdashdata .= "</div>\n";
        echo $subdashdata;
    }
}

sub_dashboard();
        
?>
