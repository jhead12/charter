<?php
require_once("../class/class.admin.php");
	$obj = new Admin();
	$obj->RequireLogin(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include_once("inc.head.php"); ?>
</head>
<body>
<div class="cols100 txtcenter"><h1>Hey <?php echo $_SESSION['ADMIN_NAME'];?>!</h1></div>
<div class="cols100 txtcenter"><h2>Sorry, You are not authorised to view that page.</h2></div>
<?php require_once("message.php");?>  
<?php include_once("footer.php");?>
</body>
</html>