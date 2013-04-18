<?php require_once("../class/class.admin.php");
	$obj = new Admin();
	$obj->RequireLogin(false);
	if(isset($_REQUEST['signout'])){
		$obj = new Admin();
		$obj->LogOut();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
<style>
@import url("css/fonts.css");
*{outline:none;font-family:"Droid Sans";}
body{ margin:0px; padding:10px 0px;font-family:"Droid Sans"; font-size:12px;background:#1C1C1E; color:#ffffff; min-width:1000px;}
h1,h2,h3,h4,h5,h6,p{margin:2px 0px; padding:2px 0px;}
a{text-decoration:underline; color:#ffffff;}
a:hover{ text-decoration:none; color:#ffffff;}
.txtright{ text-align:right}
.full{ clear:both; float:left; width:100%;}
.cols40{ float:left; width:37%; padding:3px 1%;}
.cols60{ float:left; width:58%; padding:3px 1%;}
</style>
<body>
<div class="full">
	<div class="cols40"><img src="images/blur-logo.png" height="29" vspace="10" width="72" alt="" /></div>
    <div class="cols60 txtright">
    	<h2>Welcome to <?php echo COMPANY_NAME;?> Admin Panel</h2>
        <big>Welcome <?php echo $_SESSION['ADMIN_NAME'];?>! <a href="?signout" title="<?php echo COMPANY_NAME;?>" target="_parent">Logout</a></big>
    </div>
</div>
</body>
</html>