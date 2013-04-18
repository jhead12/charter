<?php require_once("../class/class.admin.php");
	$obj = new Admin();
	$obj->RequireLogin(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
</head>
<frameset rows="80,*" cols="100%" frameborder="0">
	<frame src="top.php" noresize="noresize" scrolling="no" />
    <frameset cols="220,*" frameborder="0">
		<frame src="left.php" noresize="noresize" />
	    <frame name="des" src="<?php echo (isset($_SESSION['CURRENT_URL']))? $_SESSION['CURRENT_URL']:'home.php';?>" noresize="noresize" />
    </frameset>
</frameset>
<noframes></noframes>
<?php include_once("footer.php");?>
</body>
</html>