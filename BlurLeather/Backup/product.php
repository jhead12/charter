<?php
    session_start();
    if(file_exists("C:/websites/blur/admin/blur.class.php")) {
    	require_once('C:/websites/blur/admin/blur.class.php');
    }
    else {
    	require_once('/home/content/b/l/u/blurleather/html/admin/blur.class.php');
    }
    $app = new blur();
?>