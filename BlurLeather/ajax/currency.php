<?php
	require_once("../class/class.functions.php");
	$fn = new Functions();
	header('Content-Type: text/html; charset=iso-8859-1');
	if($_POST['type']=="country"){
		$_SESSION['CURRENCY'] = $_POST['currency'];
		$_SESSION['COUNTRY_ID'] = $_POST['country_id'];
		$_SESSION['COUNTRY_TITLE'] = $_POST['country_title'];
		echo "script|g|Country Changed|g|window.parent.location.reload();";
	}
?>