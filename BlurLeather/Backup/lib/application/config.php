<?php
	define("RDBMS", "mysql");
	define("DBSERVER", "p50mysql147.secureserver.net");
	define("DBUSER", "blur2129");
	define("DBPASSWORD", "Blur!@#2129");
	define("DBNAME", "blur2129");
	/*define("DBSERVER", "localhost");
	define("DBUSER", "root");
	define("DBPASSWORD", "rahasia");
	define("DBNAME", "blur");*/

    define("SMTP_SERVER", "cai.com");
    define("SMTP_USER", "jhoni.chen@cai.com");
    define("SMTP_PASSWORD", "rahasia");
    define("ADMIN_EMAIL", "jhoni.chen@cai.com");
    define("ISSMTP", 1);

    define("CONTACT_US_EMAIL", "jhoni_chen@yahoo.com");
    define("CONTACT_US_NAME", "Jhoni Chen");

	define("BASE_PATH", "/home/content/b/l/u/blurleather/html");
	define("BASE_URL", "http://www.blurleather.com");
	/*define("BASE_PATH", "C:/websites/blur");
	define("BASE_URL", "http://blur.cai.com");*/

    define("INCLUDE_PATH", BASE_PATH."/lib/application");

    define("IMAGE_PATH", BASE_PATH."/UserFiles/image");
    define("IMAGE_URL", BASE_URL.'/UserFiles/image');

    define("PRODUCT_PATH", IMAGE_PATH."/product");
    define("PRODUCT_URL", IMAGE_URL.'/product');

    define("ADMIN_URL", BASE_URL."/admin");

	define("PAGE_COUNT", 40);
	define("PAGING_NUMBER_COUNT", 10);

    function OutputDebug($error) {
        echo "$error\n";
    }

    ini_set('display_errors', 1);
    //date_default_timezone_set("Asia/Krasnoyarsk");

    function getCurrentDate() {
    	return date('Y-m-d H:i:s');
    }

    function trimText($str, $maxLength = 0) {
    	$str = trim($str);
    	if(ini_get('magic_quotes_gpc') == 0) {
    		$str = addslashes($str);
    	}
    	if($maxLength != 0) {
    		$str = substr($str, 0, $maxLength);
    	}
    	return $str;
    }
?>