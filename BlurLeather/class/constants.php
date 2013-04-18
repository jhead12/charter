<?php 
session_name("LeatherBlur");
session_start();
ini_set('post_max_size','20000M');
ini_set('upload_max_filesize','20000M');
ini_set('memory_limit', '20000M');
//https://sg2nlsmysqladm1.secureserver.net/grid50/217/index.php?lang=en-iso-8859-1&convcharset=iso-8859-1&collation_connection=utf8_unicode_ci&token=4e4cb1c7d7024fe0993976062a32fc95
define("COMPANY_NAME","Blur Leather ");
define("COMPANY_MAIL","info@blurleather.com");
define("SEND_MAIL",TRUE);
define("ENCRYPT_KEY","LeatherBlur");
define("DB_SERVER_TYPE","mysql");
if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='amarjeet-pc'){
	define("DB_SERVER_NAME","localhost");
	define("DB_USER_NAME","root");
	define("DB_USER_PASSWORD","");
	define("DB_DATABASE_NAME","leatherblur");
	define("WEBSITE_URL","http://".$_SERVER['HTTP_HOST']."/blur/");
	define("UPLOAD_PATH_ORG",$_SERVER['DOCUMENT_ROOT']."/blur/");
	define("UPLOAD_URL_ORG","http://".$_SERVER['HTTP_HOST']."/blur/");
}else{
	define("DB_SERVER_NAME","leatherbl.db.8745028.hostedresource.com");
	define("DB_USER_NAME","leatherbl");
	define("DB_USER_PASSWORD","Blur@Lea123");
	define("DB_DATABASE_NAME","leatherbl");
	define("WEBSITE_URL","http://".$_SERVER['HTTP_HOST']."/");
	define("UPLOAD_PATH_ORG",$_SERVER['DOCUMENT_ROOT']."/");
	define("UPLOAD_URL_ORG","http://".$_SERVER['HTTP_HOST']."/");
}
?>