<?php require_once("../class/class.admin.php");
	$obj = new Admin();		
	$obj->AlreadyLogin();
	if(isset($_POST['btnlogin'])){
		if($_SESSION['security_code'] === $_POST['security_code']){
			$query = "select * from adminusers where email='".$obj->ReplaceSql($_POST['email'])."' and userpass='".$obj->Encrypt($_POST['userpass'])."'";
			if($data = $obj->SelectQuery($query)){
				$_SESSION['ADMIN_LOGIN'] = TRUE;
				$_SESSION['ADMIN_USER'] = $data[0]['email'];
				$_SESSION['GROUP_ID'] = $data[0]['group_id'];
				$_SESSION['ADMIN_USER_ID'] = $data[0]['admin_id'];
				$_SESSION['ADMIN_NAME'] = $data[0]['full_name'];
				header("Location:main.php");
			}else{
				$error = "Invalid User Name or password!";
			}
		} else {
			$error = "Invalid Security Code";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Admin Panel</title>
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
<script type="text/javascript" src="js/jquery.ajax.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<style>
body{ margin:0px; padding:0px;font-family:"Droid Sans"; font-size:12px;background:#fff; color:#000;}
.maincont{ margin:auto; width:700px;}
.topbar{ padding:5px 10px 0px 10px}
.topbar h3{ text-align:left; font-size:15pt; color:#000000;}
.outerdiv{ width:650px; margin:auto; border:#cdcdcd solid 1px; margin-top:50px; float:left;}
.matleft{ float:left; font-size:14px; width:160px; margin:15px 0 0 10px; text-align:left; }
.lock_img{ background:url(images/j_login_lock.jpg) no-repeat; width:152px; height:137px; float:left; margin:15px 0 25px 0;}
.formright{ float:right; border:#cdcdcd solid 1px; padding:10px; margin:15px 15px 15px 0px; width:380px; text-align:left}
.header{background:#1C1C1E; width:100%; float:left; color:#ffffff;}
.header h2,.header a{color:#ffffff}
</style>
</head>
<body>
<div class="header">
	<div class="cols40"><img src="images/blur-logo.png" height="29" width="72" alt="" vspace="10" /></div>
    <div class="cols60 txtright">
    	<h2>Welcome to <?php echo COMPANY_NAME;?> Admin Panel</h2>
        <a href="<?php echo WEBSITE_URL;?>" title="<?php echo COMPANY_NAME;?>">Return To Website</a>
    </div>
</div>
<div align="center">
<?php require_once("message.php");?>
<div class="maincont">
    <div class="outerdiv">
        <div class="topbar"><h3><?php echo COMPANY_NAME;?>! Administration Login</h3> 
        <?php if(isset($error)!=''){ echo "<h4 class='error' align='center'>".$error."</h4>";} ?>
        </div>
        <div class="matleft">Use a valid email and password to gain access to the Administrator Back-end.</div>
        <div class="formright">
        <form method="post" autocomplete="off" enctype="multipart/form-data" class="fullform" name="brandform" id="brandform" onsubmit="return validate(document.forms['brandform']);">
            <table cellpadding="5" cellspacing="1" align="center" width="100%">
                <tr>
                    <td width="130"><label for="email">Username : </label> <span class="error">*</span></td>
                    <td><input type="text" name="email" id="email" title="Username" class="R" /></td>
                </tr>
                <tr>
                    <td><label for="userpass">Password : </label> <span class="error">*</span></td>
                    <td><input type="password" name="userpass" id="userpass" title="Password" class="R" /></td>
                </tr>    
                <tr>
                    <td><label for="security_code">Security Code : </label> <span class="error">*</span></td>
                    <td><input type="text" name="security_code" id="security_code" title="Security Code" class="R" /></td>
                </tr>
                <tr>
                    <td>Security Code</td>
                    <td>
                    	<center>
                       		<img src="<?php echo WEBSITE_URL ?>/securitycode.php" id="scode" alt="securitycode" style="border:none" />
                      	  	<br />
                        	<a href="javascript:void(0);" onclick="$('#scode').attr('src','<?php echo WEBSITE_URL ?>/securitycode.php?id='+Math.random());">Refresh Code. Not Readable?</a>
                        </center>
                    </td>
                </tr>    
                <tr>
                    <td></td>
                    <td class="center">
                    	<input type="submit" class="button" name="btnlogin" value="Login Now" />&nbsp;&nbsp;
                        <input type="reset" class="button" name="btncancel" value="Cancel" />
                    </td>
                </tr>
            </table>
        </form>
        </div>
       	<div class="lock_img"></div>
    </div>
</div>
</div>
<?php include_once("footer.php");?>
</body>
</html>