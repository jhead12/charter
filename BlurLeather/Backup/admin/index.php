<?php
    session_start();
    if(file_exists("C:/websites/blur/admin/admin.class.php")) {
		require_once('C:/websites/blur/admin/admin.class.php');
	}
	else 
		require_once('/home/content/b/l/u/blurleather/html/admin/admin.class.php');
    $app = new admin();
?>